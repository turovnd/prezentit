<?php defined('SYSPATH') or die('No direct script access.');


Class Model_Presentation {

    /** Min and Max random value as presentation code */
    const MIN_RAND_VALUE = 100000;
    const MAX_RAND_VALUE = 999999;
    const EVENTCODE_KEY  = 'prezentit:presentations:codes';

    public $id;
    public $code;
    public $name;
    public $uri;
    public $short_uri;
    public $owner;
    public $dt_update;
    public $dt_create;
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
     * Update presentation in DB
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
     * Delete
     * @param null $id
     * @return $bool
     */
    public static function delete($id = null)
    {
        if (!$id) return false;

        $delete = Dao_Presentations::delete()
            ->where('id', '=', $id)
            ->limit(1)
            ->execute();

        return $delete;
    }


    /**
     * Get all presentation for user
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


    /**
     * Generate code for seeing presentation
     * @param $id_event
     * @return int
     */
    public static function generateCode($id_event) {

        $redis = Dispatch::redisInstance();
        $generatedCode = mt_rand(self::MIN_RAND_VALUE, self::MAX_RAND_VALUE);

        /** try until we find */
        while ( $redis->hExists(self::EVENTCODE_KEY, $generatedCode) ) {
            $generatedCode = mt_rand(self::MIN_RAND_VALUE, self::MAX_RAND_VALUE);
        }

        $redis->hset(self::EVENTCODE_KEY, $generatedCode, $id_event);

        return $generatedCode;

    }

    /**
     * Get presentation by code
     * @param $code
     * @return string
     */
    public static function getByCode($code) {

        $redis = Dispatch::redisInstance();
        return $redis->hget(self::EVENTCODE_KEY, $code);

    }

}