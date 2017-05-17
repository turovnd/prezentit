<?php defined('SYSPATH') or die('No direct script access.');


Class Model_Slide {

    public $id;
    public $type;
    public $presentation;
    public $slides_order;
    public $heading;
    public $subheading;
    public $paragraph;
    public $image;
    public $image_position;
    public $reactions;
    public $question;
    public $answers;
    public $dt_create;


    /**
     * Model_Slide constructor.
     * get presentation info if data exist
     */
    public function __construct($id = null) {

        if ( !empty($id) ) {
            $this->get($id);
        }

        return false;

    }


    /**
     * Get Slide
     * @param $id
     * @return Model_Slide
     */
    public static function get($id = 0) {

        $select = Dao_Slides::select()
            ->where('id', '=', $id)
            ->limit(1)
            ->execute();

        $model = new Model_Slide();

        return $model->fill_by_row($select);

    }


    private function fill_by_row($db_selection) {

        if (empty($db_selection['id'])) return $this;

        foreach ($db_selection as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $this->$fieldname = $value;
        }

        return $this;

    }



    /**
     * Get slide by field name
     * @param $field
     * @param $value
     * @return object
     */
    public static function getByFieldName($field, $value) {

        $select = Dao_Slides::select()
            ->where($field, '=', $value)
            ->limit(1)
            ->execute();

        $slide = new Model_Slide($select['id']);
        return $slide->fill_by_row($select);

    }


    /**
     * Saves Slide to DB
     * @return Model_Slide
     */
     public function save()
     {
        $this->dt_create = Date::formatted_time('now');

        $insert = Dao_Slides::insert();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        return self::get($insert->execute());
     }


    /**
     * Update slide in DB
     * @return Model_Slide
     */
     public function update()
     {

        $insert = Dao_Slides::update();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        $insert->where('id', '=', $this->id);

        $insert->execute();

        return self::get($this->id);
     }


    /**
     * Delete Slide
     * @param bool
     */
     public function delete()
     {
        $this->delete();
     }


    /**
     * Get all user which have access to presentation
     * @param $id - user id
     * @return array of Presentations
     */
    public static function getByUserId($id)
    {
        $ids = Dao_UsersPresentations::select('p_id')
            ->where('u_id', '=', $id)
            ->execute('p_id');

        $presentations = array();

        if ($ids) {
            foreach ($ids as $id => $value) {
                $present = Model_Slide::getExisted($id);

                if ($present->id != NULL) {
                    array_push($presentations, $present);
                }
            }
        }

        return $presentations;
    }

}