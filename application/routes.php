<?php defined('SYSPATH') or die('No direct script access.');

$DIGIT  = '\d+';
$STRING = '\w+';



require_once ('routes/welcome.php');
require_once ('routes/auth.php');
require_once ('routes/profile.php');
require_once ('routes/app.php');
require_once ('routes/slides.php');
//require_once ('');


/**
 * Route for file (image) uploading
 * Only for XMLHTTP requests
 */
Route::set('IMAGE_TRANSPORT', 'transport/<type>')
    ->defaults(array(
        'controller' => 'Transport',
        'action'     => 'upload'
    ));


?>
