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

    public function before()
    {
        parent::before();
        /**
         * Is not logged -> go to /login page
         */
        $isLogged   = self::isLogged();
        $uid = $this->recover();
        if (!$isLogged || !$uid) {
            $this->redirect('login');
        }

    }


    public $template = 'welcome/main';


    public function action_index()
    {
        $this->template->title = "";
        $this->template->section = "";
    }



    /**
     * Check session token (make secret from Cookie data)
     *
     * @return null|string
     */
    private function recover()
    {
        $uid    = Cookie::get('uid');
        $sid    = Cookie::get('sid');
        $secret = Cookie::get('secret');
        $hash = $this->makeHash('sha256', $_SERVER['SALT'] . $sid . $_SERVER['AUTHSALT'] . $uid);


        if ($this->redis->get('prezit:sessions:secrets:' . $hash) && $hash == $secret) {

            // Создаем новую сессию
            $auth = new Model_Auth();
            $auth->recoverById($uid);

            $sid = $this->session->id();
            $uid = $this->session->get('uid');

            $this->redis->delete('prezit:sessions:secrets:' . $hash);

            // генерируем новый хэш c новый session id
            $newHash = $this->makeHash('sha256', $_SERVER['SALT'] . $sid . $_SERVER['AUTHSALT'] . $uid);

            // меняем хэш в куки
            Cookie::set('secret', $newHash, Date::DAY);

            // сохраняем в редис
            $this->redis->set('prezit:sessions:secrets:' . $hash, $sid . ':' . $uid . ':' . Request::$client_ip, array('nx', 'ex' => 3600 * 24));

            return $uid;
        }

        return NULL;
    }

}