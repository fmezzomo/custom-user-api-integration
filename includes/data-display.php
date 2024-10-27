<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function saucal_fabio_mezzomo_display_user_data() {
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
    if ( isset($_POST['element_list']) ) {
        $element_list = sanitize_text_field($_POST['element_list']);
        $elements_array = explode( ',', $element_list );

        if ( function_exists('fetch_elements_from_api') ) {
            fetch_elements_from_api($elements_array);
        } else {
            echo "<p>Function fetch_elements_from_api not found.</p>";
        }
    }
}