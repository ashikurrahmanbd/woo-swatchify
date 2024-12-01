<?php

namespace PXLS\Swatchify\Admin;



class SwatchTermField{

    function __construct(){

        // Dynamically hook into the "Add New Term" form for product attributes (pa_* taxonomy)
        if ( isset( $_GET['taxonomy'] ) && strpos( $_GET['taxonomy'], 'pa_' ) === 0 ) {

            add_action( $_GET['taxonomy'] . '_add_form_fields', [$this, 'swatchify_add_custom_field_to_terms'] );
            
        }

        //saving term field
        add_action( 'created_term', [$this, 'swatchify_save_custom_field_to_terms'], 10, 2 );



        //adding custom column
        if ( isset( $_GET['taxonomy'] ) && strpos( $_GET['taxonomy'], 'pa_' ) === 0 ) {

            add_action( 'manage_edit-'.$_GET['taxonomy'] . '_columns', [$this, 'add_custom_column'] );
            
        }

        //sortable column
        if ( isset( $_GET['taxonomy'] ) && strpos( $_GET['taxonomy'], 'pa_' ) === 0 ) {

            add_action( 'manage_edit-'.$_GET['taxonomy'] . '_sortable_columns', [$this, 'make_column_sortable'] );
            
        }

        //column content
        if ( isset( $_GET['taxonomy'] ) && strpos( $_GET['taxonomy'], 'pa_' ) === 0 ) {

            add_action( 'manage_'.$_GET['taxonomy'] . '_custom_column', [$this, 'add_column_content'], 10, 3 );
            
        }

    }


    /**
     * Swatch Term Field Addition
    */
    public function swatchify_add_custom_field_to_terms( $taxonomy ) {

        // Check if the taxonomy is a product attribute taxonomy (pa_* like pa_color, pa_size)
        if ( strpos( $taxonomy, 'pa_' ) === 0 ) {

            $taxonomy_name = $taxonomy;

            $taxonomy_id =  wc_attribute_taxonomy_id_by_name($taxonomy_name);

            $swatch_type = get_term_meta( $taxonomy_id, 'swatchify_swatch_type', true );
            
            // Render fields based on the swatch type
            if ( $swatch_type === 'color' ) {

                ?>
                <div class="form-field">
                    <label for="swatchify_term_color">
                        <?php _e( 'Select Color', 'swatchify' ); ?>
                    </label>
                    <input type="color" name="swatchify_term_color" id="swatchify_term_color" />
                    
                </div>
                <?php

            } elseif ( $swatch_type === 'button' ) {
                ?>
                <div class="form-field">
                    <label for="swatchify_term_button"><?php _e( 'Button Style', 'swatchify' ); ?></label>
                    <input type="text" name="swatchify_term_button" id="swatchify_term_button" placeholder="<?php _e( 'Button Style', 'swatchify' ); ?>" />
                </div>
                <?php
            } elseif ( $swatch_type === 'radio' ) {
                ?>
                <div class="form-field">
                    <label for="swatchify_term_radio"><?php _e( 'Radio Option', 'swatchify' ); ?></label>
                    <input type="text" name="swatchify_term_radio" id="swatchify_term_radio" placeholder="<?php _e( 'Enter radio option label', 'swatchify' ); ?>" />
                </div>
                <?php
            }
        }
    }
    

    /**
     * Term Field Save
    */
    public function swatchify_save_custom_field_to_terms( $term_id, $taxonomy ) {

        if ( strpos( $taxonomy, 'pa_' ) === 0 ) {

            if ( isset( $_POST['swatchify_term_color'] ) ) {
                update_term_meta( $term_id, 'swatchify_term_color', sanitize_text_field( $_POST['swatchify_term_color'] ) );
            }

            if ( isset( $_POST['swatchify_term_button'] ) ) {
                update_term_meta( $term_id, 'swatchify_term_button', sanitize_text_field( $_POST['swatchify_term_button'] ) );
            }

            if ( isset( $_POST['swatchify_term_radio'] ) ) {
                update_term_meta( $term_id, 'swatchify_term_radio', sanitize_text_field( $_POST['swatchify_term_radio'] ) );
            }
        }

    }

    /**
     * Add a custom column to the terms table
     */
    public function add_custom_column( $columns ) {

        $taxonomy = isset( $_GET['taxonomy'] ) ? sanitize_text_field( $_GET['taxonomy'] ) : '';

        if ( $taxonomy ) {
            $taxonomy_id = wc_attribute_taxonomy_id_by_name( $taxonomy );
            $swatch_type = get_term_meta( $taxonomy_id, 'swatchify_swatch_type', true );

            if ( $swatch_type === 'color' ) {
                // Insert the custom column after the "Name" column
                $new_columns = [];
                foreach ( $columns as $key => $title ) {
                    $new_columns[$key] = $title;
                    if ( $key === 'name' ) { // Add after "Name" column
                        $new_columns['swatchify_term_color'] = __( 'Color', 'swatchify' );
                    }
                }
                return $new_columns;
            }
        }

        return $columns;
        
        
    }

    // Make the custom column sortable
    public function make_column_sortable( $sortable_columns ) {

        // Set the column key for sorting
        $sortable_columns['swatchify_term_color'] = 'swatchify_term_color';
        return $sortable_columns;

    }

    // Add data to the custom column
    public function add_column_content( $content, $column_name, $term_id ) {

        if ( $column_name === 'swatchify_term_color' ) {

            return $term_id;
        }

        return $content;
    }
    
    




}