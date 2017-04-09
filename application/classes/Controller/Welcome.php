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

        $this->template->title = "Добро пожаловать";
        $this->template->section = View::factory('welcome/pages/main');
    }

}
