<?php
/* Template Name:  Pages Admin Biodata Peserta*/ 
get_header();
global $current_user, $wpdb;
$tipe_user = esc_attr(get_the_author_meta('tipe_user', $current_user->ID));
$admin_witelid = esc_attr(get_the_author_meta('av_witel_id', $current_user->ID));
//echo $admin_witelid;
if (user_can($current_user, "administrator") OR $tipe_user=="webadmin" ){
//echo $_GET['username'];
	if(isset($_GET['username'])){
		/*
			$username = $_GET['username'];
		       if ( username_exists( $username ) )
		           echo "Username In Use!";
		       else
		           echo "Username Not In Use!";
		*/
		if( username_exists($_GET['username']) ){
			$username = $_GET['username'];
		}

		$saOptions = sa_getOptions();
	}

?>
<style type="text/css">
<!--
.label {float:left; width:200px}
-->
</style>
<div id="content"> 
	<div class="clear1"></div>
	<div class="entry">
		<div id="post">

			<?php
				if($tipe_user=="webadmin"){
						$witelsearch = $admin_witelid;
					}else{
						$witelsearch = 0;
					}

				$sort = false;
				$sortorder = "ASC";

				if(isset($_POST['wp-submit'])){
					if ( !isset($_POST['filter_button_field']) || !wp_verify_nonce($_POST['filter_button_field'],'filter_hasil_action') ) {
						echo "error form";
					}else{
						if($_POST['witel']>0)
							$witelsearch = $_POST['witel'];
						$sort = $_POST['sort'];
						$sortorder = $_POST['sortorder'];
					}
				}



				$args = array(
					'witel_id'=>$witelsearch,
					'sort'=>$sort, 
					'sortorder'=>$sortorder, 
					'username'=>$username
					);
				$peserta = sa_getUser($args);

				if(is_array($peserta)){

					$user = $peserta[0];
					$tipe_user = esc_attr(get_the_author_meta('tipe_user', $user->ID));
    //$biodata_user = get_the_author_meta('biodata_user', $user->ID);
    //$biodata = json_decode($biodata_user, true);

					$witelid = get_the_author_meta('av_witel_id', $user->ID);
					$datelid = get_the_author_meta('av_datel_id', $user->ID);
					$witeldetail = sa_get_witel($witelid);
					$dateldetail = sa_get_datel( $datelid );

    //$args = array( 'taxonomy' => 'widatel', 'hide_empty'=>0, 'parent'=>0 );
    //$witels = get_terms('widatel', $args);
					//$witels = sa_getAll_witel();

    //$args = array( 'taxonomy' => 'widatel', 'hide_empty'=>0, 'parent'=>$witelid );
    //$datels = get_terms('widatel', $args);
					//$datels = sa_get_datels($witelid);

					$nama_mitra = get_the_author_meta('av_nama_mitra', $user->ID);
					$first_name = get_the_author_meta('first_name', $user->ID);
					$last_name = get_the_author_meta('last_name', $user->ID);
					$tempat_lahir = get_the_author_meta('av_tempat_lahir', $user->ID);
					$tgl_lahir = get_the_author_meta('av_tanggal_lahir', $user->ID);
					$no_ktp = get_the_author_meta('av_no_ktp', $user->ID);
					$jenis_kelamin = get_the_author_meta('av_jenis_kelamin', $user->ID);
					$alamat_rumah = get_the_author_meta('av_alamat_rumah', $user->ID);
					$nomor_telepon_rumah = get_the_author_meta('av_nomor_telepon_rumah', $user->ID);
					$nomor_telepon_hp = get_the_author_meta('av_nomor_telepon_hp', $user->ID);
					$register_id = get_the_author_meta('av_register_id', $user->ID);
//print_r($user);
					?>

<style type="text/css">
.form-group{
	width: 650px;
}
.col1{
	float: left;
	width: 210px;
}
.col2{
	
}
</style>
<p class="form-group">
  <div class="col1"><label for="witel">Witel</label></div>
  <div class="col2" id="witel"><?php echo $witeldetail->nama;?></div>
  <div style="clear-both;"></div>
</p>
<p class="form-group">
  <div class="col1"><label for="datel">Datel</label></div>
  <div class="col2" id="datel"><?php echo $dateldetail->nama;?></div>
  <div style="clear-both;"></div>
</p>
<p class="form-group">
  <div class="col1"><label for="nama_mitra">Register ID</label></div>
  <div class="col2" id="nama_mitra"><?php echo $register_id;?></div>
  <div style="clear-both;"></div>
</p>
<p class="form-group">
  <div class="col1"><label for="nama_mitra">Nama Mitra</label></div>
  <div class="col2" id="nama_mitra"><?php echo $nama_mitra;?></div>
  <div style="clear-both;"></div>
</p>
<p class="form-group">
  <div class="col1"><label for="nama">Nama</label></div>
  <div class="col2" id="nama"><?php echo $first_name . " " . $last_name;?></div>
  <div style="clear-both;"></div>
</p>
<p class="form-group">
  <div class="col1"><label for="ttl">Tempat / Tgl Lahir</label></div>
  <div class="col2" id="ttl"><?php echo $tempat_lahir . " / " . $tgl_lahir;?></div>
  <div style="clear-both;"></div>
</p>
<p class="form-group">
  <div class="col1"><label for="ktp">No KTP</label></div>
  <div class="col2" id="ktp"><?php echo $no_ktp;?></div>
  <div style="clear-both;"></div>
</p>
<p class="form-group">
  <div class="col1"><label for="jenis_kelamin">Jenis Kelamin</label></div>
  <div class="col2" id="jenis_kelamin"><?php echo $jenis_kelamin;?></div>
  <div style="clear-both;"></div>
</p>
<p class="form-group">
  <div class="col1"><label for="alamat_rumah">Alamat Rumah</label></div>
  <div class="col2" id="alamat_rumah"><?php echo $alamat_rumah;?></div>
  <div style="clear-both;"></div>
</p>
<p class="form-group">
  <div class="col1"><label for="nomor_telepon_rumah">Nomor Telepon Rumah</label></div>
  <div class="col2" id="nomor_telepon_rumah"><?php echo $nomor_telepon_rumah;?></div>
  <div style="clear-both;"></div>
</p>
<p class="form-group">
  <div class="col1"><label for="nomor_telepon_hp">Nomor Telepon Mobile / HP</label></div>
  <div class="col2" id="nomor_telepon_hp"><?php echo $nomor_telepon_hp;?></div>
  <div style="clear-both;"></div>
</p>
<p class="form-group">
  <div class="col1"><label for="email">Email</label></div>
  <div class="col2" id="email"><?php echo $user->user_email;?></div>
  <div style="clear-both;"></div>
</p>

<h3>Histories Test</h3>
<table class="form-table">
	<tr>
		<td>Tanggal</td>
		<td>Jenis Ujian</td>
		<td>Hasil</td>
	</tr>

	<?php
	$histories = sa_wpsqt_get_histories($user);
	if($histories<>false){
		foreach($histories as $history){
			$qname = sa_wpsqt_get_test_name($history->item_id);
			$fieldsetting = unserialize($qname->settings);
            //print_r($history);
			?>
			<tr>
				<td><?php echo date("Y-m-d",$history->datetaken); ?></td>
				<td><?php echo ($qname==false) ? 'Unknown':$qname->name; ?></td>
				<td>
					<?php 
					echo ($history->percentage >= $saOptions['passmark'] ) ? "Berhasil":"Tidak Berhasil" ;
					echo ' ('.$history->score.'/'.$history->total.')'; 
					?>
				</td>
			</tr>
			<?php
		}
	}
	?>
</table>

					<?php
				}
				//$witels = sa_getAll_witel();

				//print_r($peserta);

				?>


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