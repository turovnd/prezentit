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
     * @var $is_removed
     */
    public $is_removed;


    /**
     * Model_Presentation constructor.
     * get presentation info if data exist
     */
    public function __construct($id = null) {

        if ( !empty($id) ) {
            $this->get($id);
        }

        return false;

    }


    /**
     * Get presentation by ID
     * @param $id - presentation ID
     * @return Model_Presentation
     */
    public static function get($id = 0) {

        $select = Dao_Presentations::select()
            ->where('id', '=', $id)
            ->limit(1)
            ->execute();

        $model = new Model_Presentation();

        return $model->fill_by_row($select);

    }


    /**
     * Get presentations where is_removed == 0
     * @param $id - presentation ID
     * @return Model_Presentation
     */
    public static function getExisted($id) {

        $select = Dao_Presentations::select()
            ->where('id', '=', $id)
            ->where('is_removed', '=', 0)
            ->limit(1)
            ->execute();

        $model = new Model_Presentation();

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
     * Get presentations by field name
     * @param $field
     * @param $value
     * @return object
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
     * Saves Presentations to DB
     * @return Model_Presentation
     */
     public function save()
     {
        $this->is_removed = 0;
        $this->dt_create = Date::formatted_time('now');
        $this->dt_update = Date::formatted_time('now');

        $insert = Dao_Presentations::insert();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        $id = $insert->execute();

        Dao_UsersPresentations::insert()
            ->set('u_id', $this->owner)
            ->set('p_id', $id)
            ->execute();

        $present = self::get($id);

        $present->uri = hash('md5', $id . $_SERVER['SALT']);
        $present->short_uri = hash('adler32', $id . $_SERVER['PRESENTATIONMOBILESALT']);
        $present->update();

        return $present;
     }


    /**
     * Updates user data in database
     * @return Model_Presentation
     */
     public function update()
     {

        $insert = Dao_Presentations::update();

        foreach ($this as $fieldname => $value) {
            if (property_exists($this, $fieldname)) $insert->set($fieldname, $value);
        }

        $insert->where('id', '=', $this->id);

        $insert->execute();

        return self::get($this->id);
     }


    /**
     * @param bool $with_slides
     */
     public function delete($with_slides = false)
     {
        $this->is_removed = 1;
        $this->update();


        /* удалить слайды */
        //if ($with_slides) {
        //}

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
                $present = Model_Presentation::getExisted($id);

                if ($present->id != NULL) {
                    array_push($presentations, $present);
                }
            }
        }

        return $presentations;
    }

}