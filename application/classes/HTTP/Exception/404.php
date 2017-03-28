<?php

class HTTP_Exception_404 extends Kohana_HTTP_Exception_404 {

    function get_response()
    {
        $response = Response::factory();

        $view = View::factory('errors/404');

        $response->body($view->render());

        return $response;
    }
}