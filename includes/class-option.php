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
		// $this->hooks();
	}

	public function is_temporary_user( $user_ID ) : bool {
		return (bool) get_user_meta( $user_ID, 'ctl_user', true );
	}

	public function get_max_expired_time(): int {
		return current_time( 'timestamp' ) + WEEK_IN_SECONDS;
	}

	public function is_user_expired( $user_ID ): bool {
		$expiration = $this->get_expiration( $user_ID );

		if ( empty( $expiration ) ) {
			return true;
		}

		return current_time( 'timestamp' ) > $expiration;
	}

	public function get_expiration( $user_ID ) {
		return get_user_meta( $user_ID, 'ctl_expiration', true );
	}

	public function human_readable_duration( $user_ID ){
		if( $this->is_user_expired( $user_ID ) ){
			return esc_html__( 'Expired', 'create-temporary-login' );
		}
		return sprintf( 
			/* translators: %s: How many days remaining */
			 esc_html__( 'Will be expired after:&nbsp;%s', 'plugin-slug' ),
			 wp_kses_post( human_time_diff( $this->get_expiration( $user_ID ), current_time('U') ) )
		 );
	}

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

}