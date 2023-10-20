<?php
/* Template Name:  Pages Admin Witel Peserta*/ 
get_header();
global $current_user, $wpdb;
$tipe_user = esc_attr(get_the_author_meta('tipe_user', $current_user->ID));
$admin_witelid = esc_attr(get_the_author_meta('av_witel_id', $current_user->ID));
//echo $admin_witelid;
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
					);
				$allpeserta = sa_getUsers($args);

				$witels = sa_getAll_witel();

				?>

				<form name="filter" id="filter" method="post">
					<p class="filter-witel">
						<div class="label"><label for="witel">Witel :</label></div>
						<select name="witel" id="witel" <?php echo ($tipe_user=="webadmin") ? "disabled":""; ?> >
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
						</select>
						<input type="radio" name="sortorder" value="ASC" <?php echo ($sortorder=="ASC")?"checked":""; ?> >A-Z
						<input type="radio" name="sortorder" value="DESC" <?php echo ($sortorder=="DESC")?"checked":""; ?> >Z-A
					</p>

					<p class="filter-submit">
						<input type="submit" name="wp-submit" id="wp-submit" class="button-primary3" value="Filter" /> 
						<?php wp_nonce_field('filter_hasil_action','filter_button_field'); ?>
					</p>

					<p>&nbsp;</p>

				</form>

				<table>
					<thead>
						<tr>
							<td>No</td>
							<td>Username</td>
							<td>Nama Peserta</td>
							<td>Witel</td>
							<td>Nama Tes</td>
							<td>Nilai Tes</td>
						</tr>
					</thead>
					<!--<tbody>-->
					<?php
					$page = 1;
					$counts = 0;
					if($allpeserta<>false){

						foreach($allpeserta as $user){
							if($page==1){
								echo "<tbody id='page".$page."' class='page'>";
								$page = $page+1;
							}else{
								if($counts % 50 == 0){
								//$page = $page+1;
									echo '</tbody>';
									echo "<tbody id='page".$page."' class='page' style='display:none;'>";
									$page = $page+1;
								}
							}

							$counts = $counts +  1;
						//if($counts % 50 == 0){
							//if($page==0)
							//	echo "<tbody id='page".$page."' class='page'>";
							//else
							//	echo "<tbody id='page".$page."' class='page' style='display:none;'>";
							//$page = $page+1;
						//}

							$username = esc_html(wp_kses_stripslashes($user->user_login)); 
							$user = get_user_by( 'login', $username );
							if($user->first_name<>"" || $user->last_name<>"")
								$nama_lengkap = $user->first_name ." ". $user->last_name;
							else
								$nama_lengkap = $username;

							$witeldetail = sa_get_witel(get_the_author_meta('av_witel_id', $user->ID));
							$dateldetail = sa_get_datel(get_the_author_meta('av_datel_id', $user->ID));

						//$witelid = get_the_author_meta('av_witel_id', $user->ID);
						//$datelid = get_the_author_meta('av_datel_id', $user->ID);
						//$witeldetail = get_term_by( 'id',  $witelid, 'widatel');
						//$dateldetail = get_term_by( 'id',  $datelid, 'widatel');

				        //print_r($dateldetail);

							?>
							<tr>
								<td><?php echo $counts;?></td>
								<td><?php echo "<a href='".DETAIL_PESERTA_URL."?username=".$user->user_login."'>".$user->user_login."</a>";?></td>
								<td><?php echo $user->first_name . " " . $user->last_name;?></td>
								<td><?php echo $witeldetail->nama;?> - <?php echo $dateldetail->nama;?></td>
								
									<?php 
									$hasil = sa_userhasil($user->user_login);
									if($hasil<>false){
										echo "<td>".$hasil[0]->nama ." (".$hasil[0]->name.")</td><td>". $hasil[0]->percentage ."</td>";
									}else{
										echo "<td>-</td><td>-</td>";
									}
									?>
								</td>
							</tr>
							<?php

							if( $counts >= sizeof($allpeserta) ){
								$page = $page-1;
								echo '</tbody>';
							}
						}
					}
					?>
					<!--</tbody>-->
				</table>
				<div id="light-pagination"></div>
				<script type="text/javascript">
				jQuery('#light-pagination').pagination({
					displayedPages: 13,
					items: <?php echo $page;?>,
					cssStyle: 'light-theme',
					onPageClick: function(pageNumber){ 
						jQuery('.page').hide();
						jQuery('#page'+pageNumber).show();
					},
				});
				</script>

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