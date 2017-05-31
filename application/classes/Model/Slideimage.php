<?php defined('SYSPATH') or die('No direct script access.');


Class Model_Slideimage {

    public $id;
    public $heading;
    public $image;
    public $image_position = 1;     //1 - in center, 2 - full screen
    public $reactions;              //1 - like, 2 - question, 3 - thumbs up, 4 - thumbs down

    
    /**
     * Model_Slideimage constructor.
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
     * @return Model_Slideimage
     */
    public function get($id = 0) {

        $select = Dao_Slidesimage::select()
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
     * @return Model_Slideimage
     */
     public function save()
     {
        $insert = Dao_Slidesimage::insert();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        return self::get($insert->execute());
     }


    /**
     * Update in DB
     * @return Model_Slideimage
     */
     public function update()
     {

        $insert = Dao_Slidesimage::update();

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

        $delete = Dao_Slidesimage::delete()
            ->where('id', '=', $id)
            ->limit(1)
            ->execute();

        return $delete;
    }

}