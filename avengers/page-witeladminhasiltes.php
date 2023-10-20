<?php
/* Template Name:  Pages Admin Witel Hasil Tes*/ 
get_header();
global $current_user, $wpdb;
$admin_witelid = esc_attr(get_the_author_meta('av_witel_id', $current_user->ID));
$tipe_user = esc_attr(get_the_author_meta('tipe_user', $current_user->ID));

if (user_can($current_user, "administrator") OR $tipe_user=="webadmin" ){
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
				<h1>Hasil Tes Online</h1>
				<?php
			//print_r($_GET);

				if(isset($_GET['id'])){
					if($_GET['id']>=1){
						$jadwal = sa_jadwal_detail($_GET['id']);
					}
				}

				if($jadwal<>false){
					if($tipe_user=="webadmin"){
						$witelsearch = $admin_witelid;
					}else{
						$witelsearch = 0;
					}
					
					$jadwal_mulai = date("Y-m-d", $jadwal->tgl_mulai);
					$jadwal_selesai = date("Y-m-d", $jadwal->tgl_selesai);
					$sort = false;
					$sortorder = "ASC";

					if(isset($_POST['wp-submit'])){
						if ( !isset($_POST['filter_button_field']) || !wp_verify_nonce($_POST['filter_button_field'],'filter_hasil_action') ) {
							echo "error form";
						}else{
							$witelsearch = ($_POST['witel']>0) ? $_POST['witel'] : 0;
							$jadwal_mulai = isset($_POST['range_from']) ? $_POST['range_from'] : date("Y-m-d", $jadwal->tgl_mulai);
							$jadwal_selesai = isset($_POST['range_until']) ? $_POST['range_until'] : date("Y-m-d", $jadwal->tgl_selesai);
							if($_POST['gen_csv']==1){
								$argCSV = array("nama"=>$jadwal->nama, "wpsqt_id"=>$jadwal->wpsqt_id, "jadwal_mulai"=>$jadwal_mulai, "jadwal_selesai"=>$jadwal_selesai);
								$filename = sa_generate_CSV($argCSV);
							}
							$sort = $_POST['sort'];
							$sortorder = $_POST['sortorder'];
						}

					}

					$args = array(
						'wpsqt_id'=>$jadwal->wpsqt_id,
						'jadwal_mulai'=>$jadwal_mulai,
						'jadwal_selesai'=>$jadwal_selesai,
						'witel_id'=>$witelsearch, 
						'sort'=>$sort, 
						'sortorder'=>$sortorder, 
						);
					$results = hasilTesOnline($args);

					//print_r($results);
					//exit();

					//$dbtablename = $wpdb->prefix . 'wpsqt_all_results';
					//$listes = $wpdb->get_results(
					//	$wpdb->prepare( " SELECT * FROM $dbtablename WHERE item_id=".$jadwal->wpsqt_id." AND datetaken >= ". strtotime($jadwal_mulai." 00:00:01") ." AND datetaken <= ". strtotime($jadwal_selesai . "23:59:59" ) ." ")
					//	);

					//$args = array( 'taxonomy' => 'widatel', 'hide_empty'=>0, 'parent'=>0 );
					//$witels = get_terms('widatel', $args);
					//$datels = array();
					//foreach($witels as $row){
					//	$args = array( 'taxonomy' => 'widatel', 'hide_empty'=>0, 'parent'=>$row->term_id );
					//	$datels = array_merge($datels, get_terms('widatel', $args));
					//}

					$witels = sa_getAll_witel();

					$tesOline = sa_wpsqt_get_test_name($jadwal->wpsqt_id);

					$saOptions = sa_getOptions();

					?>

					<form name="filter" id="filter" method="post">

						<p class="filter-range-from">
							<div class="label"><label for="range_from">Jadwal :</label></div>
							<?php echo $jadwal->nama; ?>
						</p>

						<p class="filter-range-from">
							<div class="label"><label for="range_from">Jenis Soal :</label></div>
							<?php echo $tesOline->name; ?>
						</p>

						<p class="filter-range-from">
							<div class="label"><label for="range_from">Dari Tanggal :</label></div>
							<input name="range_from" id="range_from" type="text" value="<?php echo $jadwal_mulai;?>">
						</p>

						<p class="filter-range-until">
							<div class="label"><label for="range_until">Sampai Tanggal :</label></div>
							<input name="range_until" id="range_until" type="text" value="<?php echo $jadwal_selesai;?>">
						</p>

						<p class="filter-witel">
							<div class="label"><label for="witel">Witel :</label></div>
							<select name="witel" id="witel" <?php echo ($tipe_user=="webadmin") ? "readonly":""; ?> >
								<option value=0>SEMUA</option>
								<?php
								foreach($witels as $witel){
									$selected = ($witel->ID == $witelsearch) ? " selected" : "";
									echo '<option value="'.$witel->ID.'"' . $selected . '>'.$witel->nama.'</option>'; 
								}
								?>
							</select>
						</p>

						<p class="filter-sort">
							<div class="label"><label for="sort">Urutkan :</label></div>
							<select name="sort" id="sort">
								<option value="username" <?php echo ($sort=="username")?"selected":""; ?> >Username</option>
								<option value="name" <?php echo ($sort=="name")?"selected":""; ?> >Nama Peserta</option>
								<option value="witelid" <?php echo ($sort=="witelid")?"selected":""; ?> >Witel</option>
								<option value="datetaken" <?php echo ($sort=="datetaken")?"selected":""; ?> >Tanggal</option>
								<option value="score" <?php echo ($sort=="score")?"selected":""; ?> >Skor</option>
								<option value="result" <?php echo ($sort=="result")?"selected":""; ?> >Keterangan</option>
							</select>
							<input type="radio" name="sortorder" value="ASC" <?php echo ($sortorder=="ASC")?"checked":""; ?> >A-Z
							<input type="radio" name="sortorder" value="DESC" <?php echo ($sortorder=="DESC")?"checked":""; ?> >Z-A
						</p>

						<p class="filter-range-until">
							<div class="label"><label for="gen_csv">Buat CSV :</label></div>
							<input name="gen_csv" id="gen_csv" type="checkbox" value="1">
							<?php
							if(isset($filename)){
								echo "<a href=\"".$filename."\">Unduh CSV</a>";
							}
							?>
						</p>

						<p class="filter-submit">
							<input type="submit" name="wp-submit" id="wp-submit" class="button-primary3" value="Filter" /> 
							<?php wp_nonce_field('filter_hasil_action','filter_button_field'); ?>
						</p>

						<p>&nbsp;</p>

					</form>

					<table>
						<tr>
							<td>Username</td>
							<td>Nama Peserta</td>
							<td>Witel</td>
							<td>Tanggal</td>
							<td>Skor</td>
							<td>Keterangan</td>
						</tr>

						<?php
						if($results<>false):
							foreach($results as $row){
								$username = esc_html(wp_kses_stripslashes($row->person_name)); 
								$user = get_user_by( 'login', $username );
								if($user->first_name<>"" || $user->last_name<>"")
									$nama_lengkap = $user->first_name ." ". $user->last_name;
								else
									$nama_lengkap = $username;

								$witeldetail = sa_get_witel(get_the_author_meta('av_witel_id', $user->ID));
								$dateldetail = sa_get_datel(get_the_author_meta('av_datel_id', $user->ID));

							//if($witelsearch==0 OR $witelsearch==$datelid){
								?>
								<tr>
									<td><?php echo $row->person_name;?></td>
									<td><?php echo $nama_lengkap;?></td>
									<td><?php echo $witeldetail->nama . " - " . $dateldetail->nama; ?></td>
									<td><?php echo get_date_from_gmt(date("Y-m-d H:i:s",$row->datetaken), "Y-m-d H:i");?></td>
									<td><?php echo $row->score."/".$row->total;?></td>
									<td>
										<?php 
										//echo ($row->pass==0) ? "Tidak Berhasil" : "Berhasil" ;
										echo ( $row->percentage <= $saOptions['passmark'] ) ? "Tidak Berhasil" : "Berhasil" ;
										?>
									</td>
								</tr>
								<?php
							//}

							}
							endif;
							?>
						</table>
						<?php
					}

					?>

				</div>
			</div>
		</div>

		<script type="text/javascript">
		jQuery(function() {
			jQuery( "#range_from" ).datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,
				minDate: "<?php echo date("Y-m-d", $jadwal->tgl_mulai);?>",
				maxDate: "<?php echo date("Y-m-d", $jadwal->tgl_selesai);?>",
				onClose: function( selectedDate ) {
					jQuery( "#range_until" ).datepicker( "option", "minDate", selectedDate );
				}
			});
			jQuery( "#range_until" ).datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
				numberOfMonths: 1,
				minDate: "<?php echo date("Y-m-d", $jadwal->tgl_mulai);?>",
				maxDate: "<?php echo date("Y-m-d", $jadwal->tgl_selesai);?>"
			});





		});
		</script>

		<?php
	} else{
		echo "<p>Sorry yo can not access this page!</p>";
	}
	get_footer();
	?>