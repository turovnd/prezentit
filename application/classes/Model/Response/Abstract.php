<?php

class Model_Response_Abstract extends Model
{

    const ERROR_STATUS     = 'error';
    const SUCCESS_STATUS   = 'success';
    protected $response    =  array();

    public function __construct($name, $status, $data = array()) {

        if (!property_exists($this, '_'.$name)) {
            return false;
        }

        $this->response = $this->{'_'.$name};

        switch ($status) {
            case 'error': $this->response['status'] = self::ERROR_STATUS;
            break;
            case 'success': $this->response['status'] = self::SUCCESS_STATUS;
            break;
        }

        $this->response = array_merge($this->response, $data);

    }

    public function get_response() {

        return $this->response;

    }

}