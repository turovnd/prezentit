<?php

class Model_Response_Email extends Model_Response_Abstract
{
    protected $_EMAIL_ERROR = array (
        'type' => 'email',
        'code' => '60',
        'message' => 'Error while email sending'
    );


    protected $_EMAIL_SUCCESS = array (
        'type' => 'email',
        'code' => '61',
        'message' => 'Success email sending'
    );

}