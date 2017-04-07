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
 * Create New Presentation
 */
Route::set('NEW_PRESENTATION', 'app/newpresentation')
    ->defaults(array(
        'controller'  => 'App_Ajax',
        'action'      => 'newpresentation',
    ));


/**
 * Presentation Page
 * - editing
 * - showing
 */
Route::set('PRESENTATION', 'app/s/<uri>(/<action>)',
    array(
        'uri'   => $STRING,
        'action'  => 'edit|invite'
    ))
    ->filter(function ($route, $params, $request) {
        $params['controller']   = 'App_Index';
        $params['action']       = $params['action'] == 'index' ? '' : $params['action'];
        $params['action']       = 'presentation' . $params['action'];

        return $params;
    });
