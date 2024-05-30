<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// Get all users
$ctl_users = get_users();

foreach ($ctl_users as $key => $user) {
	//Getting only ctl users
	if( get_user_meta( $user->ID, 'ctl_user', true ) ){
		wp_delete_user( sanitize_text_field( $user->ID ) );
	}
}
 