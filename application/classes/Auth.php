<?php defined('SYSPATH') or die('No direct script access.');

abstract class Auth extends Dispatch
{
    /**
     * Get Attempt from Cookie
     * @return int|mixed
     */
    protected function getAttempt()
    {
        return Cookie::get('attempt') ? $this->getAttemptData(Cookie::get('attempt'))['attempts'] : 0 ;
    }

    /**
     * save in coockies attepmts
     */
    protected function makeAttempt()
    {
        $attemptKey = Request::user_agent('platform') . ':' . Request::user_agent('browser') . ':' . Request::$client_ip ;

        if (!Cookie::get('attempt')) {

            $attempt = 0;

        } else {

            $attempt = $this->getAttemptData(Cookie::get('attempt'))['attempts'];

        }

        // incr attempt
        Cookie::set('attempt', $attemptKey. ':' . ++$attempt, Date::MINUTE * 5);
    }


    protected function getAttemptData($salt)
    {
        list($platform, $browser, $ip, $attempts) = explode(':', $salt);

        return array(
            'platform'  => $platform,
            'browser'   => $browser,
            'client_ip' => $ip,
            'attempts'  => $attempts
        );
    }
}