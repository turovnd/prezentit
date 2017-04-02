<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Auth_Ajax
 *
 * @copyright prezit
 * @author Nikolai Turov
 * @version 0.0.0
 */

class Controller_Auth_Ajax extends Auth
{

    public function before()
    {
        // Do not allow render
        $this->auto_render = false;

        $this->checkCsrf();

        parent::before();
    }



    /**
     * action - SignIn
     */
    public function action_signin()
    {

        if ($this->getAttempt() > 3) {
            $response = new Model_Response_Auth('ATTEMPT_NUMBER_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $email      = Arr::get($_POST, 'email', '');
        $password   = Arr::get($_POST, 'password', '');
        $remember   = false;

        if ( empty($email) || empty($password)) {
            $this->makeAttempt();
            $response = new Model_Response_Form('EMPTY_FIELDS_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        if (!Valid::email($email)) {
            $this->makeAttempt();
            $response = new Model_Response_Email('EMAIL_FORMAT_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $user = new Model_Auth();

        if (!$user->login($email, $password, $remember)) {
            $this->makeAttempt();
            $response = new Model_Response_Auth('INVALID_INPUT_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        Cookie::delete('attempt');

        $session = Session::instance();
        $sid = $session->id();
        $uid = $session->get('uid');

        $hash = $this->makeHash('sha256', $_SERVER['SALT'] . $sid . $_SERVER['AUTHSALT'] . $uid);

        Cookie::set('secret', $hash, Date::DAY);

        /**
         * save session in Redis server
         */
        $this->redis->set('prezit:sessions:secrets:' . $hash, $sid . ':' . $uid . ':' . Request::$client_ip, array('nx', 'ex' => 3600 * 24));

        $response = new Model_Response_Auth('LOGIN_SUCCESS', 'success', array('id' => $uid));
        $this->response->body(@json_encode($response->get_response()));

    }



    /**
     * action - SignUp new user
     */
    public function action_signup()
    {

        $email      = Arr::get($_POST, 'email', '');
        $password   = Arr::get($_POST, 'password', '');
        $name       = Arr::get($_POST, 'name', '');

        if ( empty($email) || empty($password) || empty($name)) {
            $response = new Model_Response_Form('EMPTY_FIELDS_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        if (!$email || Model_User::isUserExist($email)) {
            $response = new Model_Response_SignUp('USER_EXISTS_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        if (!Valid::email($email)) {
            $response = new Model_Response_Email('EMAIL_FORMAT_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        if (preg_match("[ ]",$name)) {
            $response = new Model_Response_SignUp('NAME_VALIDATION_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $user = new Model_User();

        $user->email        = $email;
        $user->password     = $password;
        $user->name         = $name;

        $user->save();

        $isSuccess = $this->send_email_confirmation($user, $password);

        if ($isSuccess) {
            $response = new Model_Response_Email('EMAIL_SEND_SUCCESS', 'success');
        } else {
            $response = new Model_Response_Email('EMAIL_SEND_ERROR', 'error');
        }
        $this->response->body(@json_encode($response->get_response()));

        $auth = new Model_Auth();

        if ($auth->login($email, $password)) {
            $response = new Model_Response_SignUp('SIGNUP_SUCCESS', 'success',  array('id' => $user->id));
            $this->response->body(@json_encode($response->get_response()));
        };

    }



    /**
     * action - Reset password form
     */
    public function action_reset() {

        $email = Arr::get($_POST, 'email', '');


        if ( empty($email) ) {
            $response = new Model_Response_Form('EMPTY_FIELDS_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $user = Model_User::getByFieldName('email', $email);


        if (!$user->id) {
            $response = new Model_Response_Auth('USER_DOES_NOT_EXIST_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $isSuccess = $this->send_reset_email($user);

        if ($isSuccess) {
            $response = new Model_Response_Email('EMAIL_SEND_SUCCESS', 'success');
        } else {
            $response = new Model_Response_Email('EMAIL_SEND_ERROR', 'error');
        }
        $this->response->body(@json_encode($response->get_response()));
    }



    /**
     *  Send Email Request for confirming Email
     *
     * @param $user, $password
     * @return int
     */
    private function send_email_confirmation($user, $password) {

        $hash = $this->makeHash('sha256', $user->id . $_SERVER['SALT'] . $user->email . Date::formatted_time('now'));

        $this->redis->set('prezit:confirmation:email:' . $hash, $user->id, array('nx', 'ex' => 3600 * 24 * 7));

        $template = View::factory('', array('user' => $user, 'hash' => $hash));

        $email = new Email();

        return $email->send($user->email, $_SERVER['INFO_EMAIL'], 'Добро пожаловать в ' . $_SERVER['SITE_NAME'] . '!', $template, true);

    }



    /**
     *  Send Reset Password Email
     *
     * @param $user
     * @return boolean
     */
    public function send_reset_email($user) {

        $hash = $this->makeHash('sha256', $_SERVER['SALT'] . $user->id . Date::formatted_time('now'));

        $this->redis->set('prezit:reset:email:' . $hash, $user->id, array('nx', 'ex' => 3600 * 24));

        $template = View::factory('', array('user' => $user, 'hash' => $hash));

        $email = new Email();

        return $email->send($user->email, $_SERVER['INFO_EMAIL'], 'Сброс пароля на ' . $_SERVER['SITE_NAME'], $template, true);

    }



    /**
     * Checking Email Confirmation hash
     */
    public function action_confirmEmail() {

        $hash = $this->request->param('hash');

        $id = $this->redis->get('prezit:confirmation:email:' . $hash);

        if (!$id) {
            return;
        }

        $user = new Model_User($id);

        $user->isConfirmed = 1;

        $user->update();

        $this->redis->delete('prezit:confirmation:email:' . $hash);

        $this->redirect('app');

    }




    /**
     * action - Reset password Form
     * @throws HTTP_Exception_400
     */
    public function action_resetPassword() {

        Cookie::delete('reset_link');

        $hash = $this->request->param('hash');

        $id = $this->redis->get('prezit:reset:email:' . $hash);

        $user = new Model_User($id);

        if (!$this->request->is_ajax()) {

            if (!$user->id) {
                throw new HTTP_Exception_400();
            }

            Cookie::set('reset_link', $hash, Date::HOUR);

            $this->redirect('login');

            return;

        }

        $this->auto_render = false;

        if (!$user->id) {
            $response = new Model_Response_Auth('USER_DOES_NOT_EXIST_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $newpass1 = Arr::get($_POST, 'reset_password', '');
        $newpass2 = Arr::get($_POST, 'reset_password_repeat', '');

        if ($newpass1 != $newpass2) {
            $response = new Model_Response_Auth('PASSWORDS_ARE_NOT_EQUAL_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;
        }

        $user->changePassword($newpass1);

        $response = new Model_Response_Auth('PASSWORD_CHANGE_SUCCESS', 'success');
        $this->response->body(@json_encode($response->get_response()));

        $this->redis->delete('prezit:reset:email:' . $hash);

    }


}