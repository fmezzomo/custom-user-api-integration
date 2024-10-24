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
