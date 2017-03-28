<?php

class Ajax extends Dispatch {

    function before() {
        $this->auto_render = false;

        if (!self::is_ajax()) {
            throw new HTTP_Exception_403;
        }

        parent::before();

    }

    public static function is_ajax()
    {
        if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return true;

        return false;
    }
}