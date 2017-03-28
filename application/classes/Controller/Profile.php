<?php

/**
 * Class Controller_Profile
 */

class Controller_Profile extends Dispatch
{
    public $template = 'profile/main';

    /**
     * Welcome Page
     */
    public function action_index()
    {
        $id = $this->request->param('id');

        $profile = new Model_User($id);

        if (!$profile->id) {
            throw new HTTP_Exception_404();
        }

        $isProfileOwner = !empty($this->session->get('uid')) && $this->session->get('uid') == $id;
        $canLogin = self::canLogin();

        $this->template->header = View::factory('globalblocks/header')
            ->set('header_menu', View::factory('profile/blocks/header_menu'))
            ->set('auth_modal', View::factory('globalblocks/auth_modal', array('canLogin' => $canLogin)));

        $this->template->footer = View::factory('globalblocks/footer');

        $this->template->jumbotron_wrapper = View::factory('profile/blocks/jumbotron_wrapper');

        $this->template->profile = $profile;
        $this->template->isProfileOwner = $isProfileOwner;

            /** Meta data */
        $this->template->title       = $profile->name. ' ' . $profile->surname . " | Votepad";
        $this->template->description = "Просмотреть профиль " . $profile->name. ' ' . $profile->surname . " на сайте votepad.ru. VotePad — это система для управления мероприятиями онлайн, обеспечивающая быструю и достоверную оценку участников мероприятия. Благодаря Votepad становиться проще и быстрее провести подсчет результатов!";
        $this->template->keywords    = "Профиль, Электронное голосование, Выставление баллов, Результат, Рейтинг, Страница с результатами, votepad, profile, voting, results, rating";


    }

    public function action_update()
    {
        $id = $this->request->param('id');

        $user = new Model_User($id);

        if (!$user->id) {
            throw new HTTP_Exception_404();
        }

        $user->name = Arr::get($_POST, 'name', $user->name);
        $user->surname = Arr::get($_POST, 'surname', $user->surname);
        $user->lastname = Arr::get($_POST, 'lastname', $user->lastname);
        $email = Arr::get($_POST, 'email');

        if ($email != $user->email) {
            $user->email = $email;
            $user->isConfirmed = 0;
        }

        $user->phone = Arr::get($_POST, 'phone', $user->phone);

        $user->update();

        if (Arr::get($_POST, 'newpassword') && Arr::get($_POST, 'newpassword2')) {

            $oldpass = Arr::get($_POST, 'oldpassword');
            $newpass1 = Arr::get($_POST, 'newpassword');
            $newpass2 = Arr::get($_POST, 'newpassword2');

            if ($newpass1 != $newpass2) {
                $response = new Model_Response_Auth('PASSWORDS_ARE_NOT_EQUAL_ERROR', 'error');
                $this->response->body(@json_encode($response->get_response()));
                return;
            }

            if (!$user->checkPassword($oldpass)) {
                $response = new Model_Response_Auth('INVALID_INPUT_ERROR', 'error');
                $this->response->body(@json_encode($response->get_response()));
                return;
            }

            $user->changePassword($newpass1);

        }

        $this->redirect('user/'.$id);

    }

}
