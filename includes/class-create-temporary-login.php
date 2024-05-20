<?php

defined( 'ABSPATH' ) or die( 'Keep Quit' );

/**
 * 
 */
class CTLAZ_Create_Temporary_Login{

	protected static $_instance = null;


    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /*
     * Construct of the Class.
     *
     */

    public function __construct(){

        $this->includes();
        $this->init();

    }

    /*
     * Includes files.
     *
     */

    public function includes() {
        require_once dirname( __FILE__ ) . '/class-option.php';
        require_once dirname( __FILE__ ) . '/class-admin.php';
    }

    /*
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public function init() {

        $this->get_option();
        $this->get_admin();
        $this->set_hooks();
    } 

    /**
     * Sets the hooks.
     */
    public function set_hooks(){
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ), 10 );
    }

    /**
     * Loads a textdomain.
     */
    public function load_textdomain() {
        load_plugin_textdomain( 'create-temporary-login', false, basename( dirname( CTLAZ_TEMP_LOGIN_FILE ) )."/languages" );
    }

    /**
     *
     * Option 
     *
     */

    public function get_option(){
        return CTLHZ_Option::instance();
    }

    /**
     *
     * Admin
     *
     */

    public function get_admin(){
        return CTLHZ_Admin::instance();
    }

}