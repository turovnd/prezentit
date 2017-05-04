<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Welcome page
 */
Route::set('WELCOME_PAGE', '')
    ->defaults(array(
        'controller' => 'Welcome',
        'action'     => 'index',
    ))
    ->cache();

/**
 * Why page
 */
Route::set('WELCOME_WHY', 'why')
    ->defaults(array(
        'controller' => 'Welcome',
        'action'     => 'why',
    ))
    ->cache();

/**
 * How-to page
 */
Route::set('WELCOME_HOW_TO', 'how-to')
    ->defaults(array(
        'controller' => 'Welcome',
        'action'     => 'howto',
    ))
    ->cache();
