<?php defined('SYSPATH') or die('No direct script access.');

$DIGIT  = '\d+';
$STRING = '\w+';


Route::set('PROFILE', 'app/profile(/<action>)')
    ->defaults(array(
        'controller'  => 'Profile',
        'action'      => 'index',
    ));