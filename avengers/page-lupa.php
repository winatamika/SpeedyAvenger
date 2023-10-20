<?php
/* Template Name:  Pages Template Lupa Password */
?>
<?php 
get_header(); 
global $current_user, $wpdb;
$current_user = wp_get_current_user();
if ( 0 < $current_user->ID ) {
	$failed = "Maaf anda tidak dapat mengakses halaman ini.";
}

?>
<style type="text/css">
<!--
.form1 {float:left; width:200px}

-->
</style>

<div id="content"> 
  <?php //include(TEMPLATEPATH."/scroll.php");?>
  <div class="clear1"></div>
  <div class="entry">	 
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="post" id="post-<?php the_ID(); ?>">
      <h2 class="title"><?php the_title(); ?></h2>

      <?php 
      if(isset($_POST)){

      	if(is_email($_POST['email']) == false){
      		echo "<p class='warning'>Maaf, email tidak valid.</p>";
      	}elseif( email_exists( sanitize_email($_POST['email']) ) == false ) {
      		echo "<p class='warning'>Maaf, email tidak ditemukan.</p>";
      	}else{

      		$user_email = sanitize_email($_POST['email']);
      		//$user_id = username_exists( $user_email );
      		$user_name = $user_email;
			//echo $user_id;
      		if ( email_exists($user_email) ) {
      			$random_password = wp_generate_password( 6, false );
				//$user_id = wp_create_user( $user_name, $random_password, $user_email );
				$user = get_user_by( 'email', $user_email );
				//exit();
      			wp_set_password( $random_password, $user->ID );

      			$regsuccess = true;
      			$headers = 'From: speedyavengers <info@speedyavengers.com>' . "\r\n";
      			$headers .= "MIME-Version: 1.0\r\n";
      			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				//add_filter( 'wp_mail_content_type', 'set_html_content_type' );
      			wp_mail( $user_email, 'Informasi Akun speedyavengers.com', 
      				sprintf('
      					Akun anda adalah
      					Username: %s
      					Password: %s
      					Silahkan login ke www.speedyavengers.com ', $user_name, $random_password, $headers)
      				);

      		} else {
      			echo "<p class='warning'>Maaf, email tidak ditemukan.</p>";
      		}
      	}

      }
    ?> 

<?php

if(isset($failed)){
	?>
	<p>
	    <?php echo  $failed; ?>
	    <a href="<?php echo SITE_URL;?>">Klik disini untuk kembali ke Website</a>
	  </p>
	  <?php
}else{
	if(isset($regsuccess)){
	?>
	  <p>
	    Password baru telah terkirim. Silahkan cek email untuk informasi akun anda. 
	    <a href="<?php echo SITE_URL;?>">Klik disini untuk kembali ke Website</a>
	  </p>

	<?php
	}else{
	?>

	  <form name="loginform" id="loginform" action="" method="post">
	  	<p class="login-email">
	  		<div class="form1"><label for="email">Email </label></div>
	  		<input name="email" id="email" type="text" >
	  	</p>
	  	<p class="login-submit">
	  	<input type="submit" name="wp-submit" id="wp-submit" class="button-primary3" value="Kirim Password" /> 
	  		<input type="hidden" name="redirect_to" value="http://www.speedyavengers.com" />
	  	</p>
	  </form>

	<?php
	}
}
?>
</div>





<?php endwhile;
endif;
?>
<div class="clear"></div>
<?php //edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
</div>

<div class="clear"></div>
</div>
<?php get_footer(); ?>