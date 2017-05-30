<?php

return array(

    Model_Uploader::SLIDE_BACKGROUND => array(
        'path' => 'uploads/slides/',
        /**
         * Image sizes config
         * key - filename prefix_
         * first argument  — need crop square or should resize with saving ratio
         * second argument — max width
         * third argument  — max height
         */
        'sizes' => array(
            'o'  => array(false, 1500, 1500),
            'm'  => array(true , 100),
            's'  => array(true , 50),
        ),

    ),

    Model_Uploader::SLIDE_ANSWER_IMAGE => array(
        'path' => 'uploads/slides/answers/',
        /**
         * Image sizes config
         * key - filename prefix_
         * first argument  — need crop square or should resize with saving ratio
         * second argument — max width
         * third argument  — max height
         */
        'sizes' => array(
            'o'  => array(false, 1500, 1500),
            'b'  => array(true , 200),
            's'  => array(true , 50),
        ),

    ),

);
