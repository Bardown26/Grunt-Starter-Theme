<?php 
/**
 * init.php
 *
 * Load the widget files.
 */
 
require_once( FRAMEWORK . '/widgets/widget-business-hours.php' );

function tresnic_example_theme_menu() {

    add_theme_page(
        'Theme Options', 					// The title to be displayed in the browser window for this page.
        'Theme Options',					// The text to be displayed for this menu item
        'administrator',					// Which type of users can see this menu item
        'tresnic_theme_options',			// The unique ID - that is, the slug - for this menu item
        'tresnic_theme_display'				// The name of the function to call when rendering this menu's page
    );

    add_menu_page(
        'Theme Options',					// The value used to populate the browser's title bar when the menu page is active
        'Theme Options',					// The text of the menu in the administrator's sidebar
        'administrator',					// What roles are able to access the menu
        'tresnic_theme_menu',				// The ID used to bind submenu items to this menu
        'tresnic_theme_display',            // The callback function used to render this menu
        '',
        "62"
    );

} // end tresnic_example_theme_menu
add_action( 'admin_menu', 'tresnic_example_theme_menu' );

/**
 * Renders a simple page to display for the theme menu defined above.
 */
function tresnic_theme_display( $active_tab = '' ) {
    ?>
    <!-- Create a header in the default WordPress 'wrap' container -->
    <div class="wrap">

        <div id="icon-themes" class="icon32"></div>
        <h2><?php _e( 'Tresnic Theme Options', 'tresnic' ); ?></h2>
        <?php settings_errors(); ?>

        <?php if( isset( $_GET[ 'tab' ] ) ) {
            $active_tab = $_GET[ 'tab' ];
        } else if( $active_tab == 'social_options' ) {
            $active_tab = 'social_options';
        } else if( $active_tab == 'input_examples' ) {
            $active_tab = 'input_examples';
        } else if( $active_tab == 'theme_fonts' ) {
            $active_tab = 'theme_fonts';
        } else if( $active_tab == 'theme_analytics' ) {
            $active_tab = 'theme_analytics';
        } else {
            $active_tab = 'social_options';
        } // end if/else ?>

        <h2 class="nav-tab-wrapper">
            <!--<a href="?page=tresnic_theme_options&tab=display_options" class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Display Options', 'tresnic' ); ?></a>-->
            <a href="?page=tresnic_theme_options&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Social Options', 'tresnic' ); ?></a>
            <!--<a href="?page=tresnic_theme_options&tab=input_examples" class="nav-tab <?php echo $active_tab == 'input_examples' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Input Examples', 'tresnic' ); ?></a>-->
            <!--<a href="?page=tresnic_theme_options&tab=theme_fonts" class="nav-tab <?php echo $active_tab == 'theme_fonts' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Fonts', 'tresnic' ); ?></a>
            <a href="?page=tresnic_theme_options&tab=theme_analytics" class="nav-tab <?php echo $active_tab == 'theme_analytics' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Google Analytics', 'tresnic' ); ?></a>-->
        </h2>

        <form method="post" action="options.php">
            <?php

            if( $active_tab == 'display_options' ) {

                settings_fields( 'tresnic_theme_display_options' );
                do_settings_sections( 'tresnic_theme_display_options' );
	            submit_button();

            } elseif( $active_tab == 'social_options' ) {

                settings_fields( 'tresnic_theme_social_options' );
                do_settings_sections( 'tresnic_theme_social_options' );
	            submit_button();

            } elseif( $active_tab == 'theme_fonts' ) {

	            settings_fields( 'tresnic_theme_fonts' );
	            do_settings_sections( 'tresnic_theme_fonts' );

            } elseif( $active_tab == 'theme_analytics' ) {

	            settings_fields( 'tresnic_theme_analytics' );
	            do_settings_sections( 'tresnic_theme_analytics' );
	            submit_button();

            } else {

	            settings_fields( 'tresnic_theme_input_examples' );
	            do_settings_sections( 'tresnic_theme_input_examples' );
	            submit_button();

            } // end if/else


            ?>
        </form>

    </div><!-- /.wrap -->
<?php
} // end tresnic_theme_display

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */


