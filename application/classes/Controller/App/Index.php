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
     * @const ACTION_PRESENTATION [String] - page where presentation is showing
     */
    const ACTION_PRESENTATION = 'presentation';

    /**
     * @const ACTION_EDIT_PRESENTATION [String] - page where is editing of presentation
     */
    const ACTION_EDIT_PRESENTATION = 'presentationedit';


    public function before()
    {
        switch ($this->request->action()) {

            case self::ACTION_PRESENTATION :
                $this->template = 'app/main-presentation';
                break;

            case self::ACTION_EDIT_PRESENTATION:
                $this->template = 'app/main-edit-presentation';
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

    /**
     * All presentations
     */
    public function action_index()
    {
        $uid = $this->session->get('uid');

        $presentations = Model_Presentation::getByUserId($uid);

        $this->template->title = "Все презентации";

        $this->template->header = View::factory('app/blocks/header-app', array('title' => "Презентации - " . $this->user->name));

        $this->template->aside = View::factory('app/blocks/aside-app');

        $this->template->section = View::factory('app/pages/all-presentations')
            ->set('presentations', $presentations);

    }

    /**
     * Show certain presentation
     *
     * @throws HTTP_Exception_404
     */
    public function action_presentation()
    {
        $uri = $this->request->param('uri');
        $presentaton = Model_Presentation::getByFieldName('uri',$uri);

        if (!$presentaton->id)
            throw new HTTP_Exception_404;

        $presentaton->slides = Model_Slide::getByPresentationId($presentaton->id);
        $this->template->presentaton = $presentaton;

    }


    /**
     * Edit certain presentation
     *
     * @throws HTTP_Exception_404
     */
    public function action_presentationedit()
    {
        $uri = $this->request->param('uri');

        $presentaton = Model_Presentation::getByFieldName('uri', $uri);

        if (!$presentaton->id)
            throw new HTTP_Exception_404;

        $slides = Model_Slide::getByPresentationId($presentaton->id);

        $this->template->title = $presentaton->name;

        $this->template->header = View::factory('app/blocks/header-slides')
            ->set('presentaton', $presentaton);

        $this->template->aside = View::factory('app/blocks/aside-slides')
            ->set('slides', $slides);

        $presentaton->slides = $slides;
        $this->template->section = View::factory('app/pages/edit-presentation')
            ->set('presentaton', $presentaton);

    }

}