<?php
/* Template Name:  Pages Template Register */
?>
<?php get_header(); ?>
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

//print_r($_POST);exit();

        if($_POST['first_name']=="" || $_POST['last_name']=="" || 
          $_POST['tempat_lahir']=="" || $_POST['tanggal_lahir']=="" || /*$_POST['tanggal']=="" || $_POST['tahun']=="" || */
          $_POST['no_ktp']=="" || $_POST['alamat_rumah']=="" ||
          $_POST['nomor_telepon_rumah']=="" || $_POST['nomor_telepon_hp']=="" || $_POST['email']==""){

          echo "<p class='warning'>Semua input harus diisikan.</p>";
      }elseif(is_email($_POST['email']) == false){
        echo "<p class='warning'>Maaf, email tidak valid.</p>";
      }elseif( email_exists( sanitize_email($_POST['email']) == false ) ) {
        echo "<p class='warning'>Maaf, email telah terdaftar.</p>";
      }else{

        //echo sa_generate_register_id($_POST['witel']);
        //exit( var_dump( $wpdb->last_query ) );
        
        /*
        $user_name = sa_generate_Username($_POST['witel']);
        $user_id = username_exists( $user_name );

        //echo $user_name;
        //exit();

        while ( $user_id ) {
          //$user_name = strtoupper(substr($username_gen, 0, 8) . rand(1000,9999) );
          $user_name = sa_generate_Username($_POST['witel']);
          $user_id = username_exists( $user_name );
        }

        //echo $user_name;
        //exit();
        */

        $user_email = sanitize_email($_POST['email']);
        $user_id = username_exists( $user_email );
        $user_name = $user_email;

        if ( !$user_id and email_exists($user_email) == false ) {
          $random_password = wp_generate_password( 6, false );
          $user_id = wp_create_user( $user_name, $random_password, $user_email );

          wp_update_user( 
            array ( 'ID' => $user_id, 
              'first_name' => sanitize_text_field($_POST['first_name']), 
              'last_name' => sanitize_text_field($_POST['last_name']),
              'display_name' =>  sanitize_text_field($_POST['first_name']) . " " . sanitize_text_field($_POST['last_name'])
              ) 
            );

          $registerID = sa_generate_register_id($_POST['witel']);

          update_usermeta($user_id, 'av_witel_id', ($_POST['witel']));
          update_usermeta($user_id, 'av_datel_id', ($_POST['datel']));
          update_usermeta($user_id, 'av_nama_mitra', ($_POST['nama_mitra']));
          update_usermeta($user_id, 'av_register_id', $registerID);
          update_usermeta($user_id, 'av_no_ktp', sanitize_text_field($_POST['no_ktp']));
          update_usermeta($user_id, 'av_tempat_lahir', sanitize_text_field($_POST['tempat_lahir']));
          update_usermeta($user_id, 'av_tanggal_lahir', sanitize_text_field($_POST['tanggal_lahir']));
          update_usermeta($user_id, 'av_jenis_kelamin', sanitize_text_field($_POST['jenis_kelamin']));
          update_usermeta($user_id, 'av_alamat_rumah', sanitize_text_field($_POST['alamat_rumah']));
          update_usermeta($user_id, 'av_nomor_telepon_rumah', sanitize_text_field($_POST['nomor_telepon_rumah']));
          update_usermeta($user_id, 'av_nomor_telepon_hp', sanitize_text_field($_POST['nomor_telepon_hp']));

          update_usermeta($user_id, 'tipe_user', 'pra-avengers');

          $regsuccess = true;
          $headers = 'From: speedyavengers <info@speedyavengers.com>' . "\r\n";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
          //add_filter( 'wp_mail_content_type', 'set_html_content_type' );
          wp_mail(
            $user_email, 
            'Informasi Akun speedyavengers.com', 
            sprintf('
              Akun anda adalah
              Username: %s
              Password: %s
              Register ID: %s
              Silahkan login ke www.speedyavengers.com ', $user_name, $random_password, $registerID, $headers)
            );

              //wp_redirect(REG_SUCCESS_URL);
              //exit();

        } else {
          echo "<p class='warning'>Maaf, email telah terdaftar.</p>";
        }
        

      }

    } 

    $args = array( 'taxonomy' => 'widatel', 'hide_empty'=>0, 'parent'=>0 );
    $witels = sa_getAll_witel();//get_terms('widatel', $args);
    //print_r($witels);
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
              datel.append("<option value='" + returnedArray[i].ID + "'>" + returnedArray[i].nama + "</option>");
            }
          }
        });
      });

      jQuery("#loginform").validate({
        submitHandler : function(form) {
          if (confirm("Apakah anda yakin data anda sudah benar?")) {
            //jQuery(form).submit();
            form.submit();
          }
        },
        rules: {
          first_name: "required",
          last_name:"required",
          tempat_lahir:"required",
          no_ktp: { required: true, minlength: 16, maxlength:16, digits: true },
          alamat_rumah:{ required: true },
          nomor_telepon_rumah: { required: true, digits: true },
          nomor_telepon_hp: { required: true, digits: true },
          email: { required: true, email: true }
        },
        messages: {
          first_name: "Nama depan harus diisi",
          last_name:"Nama belakang harus diisi",
          tempat_lahir:"Tempat Lahir harus diisi",
          no_ktp:"16 digit nomor KTP harus diisi",
          alamat_rumah:"Alamat Rumah harus diisi",
          nomor_telepon_rumah: "Nomor telepon harus diisi",
          nomor_telepon_hp: "Nomor telepon mobile harus diisi dengan benar",
          email: "Email harus diisi dengan benar"
        }
      });

});
</script>