/**
 * Provides default values for the Social Options.
 */
function tresnic_theme_default_social_options() {

    $defaults = array(
        'twitter'		=>	'',
        'facebook'		=>	'',
        'googleplus'	=>	'',
    );

    return apply_filters( 'tresnic_theme_default_social_options', $defaults );

} // end tresnic_theme_default_social_options

/**
 * Provides default values for the Display Options.
 */
function tresnic_theme_default_display_options() {

    $defaults = array(
        'show_header'		=>	'',
        'show_content'		=>	'',
        'show_footer'		=>	'',
    );

    return apply_filters( 'tresnic_theme_default_display_options', $defaults );

} // end tresnic_theme_default_display_options

/**
 * Provides default values for the Fonts.
 */
function tresnic_theme_default_fonts() {

    $defaults = array(
        'body-font'		=>	'Lobster',
        'h3-font'		=>	'Lobster'
    );

    return apply_filters( 'tresnic_theme_default_fonts', $defaults );

} // end tresnic_theme_default_display_options

/**
 * Provides default values for the Input Options.
 */
function tresnic_theme_default_input_options() {

    $defaults = array(
        'input_example'		=>	'',
        'textarea_example'	=>	'',
        'checkbox_example'	=>	'',
        'radio_example'		=>	'',
        'time_options'		=>	'default'
    );

    return apply_filters( 'tresnic_theme_default_input_options', $defaults );

} // end tresnic_theme_default_input_options



