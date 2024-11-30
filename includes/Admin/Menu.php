<?php

namespace PXLS\Swatchify\Admin;

class Menu{

    function __construct(){

        add_action( 'admin_menu', [$this, 'plugin_menu'] );

    }

    //admin menu 
    public function plugin_menu(){

        add_menu_page( 

            __('WOO Swatchify', 'swatchify'), 
            __('WOO Swatchify', 'swatchify'),  
            'manage_options', 
            'pxls-swatchify-settings', 
            [$this, 'pxls_swatchify_settings'], 
            'dashicons-image-filter', 
            50

        );

    }

    //admin menu page callback
    public function pxls_swatchify_settings(){

        echo "hello";

    }



}