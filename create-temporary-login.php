<?php
/*
Plugin Name:        WP Bifröst - Instant Passwordless Temporary Login Links
Plugin URI:         https://wordpress.org/plugins/create-temporary-login
Description:        Create passwordless temporary login links to easily give access to your site's dashboard.
Version:            1.0.5
Author:             Hakik Zaman
Author URI:         https://profiles.wordpress.org/users/hakik	
License:            GPL v2 or later 
License URI:        https://www.gnu.org/licenses/gpl-2.0.html 
Text Domain:        create-temporary-login
Domain Path:        /languages
Requires at least:  5.2
Tested up to:       6.6
*/

defined( 'ABSPATH' ) || exit;

/**
 * Defining the constants
 */
if ( ! defined( 'CTLAZ_TEMP_LOGIN_VERSION' ) ) {
    define( 'CTLAZ_TEMP_LOGIN_VERSION', '1.0.5' );
}

if ( ! defined( 'CTLAZ_TEMP_LOGIN_FILE' ) ) {
    define( 'CTLAZ_TEMP_LOGIN_FILE', __FILE__ );
}

/**
 * Include the main class.
 */
if ( ! class_exists( 'CTLAZ_Create_Temporary_Login', false ) ) {
    require_once dirname( CTLAZ_TEMP_LOGIN_FILE ) . '/includes/class-create-temporary-login.php';
}


/**
 * Creates a temporary login.
 *
 * @return     <instance>  ( the core class )
 */
function ctlaz_create_temporary_login() {

    return CTLAZ_Create_Temporary_Login::instance();
}

add_action( 'plugins_loaded', 'ctlaz_create_temporary_login' );
