<?php

namespace PXLS\Swatchify\Frontend;

class Shortcode{

    function __construct(){

        add_shortcode( 'testt_shortcode', [$this, 'testt_shortcode_callback']);

    }


    public function testt_shortcode_callback(){

        //shortcode always do return not echo or print

    }

}