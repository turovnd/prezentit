<?php defined('SYSPATH') or die('No direct script access.');

$DIGIT  = '\d+';
$STRING = '\w+';


/**
 * Authentication || Registration Pages
 */
Route::set('AUTH_PAGES', '<action>',
    array(
        'action' => 'login|signup'
    ))
    ->defaults(array(
        'controller'  => 'Auth_Index',
        'action'      => 'login',
    ));


/**
 * Authorization ajax action
 */
Route::set('AUTH_ACTIONS', 'auth/<action>',
    array(
        'action' => 'signup|signin|forget|reset'
    ))
    ->defaults(array(
        'controller'  => 'Auth_Ajax',
        'action'      => 'index',
    ));


Route::set('EMAIL_CONFIRMATION', 'auth/confirm/<hash>')
    ->defaults(array(
        'controller' => 'Auth_Ajax',
        'action'     => 'confirmEmail'
    ));

Route::set('RESET_PASSWORD_LINK', 'auth/reset/<hash>')
    ->defaults(array(
        'controller' => 'Auth_Ajax',
        'action'     => 'resetPassword'
    ));
