<?php

class Model_Response_Email extends Model_Response_Abstract
{
    protected $_EMAIL_FORMAT_ERROR = array (
        'type' => 'email',
        'code' => '60',
        'message' => 'Error email format'
    );

    protected $_EMAIL_SEND_ERROR = array (
        'type' => 'email',
        'code' => '61',
        'message' => 'Error while email sending'
    );

    protected $_EMAIL_SEND_SUCCESS = array (
        'type' => 'email',
        'code' => '62',
        'message' => 'Success email sending'
    );

}