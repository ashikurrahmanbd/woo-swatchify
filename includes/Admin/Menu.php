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


        $taxonomy = 'pa_color'; // Your taxonomy
        $term_id = 23;          // Term ID

        // Get the term object
        $term = get_term( $term_id, $taxonomy );

        if ( ! is_wp_error( $term ) && $term ) {
            // Basic term information
            $term_name = $term->name;      // Term name
            $term_slug = $term->slug;      // Term slug
            $term_desc = $term->description; // Term description

            // Fetch custom metadata
            $term_color = get_term_meta( $term_id, 'swatchify_term_color', true ); // Get the color meta

            // Output the data
            echo 'Term Name: ' . esc_html( $term_name ) . '<br>';
            echo 'Term Slug: ' . esc_html( $term_slug ) . '<br>';
            echo 'Term Description: ' . esc_html( $term_desc ) . '<br>';
            echo 'Custom Color Meta: ' . esc_html( $term_color ) . '<br>';
        } else {
            echo 'Error retrieving term information.';
        }
                
        
            
        
       



        ?>

        <div class="wrap">
            <h3>Swatchify for WooCommerce Settings</h3>
        </div>

        <?php

    }



}