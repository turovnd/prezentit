<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Add new Slide
 */
Route::set('SLIDES_ACTIONS', 'slide/<action>')
    ->defaults(array(
        'controller'  => 'Slides_Ajax',
        'action'      => 'add',
    ));