<?php
if(isset($regsuccess)){
  ?>
  <p>
    Selemat anda telah berhasil terdaftar. Silahkan cek email untuk informasi akun anda. 
    <a href="<?php echo SITE_URL;?>">Klik disini untuk kembali ke Website</a>
  </p>
  <?php
}else{
  ?>

  <form name="loginform" id="loginform" action="" method="post">
    <p class="login-witel">
     <div class="form1"><label for="witel">Witel</label></div>

     <select name="witel" id="witel">
      <option value="0" >--Pilih Wilayah Telkom--</option>
      <?php
      foreach($witels as $witel){
        echo '<option value="'.$witel->ID.'">'.$witel->nama.'</option>'; 
      }
      ?>
    </select>

  </p>

  <p class="login-datel">
   <div class="form1"><label for="datel">Datel</label></div>

   <select name="datel" id="datel">
    <option value="0">--Pilih Kantor Telkom--</option>
  </select>

</p>

<p class="login-nama_mitra">
  <div class="form1"><label for="nama_mitra">Nama Mitra</label></div>
  <input type="text" name="nama_mitra" id="nama_mitra"  value="" size="20" />
</p>

<p class="login-first_name">
  <div class="form1"><label for="first_name">Nama Depan</label></div>
  <input type="text" name="first_name" id="first_name"  value="" size="20" />
</p>

<p class="login-last_name">
  <div class="form1"><label for="last_name">Nama Belakang</label></div>
  <input name="last_name" id="last_name" type="text">
</p>

<p class="login-ttl">
 <div class="form1"><label for="lahiran">Tempat / Tgl Lahir</label></div>

 <input name="tempat_lahir" id="tempat_lahir" type="text" > / 
 <input name="tanggal_lahir" id="tanggal_lahir" type="text" size="12" readonly="readonly">

</p>

<p class="login-no_ktp">
 <div class="form1"><label for="no_ktp">No KTP</label></div>
 <input name="no_ktp" id="no_ktp" type="text" maxlength="16">
</p>

<p class="login-jenis_kelamin">
  <div class="form1"><label for="jenis_kelamin">Jenis Kelamin</label></div>

  <select name="jenis_kelamin">
    <option value="Laki-laki">Laki-laki</option>
    <option value="Perempuan">Perempuan</option>
  </select>

</p>



<p class="login-alamat_rumah">
 <div class="form1"><label for="alamat_rumah">Alamat Rumah</label></div>
 <input name="alamat_rumah" id="alamat_rumah" type="text">
</p>

<p class="login-nomor_telepon_rumah">
  <div class="form1"><label for="nomor_telepon_rumah">Nomor Telepon Rumah</label></div>
  <input name="nomor_telepon_rumah" id="nomor_telepon_rumah" type="text">
</p>

<p class="login-nomor_telepon_hp">
 <div class="form1"><label for="nomor_telepon_hp">Nomor Telepon Mobile / HP</label></div>
 <input name="nomor_telepon_hp" id="nomor_telepon_hp" type="text">
</p>

<p class="login-email">
  <div class="form1"><label for="email">Email </label></div>
  <input name="email" id="email" type="text" >
</p>

<p class="login-submit">
  <input type="submit" name="wp-submit" id="wp-submit" class="button-primary3" value="Daftar" /> 
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