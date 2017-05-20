<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_App_Ajax
 *
 * @copyright prezentit
 * @author Nikolai Turov
 * @version 0.0.0
 */

class Controller_App_Ajax extends Ajax
{

    public function before()
    {
        parent::before();

    }

    /**
     * New Presentation
     */
    public function action_new()
    {
        $this->checkCsrf();

        $name = Arr::get($_POST, 'name');

        if ( empty($name) ) {
            $response = new Model_Response_Presentation('EMPTY_PRESENTATION_NAME_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $presentation = new Model_Presentation();

        $presentation->name     = $name;
        $presentation->owner    = $this->session->get('uid');

        $result = $presentation->save();

        $response = new Model_Response_Presentation('PRESENTATION_CREATE_SUCCESS', 'success', array('uri' => $result->uri));
        $this->response->body(@json_encode($response->get_response()));

    }


    /**
     * Delete presentation by toggle is_removed
     */
    public function action_delete()
    {
        $id = $this->request->param('id');

        $presentation = Model_Presentation::get($id);

        $presentation->delete(true);

        $response = new Model_Response_Presentation('PRESENTATION_DELETE_SUCCESS', 'success');
        $this->response->body(@json_encode($response->get_response()));

    }

}