<?php
add_filter( 'cmb2_meta_boxes', 'site_custom_metaboxes' );

// render numbers
add_action( 'cmb2_render_text_number', 'sm_cmb_render_text_number', 10, 5 );
function sm_cmb_render_text_number( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
	echo $field_type_object->input( array( 'class' => 'cmb2-text-small', 'type' => 'number' ) );
}

// sanitize the field
add_filter( 'cmb2_sanitize_text_number', 'sm_cmb2_sanitize_text_number', 10, 2 );
function sm_cmb2_sanitize_text_number( $null, $new ) {
	$new = preg_replace( "/[^.0-9]/", "", $new );

	return $new;
}
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function site_custom_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cmb2_';

	/**
	 * Menu CPT Meta Box
	 */
	$meta_boxes['menu_metabox'] = array(
		'id'            => 'menu_metabox',
		'title'         => __( 'Price', 'cmb2' ),
		'object_types'  => array( 'menu', ), // Post type
        //'show_on' => array( 'key' => 'page-template', 'value' => 'template-homepage.php' ),
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'closed'     => true, // true to keep the metabox closed by default
		'fields'        => array(
			array(
				'name' => 'Price',
				'desc' => '',
				'type' => 'text_small',
				'id'   => $prefix . 'price'
			),
		)
	);


    /**
     * Repeatable Field Groups

    $meta_boxes['field_group'] = array(
        'id'           => 'field_group',
        'title'        => __( 'About the Company', 'cmb2' ),
        'closed'     => true, // true to keep the metabox closed by default
        'object_types' => array( 'page', ),
        'show_on' => array( 'key' => 'page-template', 'value' => 'template-homepage.php' ),
        'fields'       => array(
            array(
                'id'          => $prefix . 'repeat_group',
                'type'        => 'group',
                'options'     => array(
                    'group_title'   => __( 'Item {#}', 'cmb2' ), // {#} gets replaced by row number
                    'add_button'    => __( 'Add Another Item', 'cmb2' ),
                    'remove_button' => __( 'Remove Item', 'cmb2' ),
                    'sortable'      => true, // beta
                ),
                'fields'      => array(
                    array(
                        'name' => 'Title',
                        'id' => 'home_about_title',
                        'type' => 'text',
                    ),
                    array(
                        'name' => 'Image',
                        'id' => 'home_about_image',
                        'type' => 'file',
                    ),
                ),
            ),
        ),
    );
     */
    // Add other metaboxes as needed

	return $meta_boxes;
}

