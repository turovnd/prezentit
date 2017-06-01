<?php

return array(
    'native' => array(
        'name' => 'session_name',
        'lifetime' => 2629744,
    ),
    'cookie' => array(
        'name' => 'cookie_name',
        'encrypted' => TRUE,
        'lifetime' => 2629744,
    ),
    'database' => array(
        'name' => 'cookie_name',
        'encrypted' => TRUE,
        'lifetime' => 2629744,
        'group' => 'default',
        'table' => 'table_name',
        'columns' => array(
            'session_id'  => 'session_id',
            'last_active' => 'last_active',
            'contents'    => 'contents'
        ),
        'gc' => 500,
    ),
);