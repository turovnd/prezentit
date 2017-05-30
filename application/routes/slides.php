<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Slide add|delete
 */
Route::set('SLIDES_ACTIONS', 'slide/<action>',
    array(
        'action'  => 'add|delete'
    ))
    ->defaults(array(
        'controller'  => 'Slides_Ajax',
        'action'      => 'add',
    ));

/**
 * Slide updating actions
 * - editing
 * - showing
 */
Route::set('SLIDE_UPDATE', 'slide/update/<action>',
    array(
        'action'  => 'order|field|background'
    ))
    ->filter(function ($route, $params, $request) {
        $params['controller']   = 'Slides_Ajax';
        $params['action']       = 'update_' . $params['action'];

        return $params;
    });