/**
 * Initializes the theme's display options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
function tresnic_initialize_theme_options() {

    // If the theme options don't exist, create them.
    if( false == get_option( 'tresnic_theme_display_options' ) ) {
        add_option( 'tresnic_theme_display_options', apply_filters( 'tresnic_theme_default_display_options', tresnic_theme_default_display_options() ) );
    } // end if

    // First, we register a section. This is necessary since all future options must belong to a
    add_settings_section(
        'general_settings_section',			// ID used to identify this section and with which to register options
        __( 'Display Options', 'tresnic' ),		// Title to be displayed on the administration page
        'tresnic_general_options_callback',	// Callback used to render the description of the section
        'tresnic_theme_display_options'		// Page on which to add this section of options
    );

    // Next, we'll introduce the fields for toggling the visibility of content elements.
    add_settings_field(
        'show_header',						// ID used to identify the field throughout the theme
        __( 'Header', 'tresnic' ),							// The label to the left of the option interface element
        'tresnic_toggle_header_callback',	// The name of the function responsible for rendering the option interface
        'tresnic_theme_display_options',	// The page on which this option will be displayed
        'general_settings_section',			// The name of the section to which this field belongs
        array(								// The array of arguments to pass to the callback. In this case, just a description.
            __( 'Activate this setting to display the header.', 'tresnic' ),
        )
    );

    add_settings_field(
        'show_content',
        __( 'Content', 'tresnic' ),
        'tresnic_toggle_content_callback',
        'tresnic_theme_display_options',
        'general_settings_section',
        array(
            __( 'Activate this setting to display the content.', 'tresnic' ),
        )
    );

    add_settings_field(
        'show_footer',
        __( 'Footer', 'tresnic' ),
        'tresnic_toggle_footer_callback',
        'tresnic_theme_display_options',
        'general_settings_section',
        array(
            __( 'Activate this setting to display the footer.', 'tresnic' ),
        )
    );

    // Finally, we register the fields with WordPress
    register_setting(
        'tresnic_theme_display_options',
        'tresnic_theme_display_options'
    );

} // end tresnic_initialize_theme_options
add_action( 'admin_init', 'tresnic_initialize_theme_options' );

/**
 * Initializes the theme's social options by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
function tresnic_theme_initialize_social_options() {

    if( false == get_option( 'tresnic_theme_social_options' ) ) {
        add_option( 'tresnic_theme_social_options', apply_filters( 'tresnic_theme_default_social_options', tresnic_theme_default_social_options() ) );
    } // end if

    add_settings_section(
        'social_settings_section',			// ID used to identify this section and with which to register options
        __( 'Social Options', 'tresnic' ),		// Title to be displayed on the administration page
        'tresnic_social_options_callback',	// Callback used to render the description of the section
        'tresnic_theme_social_options'		// Page on which to add this section of options
    );

    add_settings_field(
        'twitter',
        'Twitter',
        'tresnic_twitter_callback',
        'tresnic_theme_social_options',
        'social_settings_section'
    );

    add_settings_field(
        'facebook',
        'Facebook',
        'tresnic_facebook_callback',
        'tresnic_theme_social_options',
        'social_settings_section'
    );

    add_settings_field(
        'googleplus',
        'Google+',
        'tresnic_googleplus_callback',
        'tresnic_theme_social_options',
        'social_settings_section'
    );

	add_settings_field(
        'linkedin',
        'Linkedin',
        'tresnic_linkedin_callback',
        'tresnic_theme_social_options',
        'social_settings_section'
    );

	add_settings_field(
        'pinterest',
        'Pinterest',
        'tresnic_pinterest_callback',
        'tresnic_theme_social_options',
        'social_settings_section'
    );

	add_settings_field(
        'instagram',
        'Instagram',
        'tresnic_instagram_callback',
        'tresnic_theme_social_options',
        'social_settings_section'
    );

    add_settings_field(
        'yelp',
        'Yelp',
        'tresnic_yelp_callback',
        'tresnic_theme_social_options',
        'social_settings_section'
    );

    register_setting(
        'tresnic_theme_social_options',
        'tresnic_theme_social_options',
        'tresnic_theme_sanitize_social_options'
    );

} // end tresnic_theme_initialize_social_options
add_action( 'admin_init', 'tresnic_theme_initialize_social_options' );

/**
 * Initializes the theme's social options by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
function tresnic_theme_initialize_fonts() {

	if( false == get_option( 'tresnic_theme_fonts' ) ) {
		add_option( 'tresnic_theme_fonts', apply_filters( 'tresnic_theme_default_fonts', tresnic_theme_default_fonts() ) );
	} // end if

	add_settings_section(
		'font_section',			// ID used to identify this section and with which to register options
		__( '', 'tresnic' ),		// Title to be displayed on the administration page
		'fonts',	// Callback used to render the description of the section
		'tresnic_theme_fonts'		// Page on which to add this section of options
	);

	register_setting(
		'tresnic_theme_fonts',
		'tresnic_theme_fonts',
		'tresnic_theme_sanitize_social_options'
	);

} // end tresnic_theme_initialize_fonts


add_action( 'admin_init', 'tresnic_theme_initialize_fonts' );

function font_init() {
	register_setting( 'fonts', 'fonts' );

	// Settings fields and sections
	add_settings_section( 'font_section', 'Typography Options', 'font_description', 'fonts' );
	add_settings_field( 'body-font', 'Body Font', 'body_font_field', 'fonts', 'font_section' );
	add_settings_field( 'h3-font', 'H3 Font', 'h3_font_field', 'fonts', 'font_section' );
}
add_action( 'admin_init', 'font_init' );


function tresnic_theme_initialize_google_analytics() {

    if( false == get_option( 'tresnic_theme_analytics' ) ) {
        add_option( 'tresnic_theme_analytics' );
    } // end if

    add_settings_section(
        'analytics',
        __( 'Google Analytics', 'tresnic' ),
        'tresnic_analytics_intro',
        'tresnic_theme_analytics'
    );

    add_settings_field(
        'Google Analytics',
        __( 'Google Analytics', 'tresnic' ),
        'google_analytics_setting',
        'tresnic_theme_analytics',
        'analytics'
    );

	add_settings_field(
        'Google Webmaster',
        __( 'Google Webmaster', 'tresnic' ),
        'google_webmaster_setting',
        'tresnic_theme_analytics',
        'analytics'
    );


    register_setting(
        'tresnic_theme_analytics',
        'tresnic_theme_analytics'
    );

} // end tresnic_theme_initialize_input_examples
add_action( 'admin_init', 'tresnic_theme_initialize_google_analytics' );




/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */

