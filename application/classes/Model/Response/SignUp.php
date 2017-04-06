<?php

class Model_Response_SignUp extends Model_Response_Abstract
{
    protected $_SIGNUP_SUCCESS = array(
        'type' => 'signup',
        'code' => '20',
        'message' => 'Success signup'
    );

    protected $_USER_EXISTS_ERROR = array(
        'type' => 'signup',
        'code' => '21',
        'message' => 'User already exists'
    );

    protected $_NAME_VALIDATION_ERROR = array(
        'type' => 'signup',
        'code' => '22',
        'message' => 'Name must be in two words'
    );

}