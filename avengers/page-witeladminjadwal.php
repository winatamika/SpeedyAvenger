<?php
/* Template Name:  Pages Admin Witel Tambah Jadwal */ 
get_header();
global $current_user, $wpdb;
$admin_witelid = esc_attr(get_the_author_meta('av_witel_id', $current_user->ID));

if (user_can($current_user, "administrator")){

  if(isset($_GET['id'])){
    $jadwal_detail = sa_jadwal_detail($_GET['id']);
    
    //print_r($jadwal_detail);

    if($jadwal_detail==false){
      $msg = array(
        "type"=>"error",
        "text"=>"Data tidak ditemukan."
        );
    }
  }

  if(isset($_POST['wp-submit'])){
   if ( !isset($_POST['jadwal_button_field']) || !wp_verify_nonce($_POST['jadwal_button_field'],'save_jadwal_action') ) {
    $msg = array(
      "type"=>"error",
      "text"=>"Data tidak berhasil ditambahkan."
      );
		//exit;
  } else {
	// process form data
    if($_POST['tgl_mulai']<>"" AND $_POST['tgl_selesai']<>"" AND $_POST['nama']<>"" ){
     $data['nama'] = $_POST['nama'];
     $data['wpsqt_id'] = $_POST['wpsqt_id'];
     $data['tgl_mulai'] = strtotime($_POST['tgl_mulai']." 06:00:00");
     $data['tgl_selesai'] = strtotime($_POST['tgl_selesai']." 18:00:00");
     if(isset($_POST['id']) AND $_POST['id']>0 ){
      sa_jadwal_edit($_POST['id'], $data);
      $jadwal_detail = sa_jadwal_detail($_GET['id']);
    }else{
      sa_jadwal_add($data);
    }

    $msg = array(
      "type"=>"info",
      "text"=>"Data berhasil ditambahkan."
      );
  }else{
   $msg = array(
    "type"=>"error",
    "text"=>"Data tidak berhasil ditambahkan."
    );
 }
}
}

?>
<div id="content"> 
  <div class="clear1"></div>
  <div class="entry">
   <div id="post">

    <?php
    if(isset($msg)){
     echo "<p class='".$msg['type']."'>".$msg['text']."</p>";
   }
   ?>
   <?php
   

   $listAllQuiz = sa_wpsqt_list_all(" LIMIT 3 ");

   ?>
   <form name="tambahjadwal" id="tambahjadwal" method="post">

     <p class="jadwal-nama">
      <div class="label"><label for="nama">Nama Jadwal</label></div>
      <input name="nama" id="nama" type="text" value="<?php echo isset($jadwal_detail) ? $jadwal_detail->nama:''; ?>" >
    </p>

    <p class="jadwal-wpsqt">
      <div class="label"><label for="wpsqt">Jenis Soal</label></div>

      <select name="wpsqt_id" id="wpsqt_id">
       <?php
       
       foreach($listAllQuiz as $row){
        $selected = "";
        if( isset($jadwal_detail) ){
          $selected = ($jadwal_detail->id==$row->id) ? " selected ":"";
        }
        echo "<option value=".$row->id." ".$selected." >".$row->name."</option>";
      }
      ?>
    </select>

  </p>

  <p class="jadwal-mulai">
    <div class="label"><label for="mulai">Jadwal Mulai</label></div>
    <input name="tgl_mulai" id="tgl_mulai" type="text" value="<?php echo isset($jadwal_detail) ? date("Y-m-d",$jadwal_detail->tgl_mulai) : date("Y-m-d"); ?>" >
  </p>
  <p class="jadwal-selesai">
    <div class="label"><label for="selesai">Jadwal Selesai</label></div>
    <input name="tgl_selesai" id="tgl_selesai" type="text" value="<?php echo isset($jadwal_detail) ? date("Y-m-d",$jadwal_detail->tgl_selesai) : date("Y-m-d"); ?>" >
  </p>

  <p class="login-submit">
    <?php
    if(isset($jadwal_detail)){
      echo '<input type="submit" name="wp-submit" id="wp-submit" class="button-primary3" value="Update Jadwal" />';
    }else{
      echo '<input type="submit" name="wp-submit" id="wp-submit" class="button-primary3" value="Tambah Jadwal" />';
    }
    ?>
    
    <input type="hidden" name="id" id="id" value="<?php echo isset($jadwal_detail) ? $jadwal_detail->id:0; ?>" /> 
    <?php wp_nonce_field('save_jadwal_action','jadwal_button_field'); ?>
  </p>

</form>
<?php

?>

</div>
</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {

  jQuery( "#tgl_mulai" ).datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    numberOfMonths: 1,
    minDate: '+0',
    onClose: function( selectedDate ) {
     jQuery( "#tgl_selesai" ).datepicker( "option", "minDate", selectedDate );
   }
 });

  jQuery( "#tgl_selesai" ).datepicker({
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    numberOfMonths: 1,
    minDate: '+0',
    
  });

  jQuery("#tambahjadwal").validate({
    rules: {
     nama: "required"
   },
   messages: {
     nama: "Nama jadwal harus diisi"
   }
 });


});
</script>

<?php
}else{
  echo "<p>Sorry yo can not access this page!</p>";
}
get_footer();
?>