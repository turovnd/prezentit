<?php defined('SYSPATH') or die('No direct script access.');

$DIGIT  = '\d+';
$STRING = '\w+';


/**
 *
 */
Route::set('APP', 'app(/<action>)')
    ->defaults(array(
        'controller'  => 'App_Index',
        'action'      => 'index',
    ));
