<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Saucal_Fabio_Mezzomo_Data_Display {

    public function __construct() {
        add_shortcode( 'saucal_user_data', [ $this, 'display_user_data' ] );
    }

    public function display_user_data() {
        echo '<h3>' . __( 'Custom Data', 'saucal-fabio-mezzomo' ) . '</h3>';
        ?>
        <form method="post" action="">
            <?php wp_nonce_field( 'saucal_fetch_elements', 'saucal_nonce' ); ?>
            <label for="element_list">
                <?php echo __('Enter Elements (comma-separated):', 'saucal-fabio-mezzomo'); ?>
            </label>
            <input type="text" id="element_list" name="element_list" placeholder="element1, element2, element3" required>
            <button type="submit">Fetch Elements</button>
        </form>
        <?php

        if ( $this->is_form_submitted() ) {
            $this->handle_form_submission();
        }
    }

    private function is_form_submitted() {
        return (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset( $_POST['element_list'] ) &&
            isset( $_POST['saucal_nonce'] ) &&
            wp_verify_nonce( $_POST['saucal_nonce'], 'saucal_fetch_elements' )
        );
    }

    private function handle_form_submission() {
        $element_list = sanitize_text_field( $_POST['element_list'] );
        $elements_array = explode( ',', $element_list );

        $api_handler = new Saucal_Fabio_Mezzomo_API_Handler();
        $api_data = $api_handler->fetch_elements( $elements_array );

        if ( $api_data ) {
            echo '<pre>' . esc_html( print_r( $api_data, true ) ) . '</pre>';
        } else {
            echo '<p>' . __( 'No data available.', 'saucal-fabio-mezzomo' ) . '</p>';
        }
    }
}

new Saucal_Fabio_Mezzomo_Data_Display();
