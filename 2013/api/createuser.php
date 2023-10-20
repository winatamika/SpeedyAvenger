<?php

/*
 * param
 * $id integer
 * return json encode
 * 
 */

define('WP_USE_THEMES', false);
/** Loads the WordPress Environment and Template */
require('../wp-blog-header.php');
include_once( get_template_directory() . '/includes/loader.php' );
//include_once( 'function.php' );

for($i=1;$i<=150;$i++){

	$username = 'speedyavenger'.str_pad($i, 3, "0", STR_PAD_LEFT);
	$user_id = wp_create_user( $username, 'sa12345', $username.'@speedyavengers.com' );
	update_usermeta($user_id, 'tipe_user', "pra-avengers");

	echo "Username : ". $username."<br />";
	echo "Password : sa12345<br />";
	echo "<br />";


}

//$user_id = username_exists( $user_name );
//if ( !$user_id and email_exists($user_email) == false ) {
	//$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
	//$user_id = wp_create_user( $user_name, $random_password, $user_email );
//} else {
	//$random_password = __('User already exists.  Password inherited.');
//}

?>