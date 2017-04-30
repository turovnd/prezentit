<?php

/**
 * Class Controller_Profile
 *
 * @copyright presentit
 * @author Nikolai Turov
 * @version 0.0.0
 */
class Controller_Profile extends Dispatch
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

    /**
     * action_index - show Profile page
     */
    public function action_index()
    {
        $id = $this->session->get('uid');

        $profile = new Model_User($id);

        $this->template->header = View::factory('app/blocks/header-app', array('title' => "Профиль - " . $this->user->name));
        $this->template->aside = View::factory('app/blocks/aside-app');
        $this->template->section = View::factory('app/pages/profile')
            ->set('profile', $profile);
    }


    /**
     * action_update - Update Profile Main Info
     */
    public function action_update()
    {
        $this->checkRequest();

        $id = Arr::get($_POST, 'id');
        $uid = $this->session->get('uid');

        if ($id != $uid) {
            $response = new Model_Response_Profile('USER_ID_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $user = new Model_User($id);

        $user->name = Arr::get($_POST, 'name');
        $user->newsletter = Arr::get($_POST, 'newsletter') ? 1 : 0;

        $user->update();

        $response = new Model_Response_Profile('USER_UPDATE_SUCCESS', 'success');
        $this->response->body(@json_encode($response->get_response()));

    }



    /**
     * action_updatepassword - Update Profile Password
     */
    public function action_updatepassword()
    {
        $this->checkRequest();

        $id = Arr::get($_POST, 'id');
        $uid = $this->session->get('uid');

        if ($id != $uid) {
            $response = new Model_Response_Profile('USER_ID_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $curPass = Arr::get($_POST, 'curPass');
        $newPass = Arr::get($_POST, 'newPass');
        $newPass1 = Arr::get($_POST, 'newPass1');

        if ( empty($curPass) || empty($newPass) || empty($newPass1) ) {
            $response = new Model_Response_Form('EMPTY_FIELDS_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        if ($newPass != $newPass1) {
            $response = new Model_Response_Profile('PASSWORDS_ARE_NOT_EQUAL_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $user = new Model_User($id);

        $curPass = $this->makeHash('md5', $curPass . $_SERVER['SALT']);

        if (!$user->checkPassword($curPass)) {
            $response = new Model_Response_Profile('USER_INVALID_PASSWORD_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $newPass = $this->makeHash('md5', $newPass . $_SERVER['SALT']);

        $user->changePassword($newPass);

        $response = new Model_Response_Profile('PASSWORD_CHANGE_SUCCESS', 'success');
        $this->response->body(@json_encode($response->get_response()));

    }



    /**
     * Checking if request ajax and checkCsrf
     * @throws HTTP_Exception_403
     */
    protected function checkRequest()
    {
        // Do not allow render
        $this->auto_render = false;

        if (!$this->request->is_ajax()) {
            throw new HTTP_Exception_403;
        }

        $this->checkCsrf();
    }


}
