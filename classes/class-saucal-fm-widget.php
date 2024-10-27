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
        echo $args['before_widget'];
        echo '<h3>' . __( 'Custom User Data', 'saucal-fabio-mezzomo' ) . '</h3>';
        
        $data_display = new Saucal_Fabio_Mezzomo_Data_Display();
        $data_display->display_user_data();

        echo $args['after_widget'];
    }
}
