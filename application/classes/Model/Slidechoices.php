<?php defined('SYSPATH') or die('No direct script access.');


Class Model_Slidechoices {

    public $id;
    public $heading;                    //question
    public $image;
    public $answers;
    public $answers_with_image = 0;     //0 - false, 1 - true
    public $results_in_percents	= 0;    //0 - false, 1 - true

    
    /**
     * Model_Slidechoices constructor.
     * get info if data exist
     */
    public function __construct($id = null) {

        if ( !empty($id) ) {
            $this->get($id);
        }

    }


    /**
     * Get Slide_Heading info
     * @param $id
     * @return Model_Slidechoices
     */
    public function get($id = 0) {

        $select = Dao_Slideschoices::select()
            ->where('id', '=', $id)
            ->limit(1)
            ->execute();

        return $this->fill_by_row($select);

    }


    private function fill_by_row($db_selection) {

        if (empty($db_selection['id'])) return $this;

        foreach ($db_selection as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $this->$fieldname = $value;
        }

        return $this;

    }



    /**
     * Saves to DB
     * @return Model_Slidechoices
     */
     public function save()
     {
        $insert = Dao_Slideschoices::insert();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        return self::get($insert->execute());
     }


    /**
     * Update in DB
     * @return Model_Slidechoices
     */
     public function update()
     {

        $insert = Dao_Slideschoices::update();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        $insert->where('id', '=', $this->id);

        $insert->execute();

        return self::get($this->id);
     }


    /**
     * Delete
     * @param null $id
     * @return $bool
     */
    public static function delete($id = null)
    {
        if (!$id) return false;

        $delete = Dao_Slideschoices::delete()
            ->where('id', '=', $id)
            ->limit(1)
            ->execute();

        return $delete;
    }

}