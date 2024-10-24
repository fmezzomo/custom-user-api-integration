<?php
/*
Plugin Name: Custom User API Integration
Description: Plugin to integrate external API based on user preferences and display data in WooCommerce account and widget.
Version: 1.0
Author: Fábio Mezzomo
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin version and constants
define( 'SAUCAL_FABIO_MEZZOMO_VERSION', '1.0' );
define( 'SAUCAL_FABIO_MEZZOMO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Register WooCommerce account tab and endpoint
function saucal_fabio_mezzomo_add_account_tab( $items ) {
    $new_items = array();
    foreach ( $items as $key => $value ) {
        // Add the new menu after Dashboard
        $new_items[ $key ] = $value;

        if ( $key === 'dashboard' ) {
            $new_items['custom-data'] = __( 'Custom Data', 'saucal-fabio-mezzomo' );
        }
    }

    return $new_items;
}
add_filter( 'woocommerce_account_menu_items', 'saucal_fabio_mezzomo_add_account_tab' );
