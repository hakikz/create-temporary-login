<?php

defined( 'ABSPATH' ) or die( 'Keep Quit' );

/**
 * 
 */
class CTLHZ_Option{

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
		$this->set_hooks();
	}

	/**
	 * Sets the hooks.
	 */
	public function set_hooks(){
		add_action( 'wp_dashboard_setup', array( $this, 'set_temporary_logged_in_user_permission' ), 10 );
	}

	/**
	 * Determines whether the specified user id is temporary user.
	 *
	 * @param      int  $user_ID  The user id
	 *
	 * @return     bool    True if the specified user id is temporary user, False otherwise.
	 */
	public function is_temporary_user( $user_ID ) : bool {
		return (bool) get_user_meta( $user_ID, 'ctl_user', true );
	}

	/**
	 * Gets the maximum expired time.
	 *
	 * @return     int   The maximum expired time.
	 */
	public function get_max_expired_time(): int {
		return current_time( 'timestamp' ) + WEEK_IN_SECONDS;
	}

	/**
	 * Determines whether the specified user id is user expired.
	 *
	 * @param      int  $user_ID  The user id
	 *
	 * @return     bool    True if the specified user id is user expired, False otherwise.
	 */
	public function is_user_expired( $user_ID ): bool {
		$expiration = $this->get_expiration( $user_ID );

		if ( empty( $expiration ) ) {
			return true;
		}

		return current_time( 'timestamp' ) > $expiration;
	}

	/**
	 * Gets the expiration.
	 *
	 * @param      int  $user_ID  The user id
	 *
	 * @return     int | bool  Meta ID if the key didn’t exist, true on successful update, false on failure or if the value passed to the function is the same as the one that is already in the database.
	 */
	public function get_expiration( $user_ID ) {
		return get_user_meta( $user_ID, 'ctl_expiration', true );
	}

	
	
	/**
	 * Gets the human readable link duration.
	 *
	 * @param      int  $user_ID  The user id
	 *
	 * @return     mixed  The human readable link duration.
	 */
	public function get_human_readable_link_duration( $user_ID ){
		if( $this->is_user_expired( $user_ID ) ){
			return esc_html__( 'Expired', 'create-temporary-login' );
		}
		return sprintf( 
			/* translators: %s: How many days remaining */
			 esc_html__( 'Will be expired after:&nbsp;%s', 'create-temporary-login' ),
			 wp_kses_post( human_time_diff( $this->get_expiration( $user_ID ), current_time('U') ) )
		 );
	}

	/**
	 * Extends the expiration.
	 *
	 * @param      <int>  $user_ID  The user id
	 *
	 * @return     int | bool    Meta ID if the key didn’t exist, true on successful update, false on failure or if the value passed to the function is the same as the one that is already in the database.
	 */
	public function extend_expiration( $user_ID ) {
		$expiration = $this->get_expiration( $user_ID );

		if ( empty( $expiration ) ) {
			return false;
		}

		if ( $this->is_user_expired( $user_ID ) ) {
			$expiration = current_time( 'timestamp' );
		}

		$expiration += 3 * DAY_IN_SECONDS;

		$expiration = min( $expiration, $this->get_max_expired_time() );

		return update_user_meta( $user_ID, 'ctl_expiration', $expiration );
	}

	
	/**
	 * Sets the temporary logged in user permission.
	 */
	public function set_temporary_logged_in_user_permission(){

		if( $this->is_temporary_user( get_current_user_id() ) ){

			// Remove a capability from a specific user.
			$user = new WP_User( get_current_user_id() );
			/**
			 * @note `list_users` to revoke entire access of the user menus
			 * 
			 * To print the available capabilities for this current user- `print_r($user->get_role_caps());`
			 */
			$user->add_cap( 'create_users', false );
			$user->add_cap( 'list_users', false );
			$user->add_cap( 'delete_users', false );
			/**
			 * @note for future use
			 * Remove the User menu for temporary users
			 * remove_menu_page( 'users.php' );
			 */
			remove_menu_page( 'users.php' );
			remove_menu_page( 'profile.php' );
		}
		
		

	}

}