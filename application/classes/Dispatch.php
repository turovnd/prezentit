<?php defined('SYSPATH') or die('No direct script access.');

class Dispatch extends Controller_Template
{
    const POST = 'POST';
    const GET  = 'GET';

    /** @var string - Path to template */
    public $template = '';

    /** @var $errors - Page erros */
    protected $errors;

    /** @var  $memcache - Memcache */
    protected $memcache;

    /** @var $redis - Redis instance */
    protected $redis;

    /** @var  $session - Session singleton instance */
    protected $session;

    /** @var  $user - Current user */
    public    $user;

    function before()
    {
        $GLOBALS['SITE_NAME']   = "Prezit";
        $GLOBALS['FROM_ACTION'] = $this->request->action();

        // XSS clean in POST and GET requests
        self::XSSfilter();

        $driver = 'native';
        $this->session = self::sessionInstance($driver);
        $this->setGlobals();

        // XSS clean in POST and GET requests
        self::XSSfilter();

        parent::before();

        if ($this->auto_render) {

            // Initialize with empty values
            $this->template->title       = '';
            $this->template->keywords    = strtolower($GLOBALS['SITE_NAME']) . ', интерактивные презентции, голосование, мгновенные результаты';
            $this->template->description = $GLOBALS['SITE_NAME'] . ' - позволяет провести интерактивные презентации, воркшопы и встречи. Спикеру становится проце взаимодействовать со всей аудиторией в режиме реального времени, посредством проведения электронного голосования с мгновенным получением результатов.';
            $this->template->content     = $GLOBALS['SITE_NAME'];
        }

    }

    /**
    * The after() method is called after your controller action.
    * In our template controller we override this method so that we can
    * make any last minute modifications to the template before anything
    * is rendered.
    */
    public function after()
    {
        parent::after();
    }

    /**
    * Sanitizes GET and POST params
    * @uses HTMLPurifier
    */
    public function XSSfilter()
    {
        $exceptions = array(); // Исключения для полей с визуальным редактором

        foreach ($_POST as $key => $value){

            $value = stripos( $value, 'سمَـَّوُوُحخ ̷̴̐خ ̷̴̐خ ̷̴̐خ امارتيخ ̷̴̐خ') !== false ? '' : $value ;

            if ( in_array($key, $exceptions) === false ){
                $_POST[$key] = Security::xss_clean(HTML::chars($value));
            } else {
                $_POST[$key] = Security::xss_clean( strip_tags(trim($value), '<br><em><del><p><a><b><strong><i><strike><blockquote><ul><li><ol><img><tr><table><td><th><span><h1><h2><h3><iframe><div><code>'));
            }
        }

        foreach ($_GET  as $key => $value) {
            $value = stripos( $value, 'سمَـَّوُوُحخ ̷̴̐خ ̷̴̐خ ̷̴̐خ امارتيخ ̷̴̐خ') !== false ? '' : $value ;
            $_GET[$key] = Security::xss_clean(HTML::chars($value));
        }
    }

    /**
     * Redis connection
     */
    public static function redisInstance()
    {
        $config = Kohana::$config->load('redis.default');

        $redis = new Redis();
        $redis->connect($config['hostname'], $config['port']);
        $redis->auth($config['password']);
        $redis->select(0);

        return $redis;
    }


    public static function memcacheInstance()
    {
        return Cache::instance('memcache');
    }


    public static function sessionInstance($driver)
    {
        return Session::instance($driver);
    }


    private function setGlobals()
    {

        //View::set_global('isLogged', self::isLogged());

        $address = Arr::get($_SERVER, 'HTTP_ORIGIN');

        View::set_global('assets', $address . DIRECTORY_SEPARATOR. 'assets' . DIRECTORY_SEPARATOR);
        View::set_global('website', $address);

        $this->memcache = self::memcacheInstance();
        $this->redis    = self::redisInstance();
    }


    protected static function makeHash($algo, $string) {
        return hash($algo, $string);
    }


    protected function checkCsrf()
    {
        /** Check CSRF */
        if (!isset($_POST['csrf']) || empty($_POST['csrf']) && Security::check(Arr::get($_POST, 'csrf', ''))) {
            throw new HTTP_Exception_403();
        }

        return true;
    }



    /**
     * Return "True" if user is logged
     *
     * Check session id
     * Check session token (make secret from Cookie data and check in redis)
     * @return bool
     */
    public static function isLogged()
    {
        $session = Session::Instance();

        if ( empty($session->get('uid')) ) {
            return false;
        }

        $redis = self::redisInstance();

        /** get data from cookie  */
        $uid    = Cookie::get('uid');
        $sid    = Cookie::get('sid');
        $secret = Cookie::get('secret');
        $hash = self::makeHash('sha256', $_SERVER['SALT'] . $sid . $_SERVER['AUTHSALT'] . $uid);

        if ($redis->get('prezit:sessions:secrets:' . $hash) && $hash == $secret) {

            // Создаем новую сессию
            $auth = new Model_Auth();
            $auth->recoverById($uid);

            $sid = $session->id();
            $uid = $session->get('uid');

            $redis->delete('prezit:sessions:secrets:' . $hash);

            // генерируем новый хэш c новый session id
            $newHash = self::makeHash('sha256', $_SERVER['SALT'] . $sid . $_SERVER['AUTHSALT'] . $uid);

            // меняем хэш в куки
            Cookie::set('secret', $newHash, Date::DAY);

            // сохраняем в редис
            $redis->set('prezit:sessions:secrets:' . $hash, $sid . ':' . $uid . ':' . Request::$client_ip, array('nx', 'ex' => 3600 * 24));

        } else {
            return false;
        }

        return true;
    }

}