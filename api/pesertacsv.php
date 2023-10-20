<?php

/*
 * param
 * $id integer
 * return json encode
 * 
 */

define('WP_USE_THEMES', false);
/** Loads the WordPress Environment and Template */
require("../wp-load.php");
error_reporting(-1);
global $wpdb;
$dbtablename1 = $wpdb->prefix . 'users';
$dbtablename2 = $wpdb->prefix . 'usermeta';

$results = $wpdb->get_results(
	$wpdb->prepare( " SELECT * FROM $dbtablename1 as A 
		LEFT JOIN $dbtablename2 as B ON (B.user_id=A.ID AND B.meta_key='tipe_user' ) 
		LEFT JOIN $dbtablename2 as C ON (C.user_id=A.ID AND C.meta_key='av_witel_id') 
		LEFT JOIN $dbtablename2 as D ON (D.user_id=A.ID AND D.meta_key='first_name') 
		WHERE B.meta_value='pra-avengers' 
		")
	);

$csvLines[] = array("No", "Username", "Nama", "Witel", "Datel", "Tempat Lahir", "Tanggal Lahir", "No KTP", "Jenis Kelamin", "Alamat Rumah", "No Telpon", "No Handphone");
$no = 1;
foreach( $results as $user ){ 
	
    $witelid = esc_attr(get_the_author_meta('av_witel_id', $user->ID));
    $datelid = esc_attr(get_the_author_meta('av_datel_id', $user->ID));

	//$witeldetail = get_term_by( 'id',  $witelid, 'widatel');
	//$dateldetail = get_term_by( 'id',  $datelid, 'widatel');

    $witeldetail = sa_get_witel(get_the_author_meta('av_witel_id', $user->ID));
    $dateldetail = sa_get_datel(get_the_author_meta('av_datel_id', $user->ID));

    $first_name = get_the_author_meta('first_name', $user->ID);
    $last_name = get_the_author_meta('last_name', $user->ID);

    $tempat_lahir = get_the_author_meta('av_tempat_lahir', $user->ID);
    $tgl_lahir = get_the_author_meta('av_tanggal_lahir', $user->ID);
    $no_ktp = get_the_author_meta('av_no_ktp', $user->ID);
    $jenis_kelamin = get_the_author_meta('av_jenis_kelamin', $user->ID);
    $alamat_rumah = get_the_author_meta('av_alamat_rumah', $user->ID);
    $nomor_telepon_rumah = get_the_author_meta('av_nomor_telepon_rumah', $user->ID);
    $nomor_telepon_hp = get_the_author_meta('av_nomor_telepon_hp', $user->ID);

    $csvLines[] = array($no, "\"".$user->user_login."\"", "\"".addslashes($first_name." ".$last_name)."\"", 
        $witeldetail->nama, $dateldetail->nama, 
        $tempat_lahir, $tgl_lahir, "\"".$no_ktp."\"", $jenis_kelamin, addslashes($alamat_rumah), 
        "\"".$nomor_telepon_rumah."\"", "\"".$nomor_telepon_hp."\"");
    $no = $no + 1;
}

//print_r($csvLines);
$filename = "DataPeserta-".date("Y-m-d H:i:s").".csv";
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Description: File Transfer');
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename={$filename}");
    header("Expires: 0");
    header("Pragma: public");

    $fp = fopen($filename, 'w');
    
    foreach ($csvLines as $fields) {
        //fputcsv($fp, $fields);
        echo implode(", ", $fields)."\r\n";
    }
    fclose($fp);

/*
$csvLines[] = array("No", "Username", "Nama", "Skor", "Total", "Pass/Fail", "Tanggal");
$no = 1;
foreach( $results as $row ){ 
	$username = esc_html(wp_kses_stripslashes($row->person_name)); 
	$user = get_user_by( 'login', $username );
	if($user->first_name<>"" || $user->last_name<>"")
		$nama_lengkap = $user->first_name ." ". $user->last_name;
	else
		$nama_lengkap = $username;

	$witelid = get_the_author_meta('av_witel_id', $user->ID);
	$datelid = get_the_author_meta('av_datel_id', $user->ID);

	$witeldetail = get_term_by( 'id',  $witelid, 'widatel');
	$dateldetail = get_term_by( 'id',  $datelid, 'widatel');

	$keterangan = ($row->pass==0) ? "Tidak Berhasil" : "Berhasil";
	$csvLines[] = array($no, $row->person_name, $nama_lengkap, $row->score, $row->total, $keterangan, get_date_from_gmt(date('Y-m-d H:i:s',$row->datetaken), 'Y-m-d H:i'));

	$no = $no + 1;
}
*/

    /*
    $csvLines[] = array("No", "Username", "Nama", "Skor", "Total", "Pass/Fail", "Tanggal");
    $no = 1;
    foreach( $results as $row ){ 
        $username = esc_html(wp_kses_stripslashes($row->person_name)); 
        $user = get_user_by( 'login', $username );
        if($user->first_name<>"" || $user->last_name<>"")
            $nama_lengkap = $user->first_name ." ". $user->last_name;
        else
            $nama_lengkap = $username;

        $witelid = get_the_author_meta('av_witel_id', $user->ID);
        $datelid = get_the_author_meta('av_datel_id', $user->ID);

        $witeldetail = get_term_by( 'id',  $witelid, 'widatel');
        $dateldetail = get_term_by( 'id',  $datelid, 'widatel');

        $keterangan = ($row->pass==0) ? "Tidak Berhasil" : "Berhasil";
        $csvLines[] = array($no, $row->person_name, $nama_lengkap, $row->score, $row->total, $keterangan, get_date_from_gmt(date('Y-m-d H:i:s',$row->datetaken), 'Y-m-d H:i'));

        $no = $no + 1;
    }
    //print_r($csvLines);
    $upload_dir = array('basedir'=>'tmp');//.wp_upload_dir();
    $filename = str_replace(" ", "-", $data['nama'].date("Y-m-d His")).".csv";

    $fp = fopen($upload_dir['basedir'] ."/". $filename, 'w');

    foreach ($csvLines as $fields) {
        fputcsv($fp, $fields);
    }

    fclose($fp);

    return SITE_URL."/".$upload_dir['basedir'] ."/". $filename;
    //$path = $upload_dir['path'] ."/";
    //file_put_contents($path, implode($csvLines, "\r\n"));
    //$fp = fopen($upload_dir['basedir'] ."/".$filename, 'w');
    
    //foreach ($csvLines as $fields) {
    //    fputcsv($fp, $fields);
    //}
    //fclose($fp);
    */

    /*
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Description: File Transfer');
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename={$filename}");
    header("Expires: 0");
    header("Pragma: public");

    $fp = fopen($filename, 'w');
    
    foreach ($csvLines as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
    */


    ?>