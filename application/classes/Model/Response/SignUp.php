<?php

class Model_Response_SignUp extends Model_Response_Abstract
{
    protected $_USER_EXISTS_ERROR = array(
        'type' => 'signup',
        'code' => '20',
        'message' => 'User already exists'
    );

    protected $_SIGNUP_SUCCESS = array(
        'type' => 'signup',
        'code' => '21',
        'message' => 'Success signup'
    );
}