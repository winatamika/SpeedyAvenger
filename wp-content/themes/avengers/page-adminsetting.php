<?php
/* Template Name: Pages Admin Setting */ 

get_header();
global $current_user, $wpdb;
//$tipe_user = esc_attr(get_the_author_meta('tipe_user', $current_user->ID));
//$admin_witelid = esc_attr(get_the_author_meta('av_witel_id', $current_user->ID));
//echo $admin_witelid;

if ( user_can($current_user, "administrator") ){

	if(isset($_POST['wp-submit'])){

		$passmark = esc_attr($_POST["passmark"]);
		$pengumuman = esc_attr($_POST["pengumuman"]);
		update_option("saOptions", serialize(array('passmark'=>$passmark, 'pengumuman'=>$pengumuman)) );
		$info = "Setting telah disimpan.";
		
	}
	

	$saOptions = sa_getOptions();
?>
<div id="content"> 
    <div class="clear1"></div>
    <div class="entry">
    	<div id="post">

<form name="setting" id="setting" action="" method="post">
	<?php
	if(isset($info))
		echo "<p>".$info."</p>";
	?>
	<p>

	</p>
	<p class="group">
		<div class="form1"><label for="passmark">Pass Mark</label></div>
		<input type="text" name="passmark" id="passmark"  value="<?php echo $saOptions['passmark'];?>" size="20" />
	</p>

	<p class="group">
		<div class="form1"><label for="pengumuman">Pengumuman</label></div>
		<input type="text" name="pengumuman" id="pengumuman"  value="<?php echo $saOptions['pengumuman'];?>" size="60" />
	</p>

	<p class="login-submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button-primary3" value="Simpan" /> 
	</p>
</form> 

<?php
}else{
	echo "<p>Sorry yo can not access this page!</p>";
}
?>
    	</div>
    </div>
</div>
<?php
get_footer();
?>