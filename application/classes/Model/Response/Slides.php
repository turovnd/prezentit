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

    protected $_SLIDE_UPDATE_SUCCESS = array (
        'type' => 'slide',
        'code' => '74',
        'message' => "Slide has been updated"
    );

    protected $_SLIDE_CONTENT_UPDATE_ERROR = array (
        'type' => 'slide_content',
        'code' => '75',
        'message' => "Slide content has NOT been updated"
    );

    protected $_SLIDE_CONTENT_UPDATE_SUCCESS = array (
        'type' => 'slide_content',
        'code' => '76',
        'message' => "Slide content has been updated"
    );


}