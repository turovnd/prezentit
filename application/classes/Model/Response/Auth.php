<?php

class Model_Response_Auth extends Model_Response_Abstract
{

    protected $_ATTEMPT_NUMBER_ERROR = array(
        'type' => 'login',
        'code' => '10',
        'message' => 'Number of attempts is more than allowed'
    );

    protected $_INVALID_INPUT_ERROR = array(
        'type' => 'login',
        'code' => '11',
        'message' => 'Invalid input'
    );

    protected $_LOGIN_SUCCESS = array(
        'type' => 'login',
        'code' => '12',
        'message' => 'Success login'
    );


    protected $_USER_DOES_NOT_EXIST_ERROR = array (
        'type' => 'login',
        'code' => '13',
        'message' => 'User does not exists'
    );

    protected $_PASSWORDS_ARE_NOT_EQUAL_ERROR = array (
        'type' => 'login',
        'code' => '14',
        'message' => 'Passwords should be equal'
    );

    protected $_PASSWORD_CHANGE_SUCCESS = array (
        'type' => 'login',
        'code' => '15',
        'message' => 'Password was changed'
    );

}