/**
 * This function provides a simple description for the General Options page.
 *
 * It's called from the 'tresnic_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function tresnic_general_options_callback() {
    echo '<p>' . __( 'Select which areas of content you wish to display.', 'tresnic' ) . '</p>';
} // end tresnic_general_options_callback

/**
 * This function provides a simple description for the Social Options page.
 *
 * It's called from the 'tresnic_theme_initialize_social_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function tresnic_social_options_callback() {
    echo '<p>' . __( 'Provide the URL to the social networks you\'d like to display.', 'tresnic' ) . '</p>';
} // end tresnic_general_options_callback

/**
 * This function provides a simple description for the Input Examples page.
 *
 * It's called from the 'tresnic_theme_initialize_input_examples_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function tresnic_input_examples_callback() {
    echo '<p>' . __( 'Provides examples of the five basic element types.', 'tresnic' ) . '</p>';
} // end tresnic_general_options_callback



/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */

/**
 * This function renders the interface elements for toggling the visibility of the header element.
 *
 * It accepts an array or arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */
function tresnic_toggle_header_callback($args) {

    // First, we read the options collection
    $options = get_option('tresnic_theme_display_options');

    // Next, we update the name attribute to access this element's ID in the context of the display options array
    // We also access the show_header element of the options collection in the call to the checked() helper function
    $html = '<input type="checkbox" id="show_header" name="tresnic_theme_display_options[show_header]" value="1" ' . checked( 1, isset( $options['show_header'] ) ? $options['show_header'] : 0, false ) . '/>';

    // Here, we'll take the first argument of the array and add it to a label next to the checkbox
    $html .= '<label for="show_header">&nbsp;'  . $args[0] . '</label>';

    echo $html;

} // end tresnic_toggle_header_callback


function tresnic_toggle_content_callback($args) {

    $options = get_option('tresnic_theme_display_options');

    $html = '<input type="checkbox" id="show_content" name="tresnic_theme_display_options[show_content]" value="1" ' . checked( 1, isset( $options['show_content'] ) ? $options['show_content'] : 0, false ) . '/>';
    $html .= '<label for="show_content">&nbsp;'  . $args[0] . '</label>';

    echo $html;

} // end tresnic_toggle_content_callback

function tresnic_toggle_footer_callback($args) {

    $options = get_option('tresnic_theme_display_options');

    $html = '<input type="checkbox" id="show_footer" name="tresnic_theme_display_options[show_footer]" value="1" ' . checked( 1, isset( $options['show_footer'] ) ? $options['show_footer'] : 0, false ) . '/>';
    $html .= '<label for="show_footer">&nbsp;'  . $args[0] . '</label>';

    echo $html;

} // end tresnic_toggle_footer_callback

function tresnic_twitter_callback() {

    // First, we read the social options collection
    $options = get_option( 'tresnic_theme_social_options' );

    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
    $url = '';
    if( isset( $options['twitter'] ) ) {
        $url = esc_url( $options['twitter'] );
    } // end if

    // Render the output
    echo '<input type="text" id="twitter" name="tresnic_theme_social_options[twitter]" value="' . $url . '" />';

} // end tresnic_twitter_callback

