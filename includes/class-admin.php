<?php

defined( 'ABSPATH' ) or die( 'Keep Quit' );

/**
 * 
 */
class CTLHZ_Admin{

	protected static $_instance = null;


    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
	
	// Construtct [Initial Function]
	public function __construct(){
		// Firing Hooks
		$this->hooks();
	}

	/**
	 * Hooks of the plugin
	 */
	public function hooks(){
		// Settings Page
		add_action('admin_menu', array( $this, 'setting_page' ) );
		// Enqueue Scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_srcipts' ) );
		// Create link [Ajax Call]
		add_action( 'wp_ajax_ctl_create_link', array( $this, 'create_link' ) );
		// Redirect to Dashboard
		add_action( 'template_redirect', array( $this, 'redirect_to_dashboard' ) );
		// Settings page link on plugin listing page
		add_filter( 'plugin_action_links_'. plugin_basename( CTLAZ_TEMP_LOGIN_FILE ), array( $this, 'login_settings_link' ) );
		// Disallow Password Reset for Temp Users
		add_filter( 'allow_password_reset', array( $this, 'disallow_password_reset' ), 10, 2 );
		// Disallow direct login access for Temp Users
		add_filter( 'wp_authenticate_user', array( $this, 'disallow_temporary_user_login' ) );
		// Set redirect before the plugin render the plugin settings page
		add_action( 'admin_init', array( $this,'set_header_redirect' ) );
	}

	/**
	 * Settings page
	 */
	public function setting_page(){
		add_submenu_page(
			'users.php',
			'Temporary Login',
			'Temporary Login',
			'manage_options',
			'create-temporary-login',
			array( $this, 'create_temporary_login' )
		);
	}

