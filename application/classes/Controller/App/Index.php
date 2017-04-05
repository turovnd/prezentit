<?php defined('SYSPATH') or die('No direct pattern access.');

/**
 * Class Controller_App_Index
 *
 * @copyright prezit
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
        $this->template->title = "Презентации - " . $this->user->name . " " . $this->user->surname;
        $this->template->section = View::factory('app/pages/all-presentations');
    }

    public function action_profile()
    {
        $this->template->title = "Профиль - " . $this->user->name . " " . $this->user->surname;
        $this->template->section = View::factory('app/pages/profile');
    }


}