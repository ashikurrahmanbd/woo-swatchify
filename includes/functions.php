<?php

use function PXLS\Swatchify\Admin\get_taxonomy_object;

/**
 * Requiring the WooCommerce Plugin
*/

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    add_action( 'admin_notices', function() {

        echo '<div class="error"><p><strong>Swatchify for WooCommerce</strong> requires WooCommerce to be installed and activated.</p></div>';

    } );
    
    return;
}

/**
 * Fixing The raised error by WooCommerce after requiring
 * 
 * Error 1 -> WP Remote Logging
 * Error 2 -> HPOS (High Performencfe Order Storage)
*/

/**
 * Enabling HPOS
*/

add_action( 'before_woocommerce_init', function() {

    if ( class_exists( \Automattic\WooCommerce\Utilities\OrderUtil::class ) && method_exists( \Automattic\WooCommerce\Utilities\OrderUtil::class, 'custom_orders_table_usage_is_enabled' ) ) {

        add_action( 'woocommerce_init', function() {

            add_filter( 'woocommerce_is_custom_orders_table_usage_enabled', '__return_true' );

        });
    }

});

/**
 * Enabling Remote Logging
*/
if ( class_exists( 'WC_Logger' ) ) {

    $logger = new WC_Logger();

    $logger->add( 'swatchify', 'Log message From Swatchify' );

}

/**
 * Declaring the compatibility
*/
add_filter( 'woocommerce_container_features', function( $features ) {

    $features[] = 'high-performance-order-storage';

    $features[] = 'remote-logging';

    return $features;

} );










//step 3
//code transfered to SwatchTermField class


//step 4
//Save the custom field as term metadata
// function save_custom_field_to_terms( $term_id, $taxonomy ) {

//     // Check if the taxonomy is a product attribute
//     if ( strpos( $taxonomy, 'pa_' ) === 0 ) {

//         // Save the color field value if it's set
//         if ( isset( $_POST['swatchify_term_color'] ) ) {

//             $color_value = sanitize_hex_color( $_POST['swatchify_term_color'] );
//             update_term_meta( $term_id, 'swatchify_term_color', $color_value );

//         }

//     }

// }
// add_action( 'create_term', 'save_custom_field_to_terms', 10, 2 );

/*
add_action( 'pre_get_terms', function ( $query ) {
    if ( isset( $_GET['orderby'] ) && $_GET['orderby'] === 'swatchify_term_color' ) {
        $query->set( 'meta_key', 'swatchify_term_color_value' ); // Replace with your meta key
        $query->set( 'orderby', 'meta_value' );
    }
} );

*/






