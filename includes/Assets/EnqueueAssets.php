<?php

namespace PXLS\Swatchify\Assets;

class EnqueueAssets{

    function __construct(){

        add_action( 'admin_enqueue_scripts', [$this, 'swatchify_enqueue_assets'] );

    }

    public function swatchify_enqueue_assets(){

        //register script
        wp_register_script( 

            'swatchify-admin-script', 
            PXLS_SWATCHIFY_ASSETS . '/admin/js/admin-script.js', 
            ['jquery'], 
            filemtime(__FILE__), 
            true,

        );

        //register style
        wp_register_style( 
            'swatchify-admin-style', 
            PXLS_SWATCHIFY_ASSETS . '/admin/css/admin-style.css', 
            [], 
            filemtime(__FILE__), 
    
        );

        

        wp_enqueue_style('swatchify-admin-style');
        wp_enqueue_script('swatchify-admin-script');
        


    }



}