<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Slides_Ajax
 *
 * @copyright prezentit
 * @author Nikolai Turov
 * @version 0.0.0
 */

class Controller_Slides_Ajax extends Ajax
{

    public function before()
    {
        parent::before();
    }


    /**
     * action - Add new slide
     */
    public function action_add()
    {
        $type = Arr::get($_POST, 'type');
        $presentation = Arr::get($_POST, 'presentation');

        if ( ! $type) {
            $response = new Model_Response_Slides('SLIDE_ADD_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        if ( ! $presentation) {
            $response = new Model_Response_Presentation('PRESENTATION_ID_REQUIRE_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $slide = new Model_Slide();

        $slide->type            = $type;
        $slide->presentation    = $presentation;

        $slide = $slide->save();


        switch ($type) {

            case 1:
                $content = new Model_Slideheading();
                $content = $content->save();
                $slide_aside = View::factory('app/blocks/slide-aside/heading', array('slide' => $content));
                $slide_content = View::factory('app/blocks/slide-presentation/heading');
                $slide_config = View::factory('app/blocks/slide-type/heading');
                break;

            case 2:
                $content = new Model_Slideimage();
                $content->image_position = Arr::get($_POST, 'image_position', '1');
                $content = $content->save();
                $slide_aside = View::factory('app/blocks/slide-aside/image', array('slide' => $content));
                $slide_content = View::factory('app/blocks/slide-presentation/image');
                $slide_config = View::factory('app/blocks/slide-type/image');
                break;

            case 3:
                $content = new Model_Slideparagraph();
                $content = $content->save();
                $slide_aside = View::factory('app/blocks/slide-aside/paragraph', array('slide' => $content));
                $slide_content = View::factory('app/blocks/slide-presentation/paragraph');
                $slide_config = View::factory('app/blocks/slide-type/paragraph');
                break;

            case 4:
                $content = new Model_Slidechoices();
                $content->answers_with_image = Arr::get($_POST, 'answers_with_image', '0');
                $content->results_in_percents = Arr::get($_POST, 'results_in_percents', '0');
                $content = $content->save();
                $slide_aside = View::factory('app/blocks/slide-aside/choices', array('slide' => $content));
                $slide_content = View::factory('app/blocks/slide-presentation/choices');
                $slide_config = View::factory('app/blocks/slide-type/choices');
                break;
        }

        $data = array(
            'slideId'   => $slide->id,
            'aside'     => $slide_aside->render(),
            'slide'     => $slide_content->render(),
            'config'    => $slide_config->render()
        );


        $slide->content_id = $content->id;
        $slide->update();

        $response = new Model_Response_Slides('SLIDE_ADD_SUCCESS', 'success', $data);
        $this->response->body(@json_encode($response->get_response()));

    }


    /**
     * action - Delete slide
     */
    public function action_delete()
    {
        $id = Arr::get($_POST, 'id');

        $slide = new Model_Slide($id);

        if ( ! $slide ) {
            $response = new Model_Response_Slides('SLIDE_DOES_NOT_EXISTED_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

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

        $response = new Model_Response_Slides('SLIDE_DELETED_SUCCESS', 'success');
        $this->response->body(@json_encode($response->get_response()));

    }


}