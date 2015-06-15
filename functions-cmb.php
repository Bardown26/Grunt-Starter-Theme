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

add_action( 'cmb2_init', 'yourprefix_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function yourprefix_register_demo_metabox() {
    // Start with an underscore to hide fields from custom fields list
    $prefix = '_yourprefix_demo_';
    /**
     * Sample metabox to demonstrate each field type included
     */
    $cmb_demo = new_cmb2_box( array(
        'id'            => $prefix . 'metabox',
        'title'         => __( 'Test Metabox', 'cmb2' ),
        'object_types'  => array( 'page', ), // Post type
        // 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
        // 'context'    => 'normal',
        // 'priority'   => 'high',
        // 'show_names' => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // true to keep the metabox closed by default
    ) );
    $cmb_demo->add_field( array(
        'name'       => __( 'Test Text', 'cmb2' ),
        'desc'       => __( 'field description (optional)', 'cmb2' ),
        'id'         => $prefix . 'text',
        'type'       => 'text',
        'show_on_cb' => 'yourprefix_hide_if_no_cats', // function should return a bool value
        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
        // 'on_front'        => false, // Optionally designate a field to wp-admin only
        // 'repeatable'      => true,
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Text Small', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'textsmall',
        'type' => 'text_small',
        // 'repeatable' => true,
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Text Medium', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'textmedium',
        'type' => 'text_medium',
        // 'repeatable' => true,
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Website URL', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'url',
        'type' => 'text_url',
        // 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
        // 'repeatable' => true,
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Text Email', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'email',
        'type' => 'text_email',
        // 'repeatable' => true,
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Time', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'time',
        'type' => 'text_time',
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Time zone', 'cmb2' ),
        'desc' => __( 'Time zone', 'cmb2' ),
        'id'   => $prefix . 'timezone',
        'type' => 'select_timezone',
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Date Picker', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'textdate',
        'type' => 'text_date',
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Date Picker (UNIX timestamp)', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'textdate_timestamp',
        'type' => 'text_date_timestamp',
        // 'timezone_meta_key' => $prefix . 'timezone', // Optionally make this field honor the timezone selected in the select_timezone specified above
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Date/Time Picker Combo (UNIX timestamp)', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'datetime_timestamp',
        'type' => 'text_datetime_timestamp',
    ) );
    // This text_datetime_timestamp_timezone field type
    // is only compatible with PHP versions 5.3 or above.
    // Feel free to uncomment and use if your server meets the requirement
    // $cmb_demo->add_field( array(
    // 	'name' => __( 'Test Date/Time Picker/Time zone Combo (serialized DateTime object)', 'cmb2' ),
    // 	'desc' => __( 'field description (optional)', 'cmb2' ),
    // 	'id'   => $prefix . 'datetime_timestamp_timezone',
    // 	'type' => 'text_datetime_timestamp_timezone',
    // ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Money', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'textmoney',
        'type' => 'text_money',
        // 'before_field' => '£', // override '$' symbol if needed
        // 'repeatable' => true,
    ) );
    $cmb_demo->add_field( array(
        'name'    => __( 'Test Color Picker', 'cmb2' ),
        'desc'    => __( 'field description (optional)', 'cmb2' ),
        'id'      => $prefix . 'colorpicker',
        'type'    => 'colorpicker',
        'default' => '#ffffff',
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Text Area', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'textarea',
        'type' => 'textarea',
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Text Area Small', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'textareasmall',
        'type' => 'textarea_small',
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Text Area for Code', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'textarea_code',
        'type' => 'textarea_code',
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Title Weeeee', 'cmb2' ),
        'desc' => __( 'This is a title description', 'cmb2' ),
        'id'   => $prefix . 'title',
        'type' => 'title',
    ) );
    $cmb_demo->add_field( array(
        'name'             => __( 'Test Select', 'cmb2' ),
        'desc'             => __( 'field description (optional)', 'cmb2' ),
        'id'               => $prefix . 'select',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => array(
            'standard' => __( 'Option One', 'cmb2' ),
            'custom'   => __( 'Option Two', 'cmb2' ),
            'none'     => __( 'Option Three', 'cmb2' ),
        ),
    ) );
    $cmb_demo->add_field( array(
        'name'             => __( 'Test Radio inline', 'cmb2' ),
        'desc'             => __( 'field description (optional)', 'cmb2' ),
        'id'               => $prefix . 'radio_inline',
        'type'             => 'radio_inline',
        'show_option_none' => 'No Selection',
        'options'          => array(
            'standard' => __( 'Option One', 'cmb2' ),
            'custom'   => __( 'Option Two', 'cmb2' ),
            'none'     => __( 'Option Three', 'cmb2' ),
        ),
    ) );
    $cmb_demo->add_field( array(
        'name'    => __( 'Test Radio', 'cmb2' ),
        'desc'    => __( 'field description (optional)', 'cmb2' ),
        'id'      => $prefix . 'radio',
        'type'    => 'radio',
        'options' => array(
            'option1' => __( 'Option One', 'cmb2' ),
            'option2' => __( 'Option Two', 'cmb2' ),
            'option3' => __( 'Option Three', 'cmb2' ),
        ),
    ) );
    $cmb_demo->add_field( array(
        'name'     => __( 'Test Taxonomy Radio', 'cmb2' ),
        'desc'     => __( 'field description (optional)', 'cmb2' ),
        'id'       => $prefix . 'text_taxonomy_radio',
        'type'     => 'taxonomy_radio',
        'taxonomy' => 'category', // Taxonomy Slug
        // 'inline'  => true, // Toggles display to inline
    ) );
    $cmb_demo->add_field( array(
        'name'     => __( 'Test Taxonomy Select', 'cmb2' ),
        'desc'     => __( 'field description (optional)', 'cmb2' ),
        'id'       => $prefix . 'taxonomy_select',
        'type'     => 'taxonomy_select',
        'taxonomy' => 'category', // Taxonomy Slug
    ) );
    $cmb_demo->add_field( array(
        'name'     => __( 'Test Taxonomy Multi Checkbox', 'cmb2' ),
        'desc'     => __( 'field description (optional)', 'cmb2' ),
        'id'       => $prefix . 'multitaxonomy',
        'type'     => 'taxonomy_multicheck',
        'taxonomy' => 'post_tag', // Taxonomy Slug
        // 'inline'  => true, // Toggles display to inline
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Checkbox', 'cmb2' ),
        'desc' => __( 'field description (optional)', 'cmb2' ),
        'id'   => $prefix . 'checkbox',
        'type' => 'checkbox',
    ) );
    $cmb_demo->add_field( array(
        'name'    => __( 'Test Multi Checkbox', 'cmb2' ),
        'desc'    => __( 'field description (optional)', 'cmb2' ),
        'id'      => $prefix . 'multicheckbox',
        'type'    => 'multicheck',
        // 'multiple' => true, // Store values in individual rows
        'options' => array(
            'check1' => __( 'Check One', 'cmb2' ),
            'check2' => __( 'Check Two', 'cmb2' ),
            'check3' => __( 'Check Three', 'cmb2' ),
        ),
        // 'inline'  => true, // Toggles display to inline
    ) );
    $cmb_demo->add_field( array(
        'name'    => __( 'Test wysiwyg', 'cmb2' ),
        'desc'    => __( 'field description (optional)', 'cmb2' ),
        'id'      => $prefix . 'wysiwyg',
        'type'    => 'wysiwyg',
        'options' => array( 'textarea_rows' => 5, ),
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'Test Image', 'cmb2' ),
        'desc' => __( 'Upload an image or enter a URL.', 'cmb2' ),
        'id'   => $prefix . 'image',
        'type' => 'file',
    ) );
    $cmb_demo->add_field( array(
        'name'         => __( 'Multiple Files', 'cmb2' ),
        'desc'         => __( 'Upload or add multiple images/attachments.', 'cmb2' ),
        'id'           => $prefix . 'file_list',
        'type'         => 'file_list',
        'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
    ) );
    $cmb_demo->add_field( array(
        'name' => __( 'oEmbed', 'cmb2' ),
        'desc' => __( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'cmb2' ),
        'id'   => $prefix . 'embed',
        'type' => 'oembed',
    ) );
    $cmb_demo->add_field( array(
        'name'         => 'Testing Field Parameters',
        'id'           => $prefix . 'parameters',
        'type'         => 'text',
        'before_row'   => 'yourprefix_before_row_if_2', // callback
        'before'       => '<p>Testing <b>"before"</b> parameter</p>',
        'before_field' => '<p>Testing <b>"before_field"</b> parameter</p>',
        'after_field'  => '<p>Testing <b>"after_field"</b> parameter</p>',
        'after'        => '<p>Testing <b>"after"</b> parameter</p>',
        'after_row'    => '<p>Testing <b>"after_row"</b> parameter</p>',
    ) );
}