	/**
	 * Enqueue Scripts
	 */
	public function enqueue_srcipts(){
		wp_enqueue_style( 'ctl-admin', plugins_url( '/admin/css/admin.css', CTLAZ_TEMP_LOGIN_FILE ), array(), CTLAZ_TEMP_LOGIN_VERSION, 'all' );
		wp_enqueue_script( 'ctl-admin',  plugins_url( '/admin/js/admin.js', CTLAZ_TEMP_LOGIN_FILE ), array('jquery'), CTLAZ_TEMP_LOGIN_VERSION, true );
		wp_localize_script( 'ctl-admin', 'ctl_admin_ajax_object', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'ctl_nonce_field' => wp_create_nonce( 'ctl-create-link' )
		) );
	}

	
	/**
	 * Sets the header redirect.
	 */
	public function set_header_redirect(){
		// If found a user_id as a get delete the user
		if ( isset($_GET['ctl_delete_link_nonce']) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['ctl_delete_link_nonce'] ) ), 'ctl_delete_link') ){
			$delete_user = wp_delete_user( sanitize_text_field( $_GET['user_id'] ) );
			if( $delete_user ){
				wp_safe_redirect( esc_url( admin_url('users.php?page=create-temporary-login') ) );
			}
		}

		// If found a user_id as a extend link for the user
		if ( isset($_GET['ctl_extend_link_nonce']) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['ctl_extend_link_nonce'] ) ), 'ctl_extend_link') ){
			$extend_link = ctlaz_create_temporary_login()->get_option()->extend_expiration( sanitize_text_field( $_GET['user_id'] ) );
			if( $extend_link ){
				wp_safe_redirect( esc_url( admin_url('users.php?page=create-temporary-login') ) );
			}
		}
	}

	/**
	 * Create Temporary Login Interface
	 */
	public function create_temporary_login(){

		/**
		 * If current user is a temporary user and 
		 * 
		 * want to access the `Plugin Settings` page using the link
		 * 
		 */

		if( is_user_logged_in() && 
			ctlaz_create_temporary_login()->get_option()->is_temporary_user( get_current_user_id() ) 
		){
			/**
			 * Redirect the user to the `Dashboard > index.php`
			 */
			wp_safe_redirect( admin_url() );
		}


		echo "<h1>".esc_html__( 'WP Bifröst - Settings (Instant Passwordless Temporary Login Links)', 'create-temporary-login' )."</h1>";
		$other_attributes = array( 'tabindex' => '1' );
		submit_button( __( 'Generate a link', 'create-temporary-login' ), 'secondary ctl_generate_link', '', true, $other_attributes );

		//Getting only ctl users
		$ctl_users = get_users();

		// Initializing links
		$links = "<ul class='ctl_tokens'>";

		foreach ($ctl_users as $key => $user) {
			// If the user has a ctl token then create links otherwise skip
			if( get_user_meta( $user->ID, 'ctl_token', true ) ){

				$links .= sprintf(
					'<li>
						<a class="ctl_token" data-url="%1$s" data-instruction="%10$s">
							<span class="dashicons dashicons-admin-links"></span> 
							<span class="ctl_link">%1$s</span>
							<span class="ctl-tip ctl-tip-hidden">%4$s</span>
						</a> 
						<div>
							<p class="ctl-expiration"><small class="%8$s">%5$s</small></p>
							<p class="ctl-expiration-extend %9$s">
								<a title="%6$s" class="ctl_extend_link" href="%7$s">
									<span class="dashicons dashicons-image-rotate"></span>
									%6$s
								</a>
							</p>
						</div>
						<p class="ctl-delete">
							<a title="%3$s" class="ctl_delete_link" href="%2$s">
								<span class="dashicons dashicons-trash"></span>
							</a>
						</p>
					</li>',
					// 1. Token generated link to copy it to clipboard
					esc_url( site_url('?ctl_token=') . get_user_meta( $user->ID, 'ctl_token', true ) ),
					// 2. Link of delete the link
					esc_url( wp_nonce_url( admin_url("users.php?page=create-temporary-login&user_id={$user->ID}"), 'ctl_delete_link', 'ctl_delete_link_nonce' ) ),
					// 3. Delete text
					esc_html__( 'Delete', 'create-temporary-login' ),
					// 4. Copied text after clicking on link
					esc_html__( 'Copied', 'create-temporary-login' ),
					// 5. Human readable time to show how many days are remaining
					ctlaz_create_temporary_login()->get_option()->get_human_readable_link_duration( $user->ID ),
					// 6. Text of the Extend Button
					esc_html__( 'Extend 3 days', 'create-temporary-login' ),
					// 7. Link of extend time for the link
					esc_url( wp_nonce_url( admin_url("users.php?page=create-temporary-login&user_id={$user->ID}"), 'ctl_extend_link', 'ctl_extend_link_nonce' ) ),
					// 8. Add background color to red if link is expired
					ctlaz_create_temporary_login()->get_option()->is_user_expired( $user->ID ) ? 'ctl-danger' : '',
					// 9. Hide extend button if not expired
					// !ctlaz_create_temporary_login()->get_option()->is_user_expired( $user->ID ) ? 'ctl-display-none' : '',
					'',
					// 10. Tooltip text
					esc_html__( 'Click to Copy!', 'create-temporary-login' )

				);
			}
		}
		$links .= "</ul>";

		echo '<div class="ctl-area"><div class="ctl-spinner"><span class="ctl-animate dashicons dashicons-update"></span></div>'.wp_kses_post( $links ).'</div>';
	}

	
	/**
	 * Creates a link.
	 */
	public function create_link(){

		if ( isset( $_POST['create_user'] ) 
			&& $_POST['create_user'] === "yes" 
		) {

			check_ajax_referer( 'ctl-create-link', 'ctl_security' );
		
			$uniqid = bin2hex( random_bytes(16) );
			$data = array(
				'user_login'           => sanitize_text_field( 'ctl_user_'.$uniqid ), // the user's login username.
				'user_pass'            => sanitize_text_field( 'ctl_password_'.$uniqid ), // not necessary to hash password ( The plain-text user password ).
				'show_admin_bar_front' => true, // display the Admin Bar for the user 'true' or 'false',
				'role'                 => 'administrator',
				'meta_input'           => array(
					'ctl_token' => sanitize_text_field( $uniqid ),
					'ctl_user' => sanitize_text_field( 'yes' ),
					'ctl_expiration' => ctlaz_create_temporary_login()->get_option()->get_max_expired_time()
				)
			);
			$user_id = wp_insert_user( $data );
			if ( ! is_wp_error( $user_id ) ) {
		
			    echo absint( $user_id );
				wp_die();
				
			}
			
		}

	}


	/**
	 * Redirect to dashboard
	 */
	public function redirect_to_dashboard(){

		$nonce = wp_create_nonce( 'ctl_login_user_nonce' );

		if( wp_verify_nonce( $nonce, 'ctl_login_user_nonce' ) && isset($_GET['ctl_token']) ) {

			$user = get_user_by( 'login', sanitize_text_field( "ctl_user_".sanitize_key( $_GET['ctl_token'] ) ) );

			if ( 
				$user 
				&& wp_check_password( sanitize_text_field( "ctl_password_".sanitize_key( $_GET['ctl_token'] ) ), $user->data->user_pass, $user->ID) 
				&& !ctlaz_create_temporary_login()->get_option()->is_user_expired( $user->ID )
			) {
			    wp_set_current_user($user->ID, $user->user_login);
			    wp_set_auth_cookie($user->ID);
			    do_action('wp_login', $user->user_login, $user);
			    wp_safe_redirect( admin_url() );
			    exit;
			}

			wp_safe_redirect( home_url() );
		   	exit;
		}

	}

	
	/**
	 * Adding settings menu to the plugin list page
	 *
	 * @param      array  $links  The links
	 *
	 * @return     array  ( Array of the link to display in plugin list page under the plugin name )
	 */
	public function login_settings_link($links) { 
	    // Build and escape the URL.
	    $url = esc_url( add_query_arg(
	        'page',
	        'create-temporary-login',
	        get_admin_url() . 'users.php'
	    ) );
	    // Create the link.
	    $settings_link = "<a href='$url'>" . __( 'Create Temporary Login', 'create-temporary-login' ) . '</a>';
	    
	    // Adds the link to the begining of the array.
	    array_unshift( $links, $settings_link );

	    return $links; 
	}

	
	/**
	 * Disallow the user to reset password after loggedout
	 *
	 * @param      bool    	$allow    The allow
	 * @param      int  	$user_ID  The user id
	 *
	 * @return     bool    	( Checking whether a temporary user admin or main admin )
	 */
	public function disallow_password_reset( $allow, $user_ID ){
		if ( ! empty( $user_ID ) && ctlaz_create_temporary_login()->get_option()->is_temporary_user( $user_ID ) ) {
			$allow = false;
		}

		return $allow;
	}

	
	/**
	 * Disallow Temporary Users to direct login to the site
	 *
	 * @param      object   The user
	 *
	 * @return     void     ( Sending an error to display for direct login attempt by temporary user )
	 */
	public function disallow_temporary_user_login( $user ) {
		if ( $user instanceof \WP_User && ctlaz_create_temporary_login()->get_option()->is_temporary_user( $user->ID ) ) {
			$user = new \WP_Error(
				'invalid_username',
				__( '<strong>Error:</strong> The username is not registered on this site. If you are unsure of your username, try your email address instead.', 'create-temporary-login' )
			);
		}

		return $user;
	}
}