function tresnic_facebook_callback() {

    $options = get_option( 'tresnic_theme_social_options' );

    $url = '';
    if( isset( $options['facebook'] ) ) {
        $url = esc_url( $options['facebook'] );
    } // end if

    // Render the output
    echo '<input type="text" id="facebook" name="tresnic_theme_social_options[facebook]" value="' . $url . '" />';

} // end tresnic_facebook_callback

function tresnic_googleplus_callback() {

    $options = get_option( 'tresnic_theme_social_options' );

    $url = '';
    if( isset( $options['googleplus'] ) ) {
        $url = esc_url( $options['googleplus'] );
    } // end if

    // Render the output
    echo '<input type="text" id="googleplus" name="tresnic_theme_social_options[googleplus]" value="' . $url . '" />';

} // end tresnic_googleplus_callback

function tresnic_linkedin_callback() {

    $options = get_option( 'tresnic_theme_social_options' );

    $url = '';
    if( isset( $options['linkedin'] ) ) {
        $url = esc_url( $options['linkedin'] );
    } // end if

    // Render the output
    echo '<input type="text" id="linkedin" name="tresnic_theme_social_options[linkedin]" value="' . $url . '" />';

} // end tresnic_googleplus_callback

function tresnic_pinterest_callback() {

    $options = get_option( 'tresnic_theme_social_options' );

    $url = '';
    if( isset( $options['pinterest'] ) ) {
        $url = esc_url( $options['pinterest'] );
    } // end if

    // Render the output
    echo '<input type="text" id="pinterest" name="tresnic_theme_social_options[pinterest]" value="' . $url . '" />';

} // end tresnic_googleplus_callback

function tresnic_instagram_callback() {

    $options = get_option( 'tresnic_theme_social_options' );

    $url = '';
    if( isset( $options['instagram'] ) ) {
        $url = esc_url( $options['instagram'] );
    } // end if

    // Render the output
    echo '<input type="text" id="instagram" name="tresnic_theme_social_options[instagram]" value="' . $url . '" />';

} // end tresnic_googleplus_callback
//


function tresnic_yelp_callback() {

    $options = get_option( 'tresnic_theme_social_options' );

    $url = '';
    if( isset( $options['yelp'] ) ) {
        $url = esc_url( $options['yelp'] );
    } // end if

    // Render the output
    echo '<input type="text" id="yelp" name="tresnic_theme_social_options[yelp]" value="' . $url . '" />';

} // end tresnic_googleplus_callback


function fonts() {
	?>
	<div class="wrap">
		<h2>Fonts</h2>

		<form method="post" action="options.php">
			<?php wp_nonce_field( 'update-fonts' ); ?>
			<?php settings_fields( 'fonts' ); ?>
			<?php do_settings_sections( 'fonts' ); ?>
			<?php submit_button("Update Fonts"); ?>
		</form>
	</div>
<?php
}


function font_description() {
	echo 'Use the form below to change fonts of your theme.';
}


function tresnic_input_element_callback() {

    $options = get_option( 'tresnic_theme_input_examples' );

    // Render the output
    echo '<input type="text" id="input_example" name="tresnic_theme_input_examples[input_example]" value="' . $options['input_example'] . '" />';

} // end tresnic_input_element_callback


function tresnic_textarea_element_callback() {

    $options = get_option( 'tresnic_theme_input_examples' );

    // Render the output
    echo '<textarea id="textarea_example" name="tresnic_theme_input_examples[textarea_example]" rows="5" cols="50">' . $options['textarea_example'] . '</textarea>';

} // end tresnic_textarea_element_callback

function tresnic_analytics_callback() {

    $options = get_option( 'tresnic_theme_analytics' );

    // Render the output
    echo '<textarea id="textarea_example" name="tresnic_theme_input_examples[textarea_example]" rows="5" cols="50">' . $options['textarea_example'] . '</textarea>';

} // end tresnic_textarea_element_callback


