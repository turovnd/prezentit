<?php defined('SYSPATH') or die('No direct script access.');


class Model_Uploader extends Model
{
    const SLIDE_BACKGROUND   = 1;
    const SLIDE_ANSWER_IMAGE = 2;

    private $images = array(
        self::SLIDE_BACKGROUND,
        self::SLIDE_ANSWER_IMAGE
    );

    /** @var upload module configuration */
    private $config;

    private $type;

    public $filename;
    public $file_hash_hex;
    public $filepath;
    public $small_filepath;
    public $mime;

    public function __construct($id = null, $file_hash_hex = null, $row = array())
    {
        $this->config = Kohana::$config->load('upload');

        if (!$id && !$file_hash_hex && !$row) return;
    }

    /**
     * Returns uploaded file path by type and filename
     * @uses  config/upload.php
     * @return string filepath from base dir
     */
    private function getFilePath()
    {
        return $this->config[$this->type]['path'] . $this->filename;
    }

    /**
     * Uploads file to the server
     * @param $type - (int) file type constant
     * @param $file - (array) file object
     * @param $user_id - (int) author
     * @param $params - (Object) $params
     * @return array - (String) uploaded file name
     */
    public function upload($type, $file, $user_id, $params)
    {
        $this->type = $type;
        $config = $this->config[$this->type];

        $path   = $config['path'];

        $isImage = in_array($type, $this->images);

        if (!$isImage) {
            $savedFilename = $this->saveFile($file, $path);
        } else {
            $savedFilename = $this->saveImage($file, $path, $config['sizes']);
        }

        /** Check for uploading error */
        if (!$savedFilename) {
            return false;
        }

        switch ($type) {
            case self::SLIDE_BACKGROUND:
                $this->filename = $savedFilename;
                break;

            case self::SLIDE_ANSWER_IMAGE:
                $this->filename = $savedFilename;

        }

        $this->small_filepath  = DIRECTORY_SEPARATOR . $path . 's_' . $this->filename;
        $this->filepath  = DIRECTORY_SEPARATOR . $path . 'o_' . $this->filename;
        $this->author    = $user_id;

        return array(
            'filename'       => $this->filename,
            'filepath'       => $this->filepath,
            'icon_filepath' => $this->small_filepath,
        );
    }

    /**
     * Returns file extension by mime-type
     * @return string  extension
     */
    public function getOriginalName($filepath){
        $info = pathinfo($filepath);
        return $info['filename'];
    }

    /**
     *   Функция для скачивания файла
     *   Источник: https://habrahabr.ru/post/151795/
     */
    public function returnFileToUser()
    {
        if (file_exists($this->filepath)) {
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) ob_end_clean();
            // заставляем браузер показать окно сохранения файла
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $this->filename);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($this->filepath));
            // читаем файл и отправляем его пользователю
            readfile($this->filepath);
            exit;
        }
    }

    /**
     * Files uploading section
     */
    public function saveImage($file , $path, $sizesConfig)
    {
        /**
         *   Проверки на  Upload::valid($file) OR Upload::not_empty($file) OR Upload::size($file, '2M') делаются в контроллере.
         */
        if (!Upload::type($file, array('jpg', 'jpeg', 'png', 'gif'))) return FALSE;
        if (!is_dir($path)) mkdir($path);
        $file = Upload::save($file, NULL, $path);
        if (!$file) {
            return false;
        }
        $this->file_hash_hex = bin2hex(openssl_random_pseudo_bytes(16));
        $filename = $this->file_hash_hex . '.jpg';
        foreach ($sizesConfig as $prefix => $sizes) {
            /**
             * Все операции делаем с исходным файлом.
             * Для этого заново его загружаем в переменную
             */
            $image = Image::factory($file);
            $isSquare = !!$sizes[0];
            $width    = Arr::get($sizes, 1, null);
            $height   = !$isSquare ? Arr::get($sizes, 2, null) : $width;
            $image->background('#fff');
            // Вырезание квадрата
            if ($isSquare) {
                if ($image->width >= $image->height) {
                    $image->resize( NULL , $height, Image::AUTO );
                } else {
                    $image->resize( $width , NULL, Image::AUTO );
                }
                $image->crop( $width, $height );
            } else {
                if ( $image->width > $width || $image->height > $height  ) {
                    $image->resize( $width , $height , Image::AUTO );
                }
            }
            $image->save($path . $prefix . '_' . $filename);
        }
        // Delete the temporary file
        unlink($file);
        return $filename;
    }

    /**
     * Saves file to the server
     *
     * @param  array    $file   file array from input
     * @param  string   $path   path to store file
     * @return string   saved file name
     *
     * @todo  Add translited file title to file name
     * @todo  Check extension by mime type — see https://kohanaframework.org/3.3/guide-api/File#mime
     */
    public function saveFile($file , $path)
    {
        /**
         *   Проверки на  Upload::valid($file) OR Upload::not_empty($file) OR Upload::size($file, '2M') делаются в контроллере.
         */
        if (!is_dir($path)) mkdir($path);
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $this->file_hash_hex = bin2hex(openssl_random_pseudo_bytes(16));
        $filename = $this->file_hash_hex . '.' . $ext;
        $file = Upload::save($file, $filename, $path);
        if ($file) return $filename;
        return FALSE;
    }

}