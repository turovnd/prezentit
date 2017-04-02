<?php defined('SYSPATH') or die('No direct script access.');

$DIGIT  = '\d+';
$STRING = '\w+';


/**
 * Authentication || Registration Pages
 */
Route::set('AUTH', '<action>',
    array(
        'action' => 'login|signup'
    ))
    ->defaults(array(
        'controller'  => 'Auth_Index',
        'action'      => 'login',
    ));




Route::set('AUTH1', 'auth/<action>',
    array(
        'action' => 'signup|signin|reset'
    ))
    ->defaults(array(
        'controller'  => 'Auth_Ajax',
        'action'      => 'index',
    ));
        /*->filter(function ($route, $params, $request) {

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

        });*/




/**
* Route for SignUp
*
Route::set('SINGUP', 'signup')
    ->defaults(array(
        'controller'  => 'Auth_SignUp',
        'action'      => 'signup',
    ));
*/

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
