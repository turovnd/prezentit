<?php defined('SYSPATH') or die('No direct pattern access.');

/**
 * Class Controller_App_Index
 *
 * @copyright prezentit
 * @author Nikolai Turov
 * @version 0.0.0
 */

class Controller_App_Index extends Dispatch
{

    /**
     * @const ACTION_NEW [String]
     */
    const ACTION_PRESENTATION = 'presentation';


    public function before()
    {
        switch ($this->request->action()) {

            case self::ACTION_PRESENTATION :
                $this->template = 'app/main-presentation';
                break;

            default :
                $this->template = 'app/main';
                break;
        }

        parent::before();

        $isLogged   = self::isLogged();

        if (!$isLogged) {
            $this->redirect('login');
        }

    }


    public function action_index()
    {
        $uid = $this->session->get('uid');

        $presentations = Model_Presentation::getByUserId($uid);

        $this->template->title = $this->user->name;

        $this->template->header = View::factory('app/blocks/header-app', array('title' => "Презентации - " . $this->user->name));

        $this->template->aside = View::factory('app/blocks/aside-app');

        $this->template->section = View::factory('app/pages/all-presentations')
            ->set('presentations', $presentations);

    }


    public function action_presentation()
    {
        $uri = $this->request->param('uri');
        $presentaton = Model_Presentation::getByFieldName('uri',$uri);

        if ( $presentaton->id ) {

            $this->template->presentaton = $presentaton;

        } else {
            throw new HTTP_Exception_404;
        }

    }


    public function action_presentationedit()
    {
        $uri = $this->request->param('uri');

        $presentaton = Model_Presentation::getByFieldName('uri', $uri);

        if ( $presentaton->id ) {

            $slides = Model_Slide::getByPresentationId($presentaton->id);

            $this->template->title = $presentaton->name;

            $this->template->header = View::factory('app/blocks/header-slides', array('presentaton' => $presentaton));

            $this->template->aside = View::factory('app/blocks/aside-slides', array('slides' => $slides));

            $this->template->section = View::factory('app/pages/edit-presentation')
                ->set('presentaton', $presentaton);

        } else {

            throw new HTTP_Exception_404;

        }

    }


    public function action_presentationmobile()
    {
        $uri = $this->request->param('uri');

        $presentaton = Model_Presentation::getByFieldName('uri',$uri);

        if ( $presentaton->id ) {

            $this->template->title = $presentaton->name;
            $this->template->section = "";

        } else {

            throw new HTTP_Exception_404;

        }

        echo Debug::vars("mobile app for switching slides");
        exit;




    }

}