<?php defined('SYSPATH') or die('No direct script access.');


Class Model_Subscriber {
    public $id;
    public $name;
    public $email;


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

        $select = Dao_Subscribers::select()
            ->where('id', '=', $id)
            ->limit(1)
            ->cached(Date::MINUTE * 5, $id)
            ->execute();

        $this->fill_by_row($select);

        return $this;

    }



    /**
     * Save Subscriber
     */
    public function save()
    {
        $this->dt_create = Date::formatted_time('now');

        $insert = Dao_Subscribers::insert();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        $result = $insert->execute();

        return $this->get_($result);
    }

}