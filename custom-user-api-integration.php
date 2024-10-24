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
            $new_items['custom-data-api'] = __( 'Custom Data', 'saucal-fabio-mezzomo' );
        }
    }

    return $new_items;
}
add_filter( 'woocommerce_account_menu_items', 'saucal_fabio_mezzomo_add_account_tab' );

function saucal_fabio_mezzomo_register_endpoint() {
    add_rewrite_endpoint( 'custom-data-api', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'saucal_fabio_mezzomo_register_endpoint' );

function saucal_fabio_mezzomo_activate() {
    saucal_fabio_mezzomo_register_endpoint();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'saucal_fabio_mezzomo_activate' );

// To make sure that the rewrite rules will be clean when deactivate
function saucal_fabio_mezzomo_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'saucal_fabio_mezzomo_deactivate' );

// Endpoint content
function saucal_fabio_mezzomo_custom_data_content() {
    echo '<h3>' . __( 'Custom Data', 'saucal-fabio-mezzomo' ) . '</h3>';
}
add_action( 'woocommerce_account_custom-data-api_endpoint', 'saucal_fabio_mezzomo_custom_data_content' );