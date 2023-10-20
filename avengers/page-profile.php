<?php
/* Template Name:  Pages Update Profile */ 
global $current_user;
?>

<?php get_header(); ?>
<style type="text/css">
<!--
.form1 {float:left; width:200px}

-->
</style>
<div id="content"> 
<?php include(TEMPLATEPATH."/scroll.php");?>
<div class="clear1"></div>
<div class="entry">  
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div class="post" id="post-<?php the_ID(); ?>">
    <h2 class="title"><?php the_title(); ?></h2>

    <?php 

    if(isset($_POST)){ 

      if($_POST['first_name']=="" || $_POST['last_name']=="" || 
        $_POST['tempat_lahir']=="" || $_POST['tanggal_lahir']=="" || /*$_POST['tanggal']=="" || $_POST['tahun']=="" || */
        $_POST['no_ktp']=="" || $_POST['alamat_rumah']=="" ||
        $_POST['nomor_telepon_rumah']=="" || $_POST['nomor_telepon_hp']=="" || $_POST['email']==""){

        echo "<p class='warning'>Semua input harus diisikan.</p>";
    }elseif(is_email($_POST['email']) == false){
      echo "<p class='warning'>Maaf, email tidak valid.</p>";
          /*}elseif( email_exists( sanitize_email($_POST['email']) == false ) ) {
            echo "<p class='warning'>Maaf, email telah terdaftar.</p>";*/
          }else{

            /*
            $username_gen = str_replace(" ", "", sanitize_text_field($_POST['first_name']).sanitize_text_field($_POST['last_name']));
            $tgl_lahir = str_replace("-", "", sanitize_text_field($_POST['tanggal_lahir']));

            $user_name = strtoupper(substr($username_gen, 0, 8) . substr($tgl_lahir, -4));
            $user_id = username_exists( $user_name );

            while ( $user_id ) {
              $user_name = strtoupper(substr($username_gen, 0, 8) . rand(1000,9999) );
              $user_id = username_exists( $user_name );
            }
            
            $user_email = sanitize_email($_POST['email']);
            */

            //if ( !$user_id and email_exists($user_email) == false ) {
              //$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
              //$user_id = wp_create_user( $user_name, $random_password, $user_email );
            
            $user_id = $current_user->ID;

            wp_update_user( 
              array ( 'ID' => $user_id, 
                'first_name' => sanitize_text_field($_POST['first_name']), 
                'last_name' => sanitize_text_field($_POST['last_name']) 
                ) 
              );

            update_usermeta($user_id, 'av_witel_id', ($_POST['witel']));
            update_usermeta($user_id, 'av_datel_id', ($_POST['datel']));
            update_usermeta($user_id, 'av_no_ktp', sanitize_text_field($_POST['no_ktp']));
            update_usermeta($user_id, 'av_tempat_lahir', sanitize_text_field($_POST['tempat_lahir']));
            update_usermeta($user_id, 'av_tanggal_lahir', sanitize_text_field($_POST['tanggal_lahir']));
            update_usermeta($user_id, 'av_jenis_kelamin', sanitize_text_field($_POST['jenis_kelamin']));
            update_usermeta($user_id, 'av_alamat_rumah', sanitize_text_field($_POST['alamat_rumah']));
            update_usermeta($user_id, 'av_nomor_telepon_rumah', sanitize_text_field($_POST['nomor_telepon_rumah']));
            update_usermeta($user_id, 'av_nomor_telepon_hp', sanitize_text_field($_POST['nomor_telepon_hp']));

            update_usermeta($user_id, 'tipe_user', 'pra-avengers');

            $regsuccess = true;

            

              //wp_redirect(REG_SUCCESS_URL);
              //exit();

            //} //else {
              //$random_password = __('User already exists.  Password inherited.');
            //}
          }

        } 

        $args = array( 'taxonomy' => 'widatel', 'hide_empty'=>0, 'parent'=>0 );
        $witels = get_terms('widatel', $args);


        $witelid = get_the_author_meta('av_witel_id', $current_user->ID);
        $datelid = get_the_author_meta('av_datel_id', $current_user->ID);
        $witeldetail = get_term_by( 'id',  $witelid, 'widatel');
        $dateldetail = get_term_by( 'id',  $datelid, 'widatel');

        $args = array( 'taxonomy' => 'widatel', 'hide_empty'=>0, 'parent'=>0 );
        $witels = get_terms('widatel', $args);

        $args = array( 'taxonomy' => 'widatel', 'hide_empty'=>0, 'parent'=>$witelid );
        $datels = get_terms('widatel', $args);

        $tempat_lahir = get_the_author_meta('av_tempat_lahir', $current_user->ID);
        $tgl_lahir = get_the_author_meta('av_tanggal_lahir', $current_user->ID);
        $no_ktp = get_the_author_meta('av_no_ktp', $current_user->ID);
        $jenis_kelamin = get_the_author_meta('av_jenis_kelamin', $current_user->ID);
        $alamat_rumah = get_the_author_meta('av_alamat_rumah', $current_user->ID);
        $nomor_telepon_rumah = get_the_author_meta('av_nomor_telepon_rumah', $current_user->ID);
        $nomor_telepon_hp = get_the_author_meta('av_nomor_telepon_hp', $current_user->ID);



        ?> 

        <script type="text/javascript">
        jQuery(document).ready(function() {

          jQuery( "#tanggal_lahir" ).datepicker({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            maxDate: '-17Y',
            yearRange: "-60:+0",
          });

          jQuery("#witel").change(function(){
            var _selected = jQuery("#witel").val();
            jQuery.ajax({
              type: "POST",
              url: "<?php echo SITE_URL;?>/api/api.php",
              data: { method:'getDatel', parentID: _selected },
              dataType: "json",
            })
            .done(function( msg ) {
              jQuery('#datel').empty(); 
              if(msg.status=true){
                jQuery("#witel option[value=0]").remove();
                datel = jQuery("#datel");
                var returnedArray = msg.data;
                for (var i = 0; i < returnedArray.length; ++i) {
                  datel.append("<option value='" + returnedArray[i].term_id + "'>" + returnedArray[i].name + "</option>");
                }
              }
            });
          });
        });
