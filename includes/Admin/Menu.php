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


        function get_global_attribute_info( $attribute_id ) {
            // Convert the attribute ID to the taxonomy name
            $taxonomy = wc_attribute_taxonomy_name_by_id( $attribute_id );
        
            // Check if the taxonomy exists
            if ( ! taxonomy_exists( $taxonomy ) ) {
                return __( 'Invalid attribute ID.', 'woocommerce' );
            }
        
            // Fetch the attribute information from the WooCommerce attribute table
            global $wpdb;
            $attribute_table = $wpdb->prefix . 'woocommerce_attribute_taxonomies';
            $attribute_data = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT * FROM {$attribute_table} WHERE attribute_id = %d",
                    $attribute_id
                )
            );
        
            if ( ! $attribute_data ) {
                return __( 'Attribute not found.', 'woocommerce' );
            }
        
            // Get terms for the attribute (if any)
            $terms = get_terms( [
                'taxonomy'   => $taxonomy,
                'hide_empty' => false, // Set to true if you only want terms that are in use
            ] );
        
            // Fetch custom meta fields (if available)
            $custom_meta = [];
            if ( function_exists( 'get_term_meta' ) ) {
                foreach ( $terms as $term ) {
                    $term_meta = get_term_meta( $term->term_id ); // Fetch all meta for the term
                    $custom_meta[ $term->term_id ] = $term_meta;
                }
            }
        
            // Return all gathered data
            return [
                'attribute_name'   => $attribute_data->attribute_name,
                'attribute_slug'   => $taxonomy,
                'attribute_label'  => $attribute_data->attribute_label,
                'attribute_type'   => $attribute_data->attribute_type,
                'terms'            => $terms, // Term objects
                'custom_meta'      => $custom_meta, // Meta fields
            ];
        }
        
        // Example usage
        $attribute_id = 2; // Replace with your attribute ID
        $attribute_info = get_global_attribute_info( $attribute_id );
        
        if ( is_array( $attribute_info ) ) {
            echo '<pre>';
            print_r( $attribute_info );
            echo '</pre>';
        } else {
            echo esc_html( $attribute_info ); // Displays an error message
        }



        ?>

        <div class="wrap">
            <h3>Swatchify for WooCommerce Settings</h3>
        </div>

        <?php

    }



}