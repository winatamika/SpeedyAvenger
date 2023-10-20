<?php
/**
 * @package single-user-login
 * @mick
 * @version 1.0
 */
/*
Plugin Name: avoid-multi-login-checker
Plugin URI: http://www.baliorange.net
Description: avoid multi-login
Version: 1.0
Author URI: http://www.baliorange.net
*/
 

if( !function_exists('single_user_login_install')){
	function single_user_login_install(){
			global $wpdb;
			$users  	= $wpdb->users ; 
			$sql = "ALTER TABLE  `".$users."` ADD  `uni_hash` VARCHAR( 80 ) NOT NULL"	;
			$sql2 = 'ALTER TABLE`'.$users."` ADD `last_update` datetime";
			$wpdb->get_results($sql);
			$wpdb->get_results($sql2);
			
	}	
}


if( !function_exists('single_user_login_uninstall')){
	function single_user_login_uninstall(){
			global $wpdb;
			$users  	= $wpdb->users ; 
			$sql = "ALTER TABLE  `".$users."` DROP  `uni_hash` "	;
			$sql2 = 'ALTER TABLE`'.$users."` DROP `last_update` ";
			$wpdb->get_results($sql);
			$wpdb->get_results($sql2);
			
	}	
}
if( !function_exists('single_user_login_uid_create')){
	function single_user_login_uid_create($ID){
			global $wpdb;
			define("LOGIN_URL", SITE_URL . "/login/");
			$users  	= $wpdb->users ;
	
			$last_update = date('Y-m-d H:i:s', time());
			
					/*global $current_user;
					get_currentuserinfo();
					$ID = $current_user->data->user_login;*/
			
			$sql = "SELECT  uni_hash FROM  `".$users."`  WHERE user_login ='".$ID."'";
		
		$getinfo = $wpdb->get_results($sql); 
		
		$logout_url = wp_logout_url( home_url() );
		
		$user_uni_uid = $_COOKIE['user_uni_uid'];
		
		if( ($getinfo[0]->uni_hash == '') && ($user_uni_id == '')  ){
			
			$randUID = md5(microtime().$_SERVER['REMOTE_ADD'] );
			$sql = "UPDATE  `".$users."` set  `uni_hash`='".$randUID."' , `last_update`='".$last_update."' WHERE user_login='".$ID."'";
			$wpdb->get_results($sql);
			setcookie("user_uni_uid", $randUID);  
			}
		else 
			{
			wp_clearcookie();
			do_action('wp_logout');
			nocache_headers();
			$redirect_to = home_url();
			wp_redirect($redirect_to);
			$warning = 'sedang login';
			exit();
			}
			 
			
	}	
}
 
 
if( !function_exists('single_user_login_uid_check')){
	function single_user_login_uid_check(){
		global $wpdb;
		$users  	= $wpdb->users ;
		$user_uni_uid = $_COOKIE['user_uni_uid'];
	
		
		$sql = "SELECT  uni_hash FROM  `".$users."`  WHERE uni_hash='".$user_uni_uid."'"	;
		$getinfo = $wpdb->get_results($sql); 
		$logout_url = wp_logout_url( home_url() );
		if(
		($getinfo[0]->uni_hash != $user_uni_uid  )&&(  is_user_logged_in() ) 
		){
			wp_clearcookie();
			do_action('wp_logout');
			nocache_headers();
			$redirect_to = home_url();
			wp_redirect($redirect_to);
			$warning = 'sedang login';
			exit();
		} 

	}
}


if( !function_exists('single_user_logout')){
function single_user_logout(){
global $wpdb;
	$users  	= $wpdb->users ;
$user_uni_uid = $_COOKIE['user_uni_uid'];
		$sql = "SELECT  uni_hash FROM  `".$users."`  WHERE uni_hash='".$user_uni_uid."'"	;
		$getinfo = $wpdb->get_results($sql); 
	
		if($getinfo[0]->uni_hash == $user_uni_uid ) {
 global $current_user;
    get_currentuserinfo();
		$ID = $current_user->data->user_login;
$users  	= $wpdb->users ;
$empty = "";
$sql = "UPDATE  `".$users."` set  `uni_hash`='".$empty."' , `last_update`='".$empty."' WHERE user_login='".$ID."'"	;
			$wpdb->get_results($sql);
			}

}
}

if( !function_exists('clear_hash')){
function clear_hash(){
global $wpdb;
$users  	= $wpdb->users ;
 global $current_user;
    get_currentuserinfo();
		$ID = $current_user->data->user_login;
$users  	= $wpdb->users ;
$empty = "";
$sql = "UPDATE  `".$users."` set  `uni_hash`='".$empty."' WHERE user_login='".$ID."'"	;
}
}

register_activation_hook( __FILE__, 'single_user_login_install' );
add_action('wp_login','single_user_login_uid_create');
add_action('init','single_user_login_uid_check');
add_action('wp_logout','single_user_logout');
add_action('shutdown','clear_hash');
register_deactivation_hook( __FILE__, 'single_user_login_uninstall' );
?>