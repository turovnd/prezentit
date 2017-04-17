<?php

/**
 * Class Controller_Welcome
 *
 * @copyright presentit
 * @author Nikolai Turov
 * @version 0.0.0
 */

class Controller_Welcome extends Dispatch
{
    /**
     * If User is Logged -> redirect to app
     */
    public function before()
    {
        parent::before();
    }


    /**
     * Template of Welcome Module
     * @var string
     */
    public $template = 'welcome/main';



    /**
     * Welcome Page
     */
    public function action_index()
    {
        $isLogged  = self::isLogged();

        if ($isLogged) {
            $this->redirect('app');
        }

        $this->template->title = "Интерактивные презентации";
        $this->template->section = View::factory('welcome/pages/main');
    }


    /**
     * Why Page
     */
    public function action_why()
    {
        $this->template->title = "Интерактивные презентации";
        $this->template->section = View::factory('welcome/pages/why');
    }


    /**
     * How to use Page
     */
    public function action_howto()
    {
        $this->template->title = "Как создать интерактивную презентацию";
        $this->template->section = View::factory('welcome/pages/how-to');
    }



    /**
     * Add new subscribe to DB
     */
    public function action_newsubscriber()
    {
        $this->auto_render = false;

        if (! Ajax::is_ajax()) {
            throw new HTTP_Exception_403;
        }

        $this->checkCsrf();

        $name   = Arr::get($_POST, 'name');
        $email  = Arr::get($_POST, 'email');

        if (!Valid::email($email)) {
            $response = new Model_Response_Email('EMAIL_FORMAT_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        if (empty($name)) {
            $response = new Model_Response_Form('EMPTY_FIELDS_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $subscriber = new Model_Subscriber();
        $subscriber->name   = $name;
        $subscriber->email  = $email;

        $subscriber->save();

        $this->response->body(@json_encode("success"));

    }
}
