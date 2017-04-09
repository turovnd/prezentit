<?php defined('SYSPATH') or die('No direct script access.');

$DIGIT  = '\d+';
$STRING = '\w+';


/**
 * Main pages in app
 * - show all presentations
 */
Route::set('APP', 'app')
    ->defaults(array(
        'controller'  => 'App_Index',
        'action'      => 'index',
    ));


/**
 * Presentation Actions
 * - create new
 * - delete existed
 */
Route::set('NEW_PRESENTATION', 'app/presentation/<action>(/<id>)',
    array(
        'id'        => $DIGIT,
        'action'    => 'new|delete'
    ))
    ->defaults(array(
        'controller'  => 'App_Ajax',
    ));


/**
 * Presentation Page
 * - editing
 * - showing
 */
Route::set('PRESENTATION', 'app/s/<uri>(/<action>)',
    array(
        'uri'   => $STRING,
        'action'  => 'edit|mobile'
    ))
    ->filter(function ($route, $params, $request) {
        $params['controller']   = 'App_Index';
        $params['action']       = $params['action'] == 'index' ? '' : $params['action'];
        $params['action']       = 'presentation' . $params['action'];

        return $params;
    });
