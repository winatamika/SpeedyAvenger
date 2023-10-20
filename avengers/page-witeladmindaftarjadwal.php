<?php
/* Template Name:  Pages Admin Witel Daftar Jadwal */ 
get_header();
global $current_user, $wpdb;
$tipe_user = esc_attr(get_the_author_meta('tipe_user', $current_user->ID));
$admin_witelid = esc_attr(get_the_author_meta('av_witel_id', $current_user->ID));
?>
<div id="content"> 
    <div class="clear1"></div>
    <div class="entry">
    	<div id="post">
    		<h1>Daftar Jadwal Tes Online</h1>
    		<?php
    		if (user_can($current_user, "administrator") OR $tipe_user=="webadmin" ){
    			$dbtesname = $wpdb->prefix . 'tesonline';
    			$listes = $wpdb->get_results(
    				$wpdb->prepare( " SELECT * FROM $dbtesname ORDER BY tgl_mulai DESC ")
    				);
    				?>
    				<table>
    					<tr>
    						<td>Nama Jadwal</td>
                            <td>Jenis Soal</td>
    						<td>Tanggal Mulai</td>
    						<td>Tanggal Berakhir</td>
    						<td>Action</td>
    					</tr>

    					<?php
    					foreach($listes as $row){
    						$tesOline = sa_wpsqt_get_test_name($row->wpsqt_id);
    						?>
    						<tr>
                                <td><?php echo $row->nama;?></td>
    							<td><?php echo $tesOline->name;?></td>
    							<td><?php echo date("Y-m-d", $row->tgl_mulai); ?></td>
    							<td><?php echo date("Y-m-d", $row->tgl_selesai); ?></td>
    							<td>
                                    <a href="<?php echo HASIL_URL.'?id='.$row->id; ?>" >Hasil</a> - 
                                    <a href="<?php echo SITE_URL.'/dashboard/tambah-jadwal/'.'?id='.$row->id; ?>" >Edit</a>
                                </td>
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