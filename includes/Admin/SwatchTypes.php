<?php

namespace PXLS\Swatchify\Admin;

class SwatchTypes{

    function __construct(){


        /**
         * Adding Swatch type selection option to the attribute
         */
        add_action( 'woocommerce_after_add_attribute_fields', [$this, 'swatchify_swatch_type_select'] );

        add_action( 'woocommerce_after_edit_attribute_fields', [$this, 'swatchify_swatch_type_select'] );

        /**
         * update the attribute Swatch type to the taxonomy
         */

        add_action( 'woocommerce_attribute_added', [$this, 'swatchify_save_wc_attribute_type_field'], 10, 2 );

        add_action( 'woocommerce_attribute_updated', [$this, 'swatchify_save_wc_attribute_type_field'], 10, 2 );

        /**
         * Add Filter to add a custom column to the attribute tables
        */


        /**
         * Delete the TermMeta while deleting a Attribute 
        */
        add_action( 'woocommerce_attribute_deleted', [$this, 'delete_swatchify_swatch_type_meta'], 10, 1 );

        
        

    }



    /**
     * adding the selectoin option to select the swatchify Swatch type select
     * @return void
     */
    public function swatchify_swatch_type_select() {

        $id = isset( $_GET['edit'] ) ? absint( $_GET['edit'] ) : 0;
        
        // Retrieve the swatch type from taxonomy meta data
        $value = $id ? get_term_meta( $id, 'swatchify_swatch_type', true ) : '';
    
        ?>
        <tr class="form-field">
    
            <th scope="row" valign="top">
                <label for="swatchify_swatch_type"><?php _e( 'Swatch Type', 'swatchify' ); ?></label>
            </th>
    
            <td>
                <select name="swatchify_swatch_type" id="swatchify_swatch_type">
                    <option value="color" <?php selected( $value, 'color' ); ?>><?php _e( 'Color', 'swatchify' ); ?></option>
                    <option value="button" <?php selected( $value, 'button' ); ?>><?php _e( 'Button', 'swatchify' ); ?></option>
                    <option value="radio" <?php selected( $value, 'radio' ); ?>><?php _e( 'Radio', 'swatchify' ); ?></option>
                </select>
            </td>
    
        </tr>
        <?php
    }


    /**
     * Save swatch type field to the taxonomy meta data
    */
    public function swatchify_save_wc_attribute_type_field( $attribute_id ) {

        if ( isset( $_POST['swatchify_swatch_type'] ) ) {

            $swatch_type = sanitize_text_field( $_POST['swatchify_swatch_type'] );
            
            // Save as taxonomy meta
            update_term_meta( $attribute_id, 'swatchify_swatch_type', $swatch_type );
            

        }

        
    
    }

    /**
     * Delete Term Meta 
    */
    public function delete_swatchify_swatch_type_meta($attribute_id){

        delete_term_meta( $attribute_id, 'swatchify_swatch_type' );

    }


}