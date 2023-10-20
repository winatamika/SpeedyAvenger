<?php
/* Template Name:  Pages Admin Daftar Admin Witel */ 
get_header();
global $current_user, $wpdb;
$tipe_user = esc_attr(get_the_author_meta('tipe_user', $current_user->ID));
//$admin_witelid = esc_attr(get_the_author_meta('av_witel_id', $current_user->ID));
?>
<div id="content"> 
	<div class="clear1"></div>
	<div class="entry">
		<div id="post">

			<?php
			if ($tipe_user=="admin-witel-barat" OR $tipe_user=="admin-witel-timur"){
				$witeladmins = sa_getDivisiAdminWitel($tipe_user);
					?>
					<table>
						<tr>
							<td>Witel</td>
							<td>Nama</td>
							<td>Email</td>
							<td>Telepon</td>
							<!--<td>Action</td>-->
						</tr>

						<?php
						foreach($witeladmins as $row){
							//print_r($row);
							$witeldetail = sa_get_witel($row->av_witel_id);
							//$dateldetail = sa_get_datel($row->av_datel_id);

							?>
							<tr>
								<td><?php echo $witeldetail->nama; ?></td>
								<td><?php echo $row->first_name." ".$row->last_name; ?></td>
								<td><?php echo $row->user_email; ?></td>
								<td>&nbsp;</td>
								<!--<td></td>-->
							</tr>
							<?php
						}
						?>
					</table>
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