</script>

<?php
if(isset($regsuccess)){
  wp_redirect(OT_URL);
  exit();
}else{
  ?>

  <form name="loginform" id="loginform" action="" method="post">
    <p class="login-witel">
      <div class="form1"><label for="witel">Witel</label> </div>
     
        <select name="witel" id="witel">
          <?php
          foreach($witels as $witel){
            $selected = ($witel->term_id==$witelid)?"selected":"";
            echo '<option value="'.$witel->term_id.'" '.$selected.'>'.$witel->name.'</option>'; 
          }
          ?>
        </select>
     
    </p>

    <p class="login-datel">
      <div class="form1"><label for="datel">Datel</label> </div>
     
        <select name="datel" id="datel">
          <?php
          foreach($datels as $datel){
            echo '<option value="'.$datel->term_id.'">'.$datel->name.'</option>'; 
          }
          ?>
        </select>
     
    </p>
    <p class="login-first_name">
      <div class="form1">
        <label for="first_name">Nama Depan</label>
      </div>
     
        <input type="text" name="first_name" id="first_name" size="20" value="<?php echo $current_user->user_firstname; ?>" />
      
    </p>

    <p class="login-last_name">
      <div class="form1"><label for="last_name">Nama Belakang</label> </div>
      <input name="last_name" id="last_name" type="text" value="<?php echo $current_user->user_lastname ;?>"> 
    </p>

    <p class="login-ttl">
     <div class="form1"> <label for="lahiran">Tempat / Tgl Lahir</label></div>
   
      <input name="tempat_lahir" type="text" value="<?php echo isset($tempat_lahir)? $tempat_lahir:'';?>" > / 
      <input name="tanggal_lahir" id="tanggal_lahir" type="text" size="12" readonly="readonly"  value="<?php echo isset($tgl_lahir)? $tgl_lahir:'';?>" >
      
   
  </p>

  <p class="login-no_ktp">
   <div class="form1"><label for="no_ktp">No KTP</label></div>
   <input name="no_ktp" id="no_ktp" type="text" maxlength="12" value="<?php echo $no_ktp;?> ">
 </p>

 <p class="login-jenis_kelamin">
   <div class="form1"><label for="jenis_kelamin">Jenis Kelamin</label></div>
  
    <select name="jenis_kelamin">
      <option value="Laki-laki" <?php echo ($jenis_kelamin=="Laki-laki") ? 'selected':'';?>>Laki-laki</option>
      <option value="Perempuan" <?php echo ($jenis_kelamin=="Perempuan") ? 'selected':'';?>>Perempuan</option>
    </select>
  
</p>



<p class="login-alamat_rumah">
 <div class="form1"><label for="alamat_rumah">Alamat Rumah</label></div>
<input name="alamat_rumah" id="alamat_rumah" type="text" value="<?php echo isset($alamat_rumah)? $alamat_rumah:'';?>" >
</p>

<p class="login-nomor_telepon_rumah">
  <div class="form1"><label for="nomor_telepon_rumah">Nomor Telepon Rumah</label></div>
 <input name="nomor_telepon_rumah" id="nomor_telepon_rumah" type="text" value="<?php echo isset($nomor_telepon_rumah)? $nomor_telepon_rumah:'';?>">
</p>

<p class="login-nomor_telepon_hp">
  <div class="form1"> <label for="nomor_telepon_hp">Nomor Telepon Mobile / HP</label></div>
  <input name="nomor_telepon_hp" id="nomor_telepon_hp" type="text" value="<?php echo isset($nomor_telepon_hp)? $nomor_telepon_hp:'';?>">
</p>

<p class="login-email">
 <div class="form1"><label for="email">Email </label></div>
<input name="email" id="email" type="text" value="<?php echo isset($current_user->user_email ) ? $current_user->user_email :'';?>" >
</p>

<p class="login-submit">
 <input type="submit" name="wp-submit" id="wp-submit" class="button-primary3" value="Update" /> 
  <input type="hidden" name="redirect_to" value="http://www.speedyavengers.com" />
</p>
</form> 


<?php
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