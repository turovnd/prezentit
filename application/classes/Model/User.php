<?php defined('SYSPATH') or die('No direct script access.');


Class Model_User {

    /**
     * @var $id_user
     */
    public $id;

    /**
     * @var $lastname
     */
    public $lastname;

    /**
     * @var $name
     */
    public $name;

    /**
     * @var $surname
     */
    public $surname;

    /**
     * @var $email
     */
    public $email;

    /**
     * @var $phone
     */
    public $phone;

    /**
     * @var $isConfirmed
     */
    public $isConfirmed;

    /**
     * @var $dt_create
     */
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
     * Saves User to Database
     */
     public function save()
     {

        $this->dt_create = Date::formatted_time('now', 'Y-m-d');

        $insert = Dao_Users::insert();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        $id = $insert->execute();

        return $this->get_($id);

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

        return $this->get_($id);

     }

     public function checkPassword ($pass) {

         $selection = Dao_Users::select(array('password'))
                        ->where('id', '=', $this->id)
                        ->limit(1)
                        ->execute();

         $password = $selection['password'];

         return $password == $pass;

     }

     public function changePassword ($newpass) {

         $insert = Dao_Users::update()
                    ->set('password', $newpass)
                    ->where('id', '=', $this->id)
                    ->clearcache($this->id)
                    ->execute();

         return $insert;

     }

     public static function getByFields($fields) {

         $select = Dao_Users::select('id');

         foreach ($fields as $field => $value) {
             $select->where($field, '=', $value);
         }



         $selection = $select
                ->limit(1)
                ->execute();

         return new Model_User($selection['id']);

     }

    /**
     * @param $id
     * @return organization
     */
    public static function getUserOrganization($id)
    {
        $select = DB::select('id_organization')->from('User_Organizations')
                        ->where('id_user', '=', $id)
                        ->limit(1)
                        ->execute()
                        ->as_array();

        return Arr::get($select, '0')['id_organization'];
    }

    /**
     * @public
     *
     * Checks for existance by searching field
     *
     * @param $field
     * @param $value
     * @returns [Bool] True or False
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