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
