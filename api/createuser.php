<?php

/*
 * param
 * $id integer
 * return json encode
 * 
 */

define('WP_USE_THEMES', false);
/** Loads the WordPress Environment and Template */
require("../wp-load.php");
//include_once( get_template_directory() . '/includes/loader.php' );
//include_once( 'function.php' );

for($i=2;$i<61;$i++){

	$username = 'witel'.str_pad($i, 2, "0", STR_PAD_LEFT);
	$random_password = wp_generate_password( 9, false );
	$user_id = wp_create_user( $username, $random_password, $username.'@speedyavengers.com' );
	update_usermeta($user_id, 'tipe_user', "webadmin");
	update_usermeta($user_id, 'av_witel_id', $i);

	echo "Username : ". $username."<br />";
	echo "Password : ".$random_password."<br />";
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