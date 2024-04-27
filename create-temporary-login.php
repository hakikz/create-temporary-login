<?php
/*
Plugin Name: Create Temporary Login
Plugin URI: https://wordpress.org/plugins/create-temporary-login
Description: Create passwordless temporary login links to easily give access to your site's dashboard.
Version: 1.0.0
Author: Hakik Zaman
Author URI: https://profiles.wordpress.org/users/hakik	
Text Domain: create-temporary-login
Domain Path: /languages/
Requires at least: 4.0
Tested up to: 6.4
*/

defined( 'ABSPATH' ) || exit;

/**
 * Defining the constants
 */
if ( ! defined( 'CTL_VERSION' ) ) {
    define( 'CTL_VERSION', '1.0.0' );
}

if ( ! defined( 'CTL_PLUGIN_FILE' ) ) {
    define( 'CTL_PLUGIN_FILE', __FILE__ );
}

/**
 * Include the main class.
 */
if ( ! class_exists( 'Create_Temporary_Login', false ) ) {
    require_once dirname( CTL_PLUGIN_FILE ) . '/includes/class-create-temporary-login.php';
}


/**
 * Creates a temporary login.
 *
 * @return     <instance>  ( the core class )
 */
function create_temporary_login() {

    return Create_Temporary_Login::instance();
}

add_action( 'plugins_loaded', 'create_temporary_login' );