function google_analytics_setting() {
	$options = get_option('tresnic_theme_analytics');
	echo "<textarea name='tresnic_theme_analytics[google_analytics]' type='textarea'> {$options['google_analytics']} </textarea>";
}

function google_webmaster_setting() {
	$options = get_option('tresnic_theme_analytics');
	echo '<input type="text" id="input_example" name="tresnic_theme_analytics[google_webmaster]" value="' . $options['google_webmaster'] . '" />';
}

function tresnic_checkbox_element_callback() {

    $options = get_option( 'tresnic_theme_input_examples' );

    $html = '<input type="checkbox" id="checkbox_example" name="tresnic_theme_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
    $html .= '&nbsp;';
    $html .= '<label for="checkbox_example">This is an example of a checkbox</label>';

    echo $html;

} // end tresnic_checkbox_element_callback

function tresnic_radio_element_callback() {

    $options = get_option( 'tresnic_theme_input_examples' );

    $html = '<input type="radio" id="radio_example_one" name="tresnic_theme_input_examples[radio_example]" value="1"' . checked( 1, $options['radio_example'], false ) . '/>';
    $html .= '&nbsp;';
    $html .= '<label for="radio_example_one">Option One</label>';
    $html .= '&nbsp;';
    $html .= '<input type="radio" id="radio_example_two" name="tresnic_theme_input_examples[radio_example]" value="2"' . checked( 2, $options['radio_example'], false ) . '/>';
    $html .= '&nbsp;';
    $html .= '<label for="radio_example_two">Option Two</label>';

    echo $html;

} // end tresnic_radio_element_callback

function tresnic_select_element_callback() {

    $options = get_option( 'tresnic_theme_input_examples' );

    $html = '<select id="time_options" name="tresnic_theme_input_examples[time_options]">';
    $html .= '<option value="default">' . __( 'Select a time option...', 'tresnic' ) . '</option>';
    $html .= '<option value="never"' . selected( $options['time_options'], 'never', false) . '>' . __( 'Never', 'tresnic' ) . '</option>';
    $html .= '<option value="sometimes"' . selected( $options['time_options'], 'sometimes', false) . '>' . __( 'Sometimes', 'tresnic' ) . '</option>';
    $html .= '<option value="always"' . selected( $options['time_options'], 'always', false) . '>' . __( 'Always', 'tresnic' ) . '</option>';	$html .= '</select>';

    echo $html;

} // end tresnic_radio_element_callback


/* ------------------------------------------------------------------------ *
 * Setting Callbacks
 * ------------------------------------------------------------------------ */

/**
 * Sanitization callback for the social options. Since each of the social options are text inputs,
 * this function loops through the incoming option and strips all tags and slashes from the value
 * before serializing it.
 *
 * @params	$input	The unsanitized collection of options.
 *
 * @returns			The collection of sanitized values.
 */
function tresnic_theme_sanitize_social_options( $input ) {

    // Define the array for the updated options
    $output = array();

    // Loop through each of the options sanitizing the data
    foreach( $input as $key => $val ) {

        if( isset ( $input[$key] ) ) {
            $output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
        } // end if

    } // end foreach

    // Return the new collection
    return apply_filters( 'tresnic_theme_sanitize_social_options', $output, $input );

} // end tresnic_theme_sanitize_social_options

function tresnic_theme_validate_input_examples( $input ) {

    // Create our array for storing the validated options
    $output = array();

    // Loop through each of the incoming options
    foreach( $input as $key => $value ) {

        // Check to see if the current option has a value. If so, process it.
        if( isset( $input[$key] ) ) {

            // Strip all HTML and PHP tags and properly handle quoted strings
            $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

        } // end if

    } // end foreach

    // Return the array processing any additional functions filtered by this action
    return apply_filters( 'tresnic_theme_validate_input_examples', $output, $input );

} // end tresnic_theme_validate_input_examples


?>