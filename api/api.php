<?php
define('WP_USE_THEMES', false);
require("../wp-load.php");

if(isset($_POST)){
	switch ($_POST['method']) {
		case 'getDatel':
			/*
			$args = array( 'taxonomy' => 'widatel', 'hide_empty'=>0, 'parent'=>$_POST['parentID'] );
			$wintels = get_terms('widatel', $args);
			*/
			global $wpdb;

			$witelID = $_POST['parentID'];
			$dbtablename = $wpdb->prefix . 'datel';
			$results = $wpdb->get_results(
				$wpdb->prepare( " SELECT * FROM $dbtablename WHERE witel_ID=$witelID ORDER BY ID ASC " )
				);

			//if(sizeof($results)>0){
			//	return $results;
			//}else{
			//	return false;
			//}

			$result = array('status'=>true, 'data'=>$results, 'text'=>$_POST['method'].'defined');

			break;
			case 'getAjaxPeserta':

			if(isset($witelsearch)){
				$args2 = array(
					'role'         => 'subscriber',
					'meta_key'     => 'tipe_user',
					'meta_value'   => 'pra-avengers',
					'meta_query' => array(
						array(
							'key'     => 'av_datel_id',
							'value'   => $witelsearch,
							'compare' => '='
							)
						),
					'fields' => 'all_with_meta'
					);
			}else{
				$args2 = array(
					'role'         => 'subscriber',
					'meta_key'     => 'tipe_user',
					'meta_value'   => 'pra-avengers',
					'fields' => 'all_with_meta'
					);
			}
			$allpeserta = get_users($args2);

			break;
			default:
			$result = array('status'=>false, 'text'=>json_encode($_POST).'no method defined');
			break;
		}
	}else{
		$result = array('status'=>false, 'text'=>'no input defined');
	}

	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	echo json_encode( $result );
	?>