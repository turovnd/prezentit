<?php

/**
 * Class Controller_Welcome
 *
 * @copyright prezit
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

        $isLogged  = self::isLogged();

        if ($isLogged) {
            $this->redirect('app');
        }

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
        $this->template->title = "Добро пожаловать";
        $this->template->section = View::factory('welcome/pages/main');
    }

}
