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