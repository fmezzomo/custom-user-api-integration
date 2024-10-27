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

class Saucal_Fabio_Mezzomo_API_Integration {

    public function __construct() {
        // Define plugin version and constants
        define( 'SAUCAL_FABIO_MEZZOMO_VERSION', '1.0' );
        define( 'SAUCAL_FABIO_MEZZOMO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

        // Include necessary files
        require_once SAUCAL_FABIO_MEZZOMO_PLUGIN_DIR . 'includes/api-handler.php';
        require_once SAUCAL_FABIO_MEZZOMO_PLUGIN_DIR . 'includes/data-display.php';

        // Actions and filters
        add_filter( 'woocommerce_account_menu_items', [ $this, 'add_account_tab' ] );
        add_action( 'init', [ $this, 'register_endpoint' ] );
        add_action( 'woocommerce_account_custom-data-api_endpoint', [ $this, 'display_custom_data' ] );

        // Activation and deactivation Hooks
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
    }

    // Register WooCommerce account tab and endpoint
    public function add_account_tab( $items ) {
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

    public function register_endpoint() {
        add_rewrite_endpoint( 'custom-data-api', EP_ROOT | EP_PAGES );
    }

    public function activate() {
        $this->register_endpoint();
        flush_rewrite_rules();
    }

    public function deactivate() {
        flush_rewrite_rules();
    }

    public function display_custom_data() {
        saucal_fabio_mezzomo_display_user_data();
    }
}

new Saucal_Fabio_Mezzomo_API_Integration();