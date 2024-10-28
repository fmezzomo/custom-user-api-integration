<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Saucal_Fabio_Mezzomo_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'saucal_fabio_mezzomo_widget',
            __( 'Custom User Data Widget', 'saucal-fabio-mezzomo' ),
            [ 'description' => __( 'Displays custom user data', 'saucal-fabio-mezzomo' ) ]
        );
    }

    public function widget( $args, $instance ) {
        if ( array_key_exists( 'before_widget', $args ) ) {
            echo $args['before_widget'];
        }

        echo '<h3>' . __( 'Custom User Data', 'saucal-fabio-mezzomo' ) . '</h3>';

        $userID = get_current_user_id();
        $preferences = get_user_meta( $userID, 'saucal_fm_user_preferences', true );
        
        $apiHandler = new Saucal_Fabio_Mezzomo_API_Handler();
        $apiData = $apiHandler->fetch_elements( $preferences );

        if ( $apiData ) {
            
            if ( isset( $apiData['json']['elements'] ) && is_array( $apiData['json']['elements'] ) ) {
                foreach ( $apiData['json']['elements'] as $element ) {
                    echo '<p>' . esc_html( $element ) . '</p>';
                }
            } else {
                echo '<p>No elements found.</p>';
            }

        } else {
            echo '<p>' . __( 'No data available.', 'saucal-fabio-mezzomo' ) . '</p>';
        }

        if ( array_key_exists( 'after_widget', $args ) ) {
            echo $args['after_widget'];
        }
    }
}
