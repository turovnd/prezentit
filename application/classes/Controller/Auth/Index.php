<?php defined('SYSPATH') or die('No direct pattern access.');

/**
 * Class Controller_Auth_Index
 *
 * @copyright prezentit
 * @author Nikolai Turov
 * @version 0.0.0
 */

class Controller_Auth_Index extends Dispatch
{


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
     * Authentication page
     */
    public function action_login()
    {
        $this->template->title = "Авторизация";
        $this->template->section = View::factory('welcome/pages/auth');
    }

    /**
     * Registration Page
     */
    public function action_signup()
    {
        $this->template->title = "Регистрация";
        $this->template->section = View::factory('welcome/pages/auth');
    }


    public function action_logout()
    {
        $auth = new Model_Auth();
        $auth->logout();
        $this->redirect('/');
    }


}