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


}