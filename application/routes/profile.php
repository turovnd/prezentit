<?php defined('SYSPATH') or die('No direct script access.');


Route::set('PROFILE', 'app/profile(/<action>)')
    ->defaults(array(
        'controller'  => 'Profile',
        'action'      => 'index',
    ));