<?php

class Model_Auth extends Model {

    private $_session = null;
    private $_session_driver = 'native';

    public function __construct()
    {
        $this->_session = Dispatch::sessionInstance($this->_session_driver);
    }

    public function login($email, $password, $remember = false)
    {
        $select = Dao_Users::select('*')
            ->where('email', '=', $email)
            ->where('password', '=', $password)
            ->limit(1)
            ->execute();

        if (Arr::get($select, 'id'))
        {
            $this->complete($select);
            return true;
        }

        return false;
    }

    public function recoverById($id)
    {
        $select = Dao_Users::select('*')
            ->where('id', '=', $id)
            ->limit(1)
            ->execute();

        if (Arr::get($select, 'id')) {
            $this->complete($select);
            return true;
        }

        return false;
    }

    public function logout($destroy = FALSE)
    {
        if ($destroy === TRUE)
        {
            // Destroy the session completely
            $this->_session->destroy();
        }
        else
        {
            // Remove the user from the session
            $this->_session->delete();

        }

        return false;
    }

    private function complete($select) {

        $this->_session->set('uid', $select['id']);
        $this->_session->set('lastname', $select['lastname']);
        $this->_session->set('name', $select['name']);
        $this->_session->set('email', $select['email']);

        $sessionId = $this->_session->id();
        Cookie::set('uid', $select['id'], Date::DAY);
        Cookie::set('sid', $sessionId, Date::DAY);

    }
}