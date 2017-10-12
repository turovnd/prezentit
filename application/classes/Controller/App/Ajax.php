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
            $response = new Model_Response_Form('EMPTY_FIELD_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $presentation = new Model_Presentation();
        $presentation->name     = $name;
        $presentation->owner    = $this->session->get('uid');

        $presentation = $presentation->save();

        $presentation->code  = Model_Presentation::generateCode($presentation->id);

        $presentation->update();

        $response = new Model_Response_Presentation('PRESENTATION_CREATE_SUCCESS', 'success', array('uri' => $presentation->uri));
        $this->response->body(@json_encode($response->get_response()));

    }


    /**
     * Delete presentation by toggle is_removed
     */
    public function action_delete()
    {
        $id = Arr::get($_POST, 'id');

        $slides = Model_Slide::getByPresentationId($id);

        foreach ($slides as $slide) {

            switch ($slide->type) {

                case 1:
                    Model_Slideheading::delete($slide->content_id);
                    break;

                case 2:
                    Model_Slideimage::delete($slide->content_id);
                    break;

                case 3:
                    Model_Slideparagraph::delete($slide->content_id);
                    break;

                case 4:
                    Model_Slidechoices::delete($slide->content_id);
                    break;
            }

            Model_Slide::delete($slide->id);

        }

        Model_Presentation::delete($id);

        $response = new Model_Response_Presentation('PRESENTATION_DELETE_SUCCESS', 'success');
        $this->response->body(@json_encode($response->get_response()));

    }


    public function action_editname()
    {
        $id = Arr::get($_POST, 'id');
        $name = Arr::get($_POST, 'name');

        $presentation = new Model_Presentation($id);

        if (empty($presentation)) {
            $response = new Model_Response_Presentation('PRESENTATION_DOES_NOT_EXIST_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $presentation->name = $name;
        $presentation->update();

        $response = new Model_Response_Presentation('PRESENTATION_UPDATE_SUCCESS', 'success');
        $this->response->body(@json_encode($response->get_response()));
    }

}