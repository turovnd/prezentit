<?php defined('SYSPATH') or die('No direct script access.');

$DIGIT  = '\d+';
$STRING = '\w+';


/**
 * Welcome page
 */
Route::set('Welcome_Page', '')
    ->defaults(array(
        'controller' => 'Welcome',
        'action'     => 'index',
    ))
    ->cache();

/**
 * New Subscribe
 */
Route::set('NEW_SUBSCRIBER', 'newsubscriber')
    ->defaults(array(
        'controller' => 'Welcome',
        'action'     => 'newsubscriber',
    ))
    ->cache();