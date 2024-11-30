<?php






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



//step 1
function my_edit_wc_attribute_my_field() {

    $id = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;
    
    // Retrieve the swatch type from taxonomy meta data
    $value = $id ? get_term_meta( $id, 'swatchify_swatch_type', true ) : '';

    ?>
    <tr class="form-field">

        <th scope="row" valign="top">
            <label for="swatch_type"><?php _e( 'Swatch Type', 'swatchify' ); ?></label>
        </th>

        <td>
            <select name="swatch_type" id="swatch_type">
                <option value="color" <?php selected( $value, 'color' ); ?>><?php _e( 'Color', 'swatchify' ); ?></option>
                <option value="button" <?php selected( $value, 'button' ); ?>><?php _e( 'Button', 'swatchify' ); ?></option>
                <option value="radio" <?php selected( $value, 'radio' ); ?>><?php _e( 'Radio', 'swatchify' ); ?></option>
            </select>
        </td>

    </tr>
    <?php
}
add_action( 'woocommerce_after_add_attribute_fields', 'my_edit_wc_attribute_my_field' );
add_action( 'woocommerce_after_edit_attribute_fields', 'my_edit_wc_attribute_my_field' );



//step 2
function save_wc_attribute_my_field( $attribute_id ) {

    if ( isset( $_POST['swatch_type'] ) ) {
        $swatch_type = sanitize_text_field( $_POST['swatch_type'] );

        // Convert attribute ID to taxonomy name
        $taxonomy = wc_attribute_taxonomy_name_by_id( $attribute_id );

        if ( taxonomy_exists( $taxonomy ) ) {
            // Save as taxonomy meta
            update_term_meta( $attribute_id, 'swatchify_swatch_type', $swatch_type );
        }
    }

}
add_action( 'woocommerce_attribute_added', 'save_wc_attribute_my_field', 10, 2 );
add_action( 'woocommerce_attribute_updated', 'save_wc_attribute_my_field', 10, 2 );


//step 3
function add_color_picker_to_terms( $term, $taxonomy ) {

    if ( strpos( $taxonomy, 'pa_' ) === 0 ) {
        // Get the attribute ID from the taxonomy name
        $attribute_id = wc_attribute_taxonomy_id_by_name( $taxonomy );

        // Retrieve the swatch type from taxonomy meta
        $swatch_type = get_term_meta( $attribute_id, 'swatchify_swatch_type', true );

        if ( $swatch_type === 'color' ) {
            $color = get_term_meta( $term->term_id, 'swatchify_color', true );
            ?>
            <tr class="form-field">
                <th scope="row">
                    <label for="swatchify_color"><?php _e( 'Swatch Color', 'swatchify' ); ?></label>
                </th>
                <td>
                    <input type="color" name="swatchify_color" id="swatchify_color" value="<?php echo esc_attr( $color ); ?>">
                </td>
            </tr>
            <?php
        }
    }
}
add_action( 'edit_term_form_fields', 'add_color_picker_to_terms', 10, 2 );
add_action( 'pa_colorr_edit_form_fields', 'add_color_picker_to_terms', 10, 2 );


//step 4
function save_color_picker_to_terms( $term_id, $taxonomy ) {

    if ( isset( $_POST['swatchify_color'] ) && strpos( $taxonomy, 'pa_' ) === 0 ) {
        $color = sanitize_hex_color( $_POST['swatchify_color'] );
        update_term_meta( $term_id, 'swatchify_color', $color );
    }
}
add_action( 'edited_term', 'save_color_picker_to_terms', 10, 2 );
add_action( 'create_term', 'save_color_picker_to_terms', 10, 2 );



//step 5
function render_swatchify_variation_swatch( $term, $taxonomy ) {

    if ( strpos( $taxonomy, 'pa_' ) === 0 ) {
        // Get the attribute ID from the taxonomy name
        $attribute_id = wc_attribute_taxonomy_id_by_name( $taxonomy );

        // Retrieve the swatch type from taxonomy meta
        $swatch_type = get_term_meta( $attribute_id, 'swatchify_swatch_type', true );

        if ( $swatch_type === 'color' ) {

            $color = get_term_meta( $term->term_id, 'swatchify_color', true );
            echo '<span class="swatchify-color-swatch" style="background-color: ' . esc_attr( $color ) . ';"></span>';

        } elseif ( $swatch_type === 'button' ) {

            echo '<button class="swatchify-button-swatch">' . esc_html( $term->name ) . '</button>';

        } elseif ( $swatch_type === 'radio' ) {

            echo '<label class="swatchify-radio-swatch"><input type="radio" name="swatch" value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</label>';

        }
    }

}
add_action( 'woocommerce_after_shop_loop_item_title', 'render_swatchify_variation_swatch', 10, 2 );

