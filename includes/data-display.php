<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Saucal_Fabio_Mezzomo_Data_Display {

    public function __construct() {
        add_action( 'init', [ $this, 'handle_form_submission' ] );
    }

    public function display_user_data() {
        echo '<h3>' . __( 'Custom Data', 'saucal-fabio-mezzomo' ) . '</h3>';
        ?>
        <form method="post" action="">
            <label for="element_list">
                <?php echo __('Enter Elements (comma-separated):', 'saucal-fabio-mezzomo'); ?>
            </label>
            <input type="text" id="element_list" name="element_list" placeholder="element1, element2, element3" required>
            <button type="submit">Fetch Elements</button>
        </form>
        <?php
        if ( isset( $_POST['element_list'] ) ) {
            $this->display_fetched_data();
        }
    }

    private function display_fetched_data() {
        $element_list = sanitize_text_field( $_POST['element_list'] );
        $elements_array = explode( ',', $element_list );

        if ( function_exists( 'fetch_elements_from_api' ) ) {
            $api_data = fetch_elements_from_api( $elements_array );

            if ( $api_data ) {
                echo '<pre>' . esc_html( print_r( $api_data, true ) ) . '</pre>';
            } else {
                echo '<p>' . __( 'No data available.', 'saucal-fabio-mezzomo' ) . '</p>';
            }
        } else {
            echo '<p>' . __( 'Function fetch_elements_from_api not found.', 'saucal-fabio-mezzomo' ) . '</p>';
        }
    }

    public function handle_form_submission() {
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['element_list'] ) ) {
            $this->display_fetched_data();
        }
    }
}

new Saucal_Fabio_Mezzomo_Data_Display();
