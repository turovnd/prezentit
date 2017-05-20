<?php

class Model_Response_Presentation extends Model_Response_Abstract
{
    protected $_PRESENTATION_CREATE_SUCCESS = array (
        'type' => 'create',
        'code' => '50',
        'message' => 'Success creating'
    );

    protected $_EMPTY_PRESENTATION_NAME_ERROR = array (
        'type' => 'create',
        'code' => '51',
        'message' => 'Invalid presentation name'
    );

    protected $_PRESENTATION_DELETE_SUCCESS = array (
        'type' => 'delete',
        'code' => '52',
        'message' => 'Success deleting'
    );

    protected $_PRESENTATION_ID_REQUIRE_ERROR = array (
        'type' => 'create_slides',
        'code' => '53',
        'message' => 'Presentation id is require'
    );
}