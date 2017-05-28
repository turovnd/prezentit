<?php defined('SYSPATH') or die('No direct script access.');

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
Route::set('NEW_PRESENTATION', 'presentation/<action>',
    array(
        'action'    => 'new|delete|editname'
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