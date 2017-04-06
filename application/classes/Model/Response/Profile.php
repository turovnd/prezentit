<?php

class Model_Response_Profile extends Model_Response_Abstract
{
    protected $_USER_UPDATE_SUCCESS = array (
        'type' => 'update',
        'code' => '40',
        'message' => 'Success updating info'
    );

    protected $_USER_ID_ERROR = array (
        'type' => 'update',
        'code' => '41',
        'message' => 'Post userID is not equal to session userID'
    );

    protected $_PASSWORDS_ARE_NOT_EQUAL_ERROR = array (
        'type' => 'update',
        'code' => '42',
        'message' => 'Passwords should be equal'
    );

    protected $_USER_INVALID_PASSWORD_ERROR = array(
        'type' => 'update',
        'code' => '43',
        'message' => 'Current password is error'
    );


    protected $_PASSWORD_CHANGE_SUCCESS = array (
        'type' => 'update',
        'code' => '44',
        'message' => 'Password was changed'
    );



}