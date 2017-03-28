<?php defined('SYSPATH') or die('No direct script access.');

class Controller_SignUp extends Dispatch
{

    const CONFIRMATION_HASHES_KEY = 'votepad.confirmation.hashes';
    public $template    = 'main';

    function before()
    {
        $this->auto_render = false;

       parent::before();

    }

    function action_index()
    {
        if (!$this->request->is_ajax()) {
            return;
        }

        $email      = Arr::get($_POST, 'email', '');
        $password   = Arr::get($_POST, 'password', '');
        $name       = Arr::get($_POST, 'name', '');


        if (!$email || !$password || !$name) {

            $response = new Model_Response_Form('EMPTY_FIELDS_ERROR', 'error');

            $this->response->body(@json_encode($response->get_response()));
            return;

        }


        if (!$email || Model_User::isUserExist($email)) {

            $response = new Model_Response_SignUp('USER_EXISTS_ERROR', 'error');
            $this->response->body(@json_encode($response->get_response()));
            return;

        }

        $user = new Model_User();

        $user->email = $email;
        $user->password = $password;
        $user->name = $name;

        $user->save();

        $this->send_email_confirmation($user, $password);

        $auth = new Model_Auth();

        if ($auth->login($email, $password)) {

            $response = new Model_Response_SignUp('SIGNUP_SUCCESS', 'success',  array('id' => $user->id));
            $this->response->body(@json_encode($response->get_response()));

        };

        /**
         * TODO: Email - Validation
         */

    }

    public function action_confirmEmail() {

        $hash = $this->request->param('hash');

        $id = $this->redis->hGet(self::CONFIRMATION_HASHES_KEY, $hash);

        if (!$id) {
            return;
        }

        $user = new Model_User($id);

        $user->isConfirmed = 1;

        $user->update();

        $this->redis->hDel(self::CONFIRMATION_HASHES_KEY, $hash);

        $this->redirect('/user/'.$id);

    }

    private function send_email_confirmation($user, $password) {

        $hash = $this->makeHash('sha256', $user->id . $_SERVER['SALT'] . $user->email);

        $this->redis->hSet(self::CONFIRMATION_HASHES_KEY, $hash, $user->id);

        $template = View::factory('emailtemplates/confirm_email', array('user' => $user, 'hash' => $hash));

        $email = new Email();

        return $email->send($user->email, $_SERVER['INFO_EMAIL'], 'Добро пожаловать в Votepad!', $template, true);

    }

}