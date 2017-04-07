<?php defined('SYSPATH') or die('No direct script access.');


Class Model_Presentation {

    /**
     * @var $id_user
     */
    public $id;

    /**
     * @var $name
     */
    public $name;

    /**
     * @var $uri
     */
    public $uri;

    /**
     * @var $short_uri
     */
    public $short_uri;

    /**
     * @var $owner
     */
    public $owner;

    /**
     * @var $dt_update
     */
    public $dt_update;

    /**
     * @var $dt_create
     */
    public $dt_create;


    /**
     * Model_Presentation constructor.
     * get presentation info if data exist
     */
    public function __construct($id = null) {

        if ( !empty($id) ) {
            $this->get_($id);
        }

    }

    private function fill_by_row($db_selection) {

        if (empty($db_selection['id'])) return $this;

        foreach ($db_selection as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $this->$fieldname = $value;
        }

        return $this;

    }

    private function get_($id) {

        $select = Dao_Presentations::select()
            ->where('id', '=', $id)
            ->limit(1)
            ->cached(Date::MINUTE * 5, $id)
            ->execute();

        $this->fill_by_row($select);

        return $this;

    }


    /**
     * @param $field
     * @param $value
     * @return $this|array|bool|mixed|object
     */
    public static function getByFieldName($field, $value) {

        $select = Dao_Presentations::select()
            ->where($field, '=', $value)
            ->limit(1)
            ->execute();

        $presentation = new Model_Presentation($select['id']);
        return $presentation->fill_by_row($select);

    }


    /**
     * Saves User to Database
     */
     public function save()
     {
        $this->dt_create = Date::formatted_time('now');
        $this->dt_update = Date::formatted_time('now');

        $insert = Dao_Presentations::insert();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        $id = $insert->execute();

        $present = $this->get_($id);

        $present->uri = hash('md5', $id . $_SERVER['SALT']);
        $present->short_uri = hash('adler32', $id . $_SERVER['PRESENTATIONMOBILESALT']);
        $present->update();

        return $present;
     }

    /**
     * Updates user data in database
     *
     * @return Model_User
     */
     public function update()
     {

        $insert = Dao_Presentations::update();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        $insert->clearcache($this->id);
        $insert->where('id', '=', $this->id);

        $id = $insert->execute();

        return $this->get_($this->id);
     }


    /**
     * Checking Password before changing
     *
     * @param $pass
     * @return bool
     */
     public function checkPassword ($pass) {

         $selection = Dao_Presentations::select(array('password'))
                        ->where('id', '=', $this->id)
                        ->limit(1)
                        ->execute();

         $password = $selection['password'];

         return $password == $pass;
     }


    /**
     * Change password
     *
     * @param $newpass
     * @return object
     */
     public function changePassword ($newpass) {

         $insert = Dao_Presentations::update()
                    ->set('password', $newpass)
                    ->where('id', '=', $this->id)
                    ->clearcache($this->id)
                    ->execute();

         return $insert;

     }


    /**
     * Checks for existence by searching field
     *
     * @param $field
     * @param $value
     * @return bool
     */
    public static function isUserExist($value, $field = 'email') {
        $select = Dao_Presentations::select('id')
                ->where($field, '=', $value)
                ->limit(1)
                ->execute();

        if (!empty($select['id'])) {
            return true;
        } else {
            return false;
        }
    }

}