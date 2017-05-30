<?php defined('SYSPATH') or die('No direct script access.');


Class Model_Slideheading {

    public $id;
    public $heading;
    public $subheading;
    public $image = "";
    public $reactions = "";


    /**
     * SlideHeading constructor.
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
     * @return Model_Slideheading
     */
    public function get($id = 0) {

        $select = Dao_Slidesheading::select()
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
     * @return Model_Slideheading
     */
    public function save()
    {
        $insert = Dao_Slidesheading::insert();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        return self::get($insert->execute());
    }


    /**
     * Update in DB
     * @return Model_Slideheading
     */
    public function update()
    {

        $insert = Dao_Slidesheading::update();

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

        $delete = Dao_Slidesheading::delete()
            ->where('id', '=', $id)
            ->limit(1)
            ->execute();

        return $delete;
    }

}