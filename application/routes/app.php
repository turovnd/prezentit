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
