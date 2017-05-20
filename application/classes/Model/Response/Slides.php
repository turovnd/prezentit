<?php

class Model_Response_Slides extends Model_Response_Abstract
{
    protected $_SLIDE_ADD_SUCCESS = array (
        'type' => 'slide',
        'code' => '70',
        'message' => 'Creating new slide'
    );

    protected $_SLIDE_ADD_ERROR = array (
        'type' => 'slide',
        'code' => '71',
        'message' => 'Required type of slide'
    );

    protected $_SLIDE_DOES_NOT_EXISTED_ERROR = array (
        'type' => 'slide',
        'code' => '72',
        'message' => "Slide doesn't existed error"
    );

    protected $_SLIDE_DELETED_SUCCESS = array (
        'type' => 'slide',
        'code' => '73',
        'message' => "Slide has been deleted"
    );


}