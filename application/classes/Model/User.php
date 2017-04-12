<?php defined('SYSPATH') or die('No direct script access.');


Class Model_User {

    public $id;
    public $name;
    public $email;
    public $newsletter;
    public $is_confirmed;
    public $dt_create;


    /**
     * Model_User constructor.
     * get user info if data exist
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

        $select = Dao_Users::select()
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

        $select = Dao_Users::select()
            ->where($field, '=', $value)
            ->limit(1)
            ->execute();

        $user = new Model_User($select['id']);
        return $user->fill_by_row($select);

    }


    /**
     * Saves User to Database
     */
     public function save()
     {

        $this->dt_create = Date::formatted_time('now');

        $insert = Dao_Users::insert();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        $result = $insert->execute();

        return $this->get_($result);
     }

    /**
     * Updates user data in database
     *
     * @return Model_User
     */
     public function update()
     {

        $insert = Dao_Users::update();

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

         $selection = Dao_Users::select(array('password'))
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

         $insert = Dao_Users::update()
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
        $select = Dao_Users::select('id')
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