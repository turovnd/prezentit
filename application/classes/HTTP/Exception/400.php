<?php

class HTTP_Exception_400 extends Kohana_HTTP_Exception_400 {

    function get_response()
    {
        $response = Response::factory();

        $view = View::factory('errors/400');

        $response->body($view->render());

        return $response;
    }
}