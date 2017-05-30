<?php

class Model_Response_Uploader extends Model_Response_Abstract
{
    protected $_UPLOADER_NO_USER_ERROR = array (
        'type' => 'upload',
        'code' => '80',
        'message' => 'Access denied'
    );

    protected $_UPLOADER_NO_TYPE_ERROR = array (
        'type' => 'upload',
        'code' => '81',
        'message' => 'Transport type missed'
    );

    protected $_UPLOADER_WRONG_TYPE_ERROR = array (
        'type' => 'upload',
        'code' => '82',
        'message' => 'Wrong type passed'
    );

    protected $_UPLOADER_FILE_SIZE_ERROR = array (
        'type' => 'upload',
        'code' => '83',
        'message' => 'File size exceeded limit'
    );

    protected $_UPLOADER_FILE_NOT_TRANSFERRED_ERROR = array (
        'type' => 'upload',
        'code' => '84',
        'message' => 'File was not transferred'
    );

    protected $_UPLOADER_FILE_EMPTY_ERROR = array (
        'type' => 'upload',
        'code' => '85',
        'message' => 'File is empty'
    );

    protected $_UPLOADER_FILE_DAMAGED_ERROR = array (
        'type' => 'upload',
        'code' => '86',
        'message' => 'Uploaded file is damaged'
    );

    protected $_UPLOADER_FILE_ERROR = array (
        'type' => 'upload',
        'code' => '87',
        'message' => 'Error while uploading'
    );

    protected $_UPLOADER_FILE_SUCCESS = array (
        'type' => 'upload',
        'code' => '88',
        'message' => 'File has been uploaded'
    );



}