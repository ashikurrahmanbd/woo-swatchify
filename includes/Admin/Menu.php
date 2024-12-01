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

        echo PXLS_SWATCHIFY_ASSETS;

        echo "<br />";

        if( has_filter( 'woocommerce_attribute_table_columns' ) ){

            echo "hook ache";

        }


        function get_taxonomy_object( $taxonomy ) {
            $taxonomy_object = get_taxonomy( $taxonomy );
            
            if ( $taxonomy_object ) {
                return $taxonomy_object;  // Returns the full taxonomy object
            }
            
            return null;  // Return null if no taxonomy is found
        }
        
        


        $term_meta = get_term_meta( 29, 'swatchify_swatch_type', true );

        $term_name = wc_attribute_taxonomy_id_by_name('pa_color');

        echo $term_name;


    


        ?>

        <div class="wrap">
            <h3>Swatchify for WooCommerce Settings</h3>
        </div>

        <?php

    }



}