<?php
/**
 * schema-address.php
 *
 * Plugin Name: Schema_Address_Widget
 * Plugin URI: http://www.tresnicmedia.com
 * Description: A widget that displays your company information with proper Schema Format.
 * Version: 1.0
 * Author: Andrew Atieh
 * Author URI: http://andrewatieh.com
 */

if ( ! defined( 'ABSPATH' ) ) exit; //exit if accessed directly


class Schema_Address_Widget extends WP_Widget {

    /**
     * Specifies the widget name, description, class name and instatiates it
     */
    public function __construct() {
        parent::__construct(
            'schema-address',
            __( 'Schema Address', 'alpha' ),
            array(
                'classname'   => 'schema-address',
                'description' => __( 'A widget that displays your company information with proper Schema Format.', 'alpha' )
            )
        );
    }

    /**
     * Generates the back-end layout for the widget
     */
    public function form( $instance ) {
        // Default widget settings
        $defaults = array(
            'street_address'   => '',
            'city'             => '',
            'state'            => '',
            'zip'              => '',
            'phone'              => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        // The widget content ?>

        <!-- Description -->
        <p>
            <label for="<?php echo $this->get_field_id( 'street_address' ); ?>"><?php _e( 'Street Address:', 'alpha' ); ?></label>
            <textarea cols="30" rows="3" class="widefat" id="<?php echo $this->get_field_id( 'street_address' ); ?>" name="<?php echo $this->get_field_name( 'street_address' ); ?>"><?php echo esc_textarea( $instance['street_address'] ); ?></textarea>
        </p>

        <!-- Monday-Friday -->
        <p>
            <label for="<?php echo $this->get_field_id( 'city' ); ?>"><?php _e( 'City:', 'alpha' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'city' ); ?>" name="<?php echo $this->get_field_name( 'city' ); ?>" value="<?php echo esc_attr( $instance['city'] ); ?>">
        </p>

        <!-- Saturday -->
        <p>
            <label for="<?php echo $this->get_field_id( 'state' ); ?>"><?php _e( 'State:', 'alpha' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'state' ); ?>" name="<?php echo $this->get_field_name( 'state' ); ?>" value="<?php echo esc_attr( $instance['state'] ); ?>">
        </p>

        <!-- Sunday -->
        <p>
            <label for="<?php echo $this->get_field_id( 'zip' ); ?>"><?php _e( 'Zip:', 'alpha' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'zip' ); ?>" name="<?php echo $this->get_field_name( 'zip' ); ?>" value="<?php echo esc_attr( $instance['zip'] ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone:', 'alpha' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo esc_attr( $instance['phone'] ); ?>">
        </p>

    <?php
    }


    /**
     * Processes the widget's values
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        // Update values
        $instance['street_address']      = strip_tags( stripslashes( $new_instance['street_address'] ) );
        $instance['city']                = strip_tags( stripslashes( $new_instance['city'] ) );
        $instance['state']               = strip_tags( stripslashes( $new_instance['state'] ) );
        $instance['zip']                 = strip_tags( stripslashes( $new_instance['zip'] ) );
        $instance['phone']               = strip_tags( stripslashes( $new_instance['phone'] ) );

        return $instance;
    }


    /**
     * Output the contents of the widget
     */
    public function widget( $args, $instance ) {
        // Extract the arguments
        extract( $args );

        $street_address      = $instance['street_address'];
        $city                = $instance['city'];
        $state               = $instance['state'];
        $zip                 = $instance['zip'];
        $phone               = $instance['phone'];

        // Display the markup before the widget (as defined in functions.php)
        echo $before_widget;

        echo '<div itemscope itemtype="http://schema.org/LocalBusiness">';

        echo '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';

        if ( $street_address ) {
            echo ' <span itemprop="streetAddress">' .  wpautop($street_address) . '</span>';
        }

        if ( $city ) {
            echo '<p>';
            echo '<span itemprop="addressLocality">' . $city . '</span>' . ', ';
        }

        if ( $state ) {
            echo '<span itemprop="addressRegion">' . $state . '</span>' . ' ';
        }

        if ( $zip ) {
            echo '<span itemprop="postalCode">' . $zip . '</span>';
            echo '</p>';
        }

        echo '</div>'; //end address itemprop

        if ( $phone ) {
            echo '<p>' . '<span itemprop="telephone">' . $phone . '</span>' . '</p>';
        }

        echo '</div>'; //end itemtype

        echo $after_widget;
    }
}



// Register the widget using an annonymous function
add_action( 'widgets_init', create_function( '', 'register_widget( "Schema_Address_Widget" );' ) );
?>