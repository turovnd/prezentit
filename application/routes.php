<?php defined('SYSPATH') or die('No direct script access.');

$DIGIT  = '\d+';
$STRING = '\w+';


/** Welcome page */
Route::set('Welcome_Page', '')
    ->defaults(array(
        'controller' => 'Welcome',
        'action'     => 'index',
    ))
    ->cache();

/** Authentification */
Route::set('AUTH', 'sign/<mode>(/<additional>)', array('additional' => 'logout|reset'))
    ->filter(function ($route, $params, $request) {

        $params['controller'] = 'Auth';
        $params['action']     = 'Action';
        $params['mode'] = ucfirst($params['mode']);

        $params['controller'] = $params['controller'] . '_' . $params['mode'];
        $params['action']     = 'auth';

        // log out action
        if (!empty($params['additional'])) {
            $params['action'] = $params['additional'];
        }

        return $params;

    });

/**
 * Route for signing up
 */
Route::set('SINGUP', 'signup(/<action>)', array('action' => 'check'))
    ->defaults(array(
        'controller'  => 'SignUp',
        'action'      => 'index',
    ));


Route::set('EMAIL_CONFIRMATION', 'confirm/<hash>')
    ->defaults(array(
        'controller' => 'SignUp',
        'action'     => 'confirmEmail'
    ));

Route::set('RESET_PASSWORD_LINK', 'reset/<hash>')
    ->defaults(array(
        'controller' => 'Auth_Organizer',
        'action'     => 'resetPassword'
    ));


//require_once ('');

?>
