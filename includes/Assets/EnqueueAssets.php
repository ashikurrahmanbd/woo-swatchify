<?php

namespace PXLS\Swatchify\Assets;

class EnqueueAssets{

    function __construct(){

        add_action( 'admin_enqueue_scripts', [$this, 'swatchify_enqueue_assets'] );

    }

    public function swatchify_enqueue_assets(){

        wp_enqueue_script( 

            'swatchify-admin-script', 
            PXLS_SWATCHIFY_ASSETS . '/admin/js/admin-script.js', 
            ['jquery'], 
            filemtime(__FILE__), 
            true,

        );


    }



}