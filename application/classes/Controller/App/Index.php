<?php defined('SYSPATH') or die('No direct pattern access.');

/**
 * Class Controller_App_Index
 *
 * @copyright presentit
 * @author Nikolai Turov
 * @version 0.0.0
 */

class Controller_App_Index extends Dispatch
{
    public $template = 'app/main';

    public function before()
    {
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

            $this->template->title = $presentaton->name;
            $this->template->section = "";

        } else {
            throw new HTTP_Exception_404;
        }

        echo Debug::vars($presentaton->name);
        echo Debug::vars("presentation on the desk");
        exit;

    }


    public function action_presentationedit()
    {
        $uri = $this->request->param('uri');

        $presentaton = Model_Presentation::getByFieldName('uri', $uri);

        if ( $presentaton->id ) {

            $this->template->presentaton = $presentaton;

            $this->template->header = View::factory('app/blocks/header-slides', array('presentaton' => $presentaton));

            $this->template->aside = View::factory('app/blocks/aside-slides');

            $this->template->section = "";

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