<?php
define("HASIL_URL", SITE_URL . "/dashboard/hasil-tes/");

function sa_wpsqt_get_histories($user){
    global $wpdb;

    $dbtablename = $wpdb->prefix . 'wpsqt_all_results';
    $testhistories = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM  $dbtablename WHERE person_name=%s ORDER BY datetaken ASC ", $user->user_login )
        );

    if(sizeof($testhistories)>0){
        return $testhistories;
    }else{
        return false;
    }
}

function sa_wpsqt_get_test_name($id){
    global $wpdb;

    $dbtablename = $wpdb->prefix . 'wpsqt_quiz_surveys';
    $quiz = $wpdb->get_row(
        $wpdb->prepare( " SELECT * FROM $dbtablename WHERE id=%d ", $id )
        );

    if(sizeof($quiz)>0){
        return $quiz;
    }else{
        return false;
    }
}

function sa_wpsqt_list_all($sqladd=""){
    global $wpdb;

    $dbtablename = $wpdb->prefix . 'wpsqt_quiz_surveys';
    $quiz = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename ORDER BY name ASC " . $sqladd )
        );

    if(sizeof($quiz)>0){
        return $quiz;
    }else{
        return false;
    }
}

function sa_jadwal_add($data){
    global $wpdb;

    $dbtablename = $wpdb->prefix . 'tesonline';

    $wpdb->query( $wpdb->prepare( 
        "
        INSERT INTO $dbtablename
        ( nama, wpsqt_id, tgl_mulai, tgl_selesai )
        VALUES ( %s, %d, %d, %d )
        ", 
        $data['nama'], $data['wpsqt_id'], $data['tgl_mulai'], $data['tgl_selesai']
        ) );

}

function sa_jadwal_edit($id, $data){
    global $wpdb;

    $dbtablename = $wpdb->prefix . 'tesonline';

    $wpdb->update( 
        $dbtablename, 
        array('nama'=>$data['nama'], 'wpsqt_id'=>$data['wpsqt_id'], 'tgl_mulai'=>$data['tgl_mulai'], 'tgl_selesai'=>$data['tgl_selesai']), 
        array('id'=>$id)
        );
}

function sa_jadwal_detail($id){
    global $wpdb;

    $dbtablename = $wpdb->prefix . 'tesonline';
    $jadwal = $wpdb->get_row(
        $wpdb->prepare( " SELECT * FROM $dbtablename WHERE id=%d ", $id )
        );

    if(sizeof($jadwal)>0){
        return $jadwal;
    }else{
        return false;
    }

}

function sa_generate_register_id($witelid){
    global $wpdb;
    $kode_witel = str_pad( $witelid , 2, "0", STR_PAD_LEFT);

    $totaluser = 1;
    $kode_urut = str_pad( $totaluser , 4, "0", STR_PAD_LEFT);
    $kode_tgl = date("my");

    $args2 = array(
      'role'         => 'subscriber',
      'meta_key'     => 'tipe_user',
      'meta_value'   => 'pra-avengers',
      'meta_query' => array(
        'relation' => 'AND',
        array(
          'key'     => 'av_witel_id',
          'value'   => $witelid,
          'compare' => '='
          ),
        array(
          'key'     => 'av_register_id',
          'value'   => $kode_tgl,
          'compare' => 'LIKE'
          )

        ),
      'fields' => 'all_with_meta',
      'orderby' => 'user_registered', 
      'order' => 'DESC',
      'number' => 1
      );

    $wp_user_query = new WP_User_Query( $args2 );
    $authors = $wp_user_query->get_results();

    if (!empty($authors)){
        foreach ($authors as $author)
        {
            $latest_reg_id = get_the_author_meta('av_register_id', $author->ID);
            $totaluser = intval(substr($latest_reg_id, 2, 4)) + 1;
            break;
        }
    }else{
        $totaluser = 1;
    }

    $kode_urut = str_pad( $totaluser , 4, "0", STR_PAD_LEFT);
    return $kode_witel . $kode_urut. $kode_tgl;
}

function sa_generate_Username($witelid){
    global $wpdb;
    $kode_witel = str_pad( $witelid , 2, "0", STR_PAD_LEFT);

    $args2 = array(
      'role'         => 'subscriber',
      'meta_key'     => 'tipe_user',
      'meta_value'   => 'pra-avengers',
      'meta_query' => array(
        array(
          'key'     => 'av_witel_id',
          'value'   => $witelid,
          'compare' => '='
          )
        ),
      'fields' => 'all_with_meta',
      'search' => '*'.date("my"),
      'search_columns' => array( 'user_login' )
      );

    $user_query = new WP_User_Query( $args2 );
    $totaluser = $user_query->get_total() + 1;
    $kode_urut = str_pad( $totaluser , 4, "0", STR_PAD_LEFT);
    $kode_tgl = date("my");

    //return $kode_witel . $kode_urut. $kode_tgl;
    $tmp_username = $kode_witel . $kode_urut. $kode_tgl;
    $user_id = username_exists( $tmp_username );

    $n=1;
    while ( $user_id ) {
          $n=1;
          $kode_urut = str_pad( $totaluser+$n , 4, "0", STR_PAD_LEFT);
          //$user_name = strtoupper(substr($username_gen, 0, 8) . rand(1000,9999) );
          $tmp_username = $kode_witel . $kode_urut. $kode_tgl;
          $user_id = username_exists( $tmp_username );
        }

    return $tmp_username;
}

function sa_getAll_witel(){
    global $wpdb;

    $dbtablename = $wpdb->prefix . 'witel';
    $results = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename ORDER BY ID ASC " )
        );

    if(sizeof($results)>0){
        return $results;
    }else{
        return false;
    }
}

function sa_getAll_witel_Admin($tipe_user){
    global $wpdb;

    $dbtablename = $wpdb->prefix . 'witel';
	
	if($tipe_user == 'admin-witel-barat'){
    $results = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename where ID in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25) ORDER BY ID ASC " )
        );
	}
	else if ($tipe_user == 'admin-witel-timur'){
	$results = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename where ID in (26,27,28,29,30,31,32,33,34,35,36,37,28,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61) ORDER BY ID ASC " )
        );
	}
	echo $tipe_user;
	
    if(sizeof($results)>0){
        return $results;
    }else{
        return false;
    }
}

function sa_get_datels($witel_id){
    global $wpdb;

    $dbtablename = $wpdb->prefix . 'datel';
    $results = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename WHERE witel_id=$witel_id ORDER BY ID ASC " )
        );

    if(sizeof($results)>0){
        return $results;
    }else{
        return false;
    }
}

function sa_get_witel($id){
    global $wpdb;

    $dbtablename = $wpdb->prefix . 'witel';
    $result = $wpdb->get_row(
        $wpdb->prepare( " SELECT * FROM $dbtablename WHERE ID=$id " )
        );

    return $result;
    
}

function sa_get_datel($id){
    global $wpdb;

    $dbtablename = $wpdb->prefix . 'datel';
    $result = $wpdb->get_row(
        $wpdb->prepare( " SELECT * FROM $dbtablename WHERE ID=$id " )
        );
    return $result;
}

function sa_generate_CSV($data){
    global $wpdb;
    $dbtablename = $wpdb->prefix . 'wpsqt_all_results';
    $results = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename WHERE item_id=".$data['wpsqt_id']." AND datetaken >= ". strtotime(get_gmt_from_date($data['jadwal_mulai']." 00:00:01")) ." AND datetaken <= ". strtotime(get_gmt_from_date($data['jadwal_selesai'] . " 23:59:59" )) ." ")
        );
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
}

function hasilTesOnline($args){
    global $wpdb;

    $dbtablename1 = $wpdb->prefix . 'wpsqt_all_results';
    $dbtablename2 = $wpdb->prefix . 'users';
    $dbtablename3 = $wpdb->prefix . 'usermeta';
    $sqlorderby = "";
    if($args['sort'] <> false AND $args['sortorder'] <> false){
        if($args['sort'] == 'username')
            $sqlorderby = " ORDER BY A.person_name " .$args['sortorder'];
        if($args['sort'] == 'name')
            $sqlorderby = " ORDER BY D.meta_value " .$args['sortorder'];
        if($args['sort'] == 'witelid')
            $sqlorderby = " ORDER BY C.meta_value " .$args['sortorder'];
        if($args['sort'] == 'datetaken')
            $sqlorderby = " ORDER BY A.datetaken " .$args['sortorder'];
        if($args['sort'] == 'score')
            $sqlorderby = " ORDER BY A.score " .$args['sortorder'];
        if($args['sort'] == 'result')
            $sqlorderby = " ORDER BY A.pass " .$args['sortorder'];
    }

    if($args['witel_id']>0){
        $sqlwitel = "  AND C.meta_value=".$args['witel_id']." ";
    }else{
        $sqlwitel = "";
    }

    $results = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename1 as A 
            LEFT JOIN $dbtablename2 as B ON B.user_login=A.person_name
            LEFT JOIN $dbtablename3 as C ON (C.user_id=B.ID AND C.meta_key='av_witel_id' $sqlwitel ) 
            LEFT JOIN $dbtablename3 as D ON (D.user_id=B.ID AND D.meta_key='first_name') 
            WHERE A.item_id=".$args['wpsqt_id']." 
            AND A.datetaken >= ". strtotime($args['jadwal_mulai']." 00:00:01") ." 
            AND A.datetaken <= ". strtotime($args['jadwal_selesai'] . "23:59:59" ) ." 
            $sqlwitel  $sqlorderby 
            ")
        );

/*
echo $wpdb->prepare( " SELECT * FROM $dbtablename1 as A 
            LEFT JOIN $dbtablename2 as B ON B.user_login=A.person_name
            LEFT JOIN $dbtablename3 as C ON (C.user_id=B.ID AND C.meta_key='av_witel_id' $sqlwitel ) 
            LEFT JOIN $dbtablename3 as D ON (D.user_id=B.ID AND D.meta_key='first_name') 
            WHERE A.item_id=".$args['wpsqt_id']." 
            AND A.datetaken >= ". strtotime($args['jadwal_mulai']." 00:00:01") ." 
            AND A.datetaken <= ". strtotime($args['jadwal_selesai'] . "23:59:59" ) ." 
            $sqlwitel  $sqlorderby 
            ");
*/

    if(sizeof($results)>0){
        return $results;
    }else{
        return false;
    }

}

function sa_getUsers($args){
    global $wpdb;

    $dbtablename1 = $wpdb->prefix . 'users';
    $dbtablename2 = $wpdb->prefix . 'usermeta';

    
    if($args['sort'] <> false AND $args['sortorder'] <> false){
        if($args['sort'] == 'username')
            $sqlorderby = " ORDER BY A.user_login " .$args['sortorder'];
        if($args['sort'] == 'name')
            $sqlorderby = " ORDER BY D.meta_value " .$args['sortorder'];
        if($args['sort'] == 'witelid')
            $sqlorderby = " ORDER BY C.meta_value " .$args['sortorder'];
    }
    

    if($args['witel_id']>0){
        $sqlwitel = " AND C.meta_value='".$args['witel_id']."' "; //" LEFT JOIN $dbtablename2 as C ON (C.user_id=A.ID AND C.meta_value='av_witel_id' AND C.meta_key=".$args['witel_id'].") ";
    }else{
        $sqlwitel = " ";
    }

    $results = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename1 as A 
            LEFT JOIN $dbtablename2 as B ON (B.user_id=A.ID AND B.meta_key='tipe_user' ) 
            LEFT JOIN $dbtablename2 as C ON (C.user_id=A.ID AND C.meta_key='av_witel_id') 
            LEFT JOIN $dbtablename2 as D ON (D.user_id=A.ID AND D.meta_key='first_name') 
            WHERE B.meta_value='pra-avengers' 
            $sqlwitel 
            $sqlorderby 
            ")
        );

    if(sizeof($results)>0){
        return $results;
    }else{
        return false;
    }

}

function sa_getUsersAdminWitel($args){
    global $wpdb;

    $dbtablename1 = $wpdb->prefix . 'users';
    $dbtablename2 = $wpdb->prefix . 'usermeta';

    
    if($args['sort'] <> false AND $args['sortorder'] <> false){
        if($args['sort'] == 'username')
            $sqlorderby = " ORDER BY A.user_login " .$args['sortorder'];
        if($args['sort'] == 'name')
            $sqlorderby = " ORDER BY D.meta_value " .$args['sortorder'];
        if($args['sort'] == 'witelid')
            $sqlorderby = " ORDER BY C.meta_value " .$args['sortorder'];
    }
    

    if($args['witel_id']>0){
        $sqlwitel = " AND C.meta_value in (".$args['witel_id'].") "; //" LEFT JOIN $dbtablename2 as C ON (C.user_id=A.ID AND C.meta_value='av_witel_id' AND C.meta_key=".$args['witel_id'].") ";
    }else{
        $sqlwitel = " ";
    }

    $results = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename1 as A 
            LEFT JOIN $dbtablename2 as B ON (B.user_id=A.ID AND B.meta_key='tipe_user' ) 
            LEFT JOIN $dbtablename2 as C ON (C.user_id=A.ID AND C.meta_key='av_witel_id') 
            LEFT JOIN $dbtablename2 as D ON (D.user_id=A.ID AND D.meta_key='first_name') 
            WHERE B.meta_value='pra-avengers' 
            $sqlwitel 
            $sqlorderby 
            ")
        );
		
		

    if(sizeof($results)>0){
        return $results;
    }else{
        return false;
    }

}

function sa_userhasil($user_login){
    global $wpdb;

    $dbtablename1 = $wpdb->prefix . 'wpsqt_all_results';
    $dbtablename2 = $wpdb->prefix . 'users';
    $dbtablename3 = $wpdb->prefix . 'tesonline';
    $dbtablename4 = $wpdb->prefix . 'wpsqt_quiz_surveys';

    $results = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename1 as A 
            LEFT JOIN $dbtablename2 as B ON B.user_login=A.person_name
            LEFT JOIN $dbtablename3 as C ON A.item_id=C.wpsqt_id 
            LEFT JOIN $dbtablename4 as D ON D.id=C.wpsqt_id 
            WHERE B.user_login='".$user_login."' 
            ORDER BY A.score DESC 
            ")
        );
   
    if(sizeof($results)>0){
        return $results;
    }else{
        return false;
    }

}

function sa_getJadwal( $tanggal=Null ){
    global $wpdb;
    if(is_null($tanggal))
        $tanggal = time();

    $dbtablename = $wpdb->prefix . 'tesonline';

    //echo date("Y-m-d H:i:s", $tanggal);
    //echo $wpdb->prepare( " SELECT * FROM $dbtablename WHERE tgl_mulai <= $tanggal AND tgl_selesai => $tanggal ORDER BY id ASC " . $sqladd );

    $jadwals = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename WHERE tgl_mulai < $tanggal AND tgl_selesai > $tanggal ORDER BY id ASC " . $sqladd )
        );
    
    if(sizeof($jadwals)>0){
        return $jadwals;
    }else{
        return false;
    }
}


function sa_getUser($args){
    global $wpdb;

    $dbtablename1 = $wpdb->prefix . 'users';
    $dbtablename2 = $wpdb->prefix . 'usermeta';
    

    if($args['witel_id']>0){
        $sqlwitel = " AND C.meta_value='".$args['witel_id']."' "; //" LEFT JOIN $dbtablename2 as C ON (C.user_id=A.ID AND C.meta_value='av_witel_id' AND C.meta_key=".$args['witel_id'].") ";
    }else{
        $sqlwitel = " ";
    }

    $results = $wpdb->get_results(
        $wpdb->prepare( " SELECT * FROM $dbtablename1 as A 
            LEFT JOIN $dbtablename2 as B ON (B.user_id=A.ID AND B.meta_key='tipe_user' ) 
            LEFT JOIN $dbtablename2 as C ON (C.user_id=A.ID AND C.meta_key='av_witel_id') 
            LEFT JOIN $dbtablename2 as D ON (D.user_id=A.ID AND D.meta_key='first_name') 
            WHERE B.meta_value='pra-avengers' AND A.user_login='".$args['username']."'
            $sqlwitel 
            ")
        );

    if(sizeof($results)>0){
        return $results;
    }else{
        return false;
    }

}

function sa_getOptions(){
    $saOptions = unserialize( get_option('saOptions') );
    //print_r($saOptions);
    return array(
        'passmark'=>$saOptions['passmark'],
        'pengumuman'=>$saOptions['pengumuman'],
        );

}

function sa_getAdminWitel(){
    global $wpdb;

    $dbtablename1 = $wpdb->prefix . 'users';
    $dbtablename2 = $wpdb->prefix . 'usermeta';
    
    $sqlwitel = " ";

    $results = $wpdb->get_results(
        $wpdb->prepare( " SELECT A.*, B.*, 
            C.meta_value as av_witel_id, D.meta_value as av_datel_id, 
            E.meta_value as first_name, F.meta_value as last_name 
            FROM $dbtablename1 as A 
            LEFT JOIN $dbtablename2 as B ON (B.user_id=A.ID AND B.meta_key='tipe_user' ) 
            LEFT JOIN $dbtablename2 as C ON (C.user_id=A.ID AND C.meta_key='av_witel_id') 
            LEFT JOIN $dbtablename2 as D ON (D.user_id=A.ID AND D.meta_key='av_datel_id') 
            LEFT JOIN $dbtablename2 as E ON (E.user_id=A.ID AND E.meta_key='first_name') 
            LEFT JOIN $dbtablename2 as F ON (F.user_id=A.ID AND F.meta_key='last_name') 
            WHERE B.meta_value='webadmin' 
			order by user_login
            $sqlwitel 
            ")
        );

    if(sizeof($results)>0){
        return $results;
    }else{
        return false;
    }

}

function sa_getDivisiAdminWitel($tipe_user){
    global $wpdb;

    $dbtablename1 = $wpdb->prefix . 'users';
    $dbtablename2 = $wpdb->prefix . 'usermeta';
    if($tipe_user == 'admin-witel-barat'){
    $sqlwitel = "and C.meta_value in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25)";
	}else if ($tipe_user == 'admin-witel-timur'){
	 $sqlwitel = "and C.meta_value in (26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61)";
	}
	
    $results = $wpdb->get_results(
        $wpdb->prepare( " SELECT A.*, B.*, 
            C.meta_value as av_witel_id, D.meta_value as av_datel_id, 
            E.meta_value as first_name, F.meta_value as last_name 
            FROM $dbtablename1 as A 
            LEFT JOIN $dbtablename2 as B ON (B.user_id=A.ID AND B.meta_key='tipe_user' ) 
            LEFT JOIN $dbtablename2 as C ON (C.user_id=A.ID AND C.meta_key='av_witel_id') 
            LEFT JOIN $dbtablename2 as D ON (D.user_id=A.ID AND D.meta_key='av_datel_id') 
            LEFT JOIN $dbtablename2 as E ON (E.user_id=A.ID AND E.meta_key='first_name') 
            LEFT JOIN $dbtablename2 as F ON (F.user_id=A.ID AND F.meta_key='last_name') 
            WHERE B.meta_value='webadmin' 
			 $sqlwitel 
			order by user_login
           
            ")
        );
		
	

    if(sizeof($results)>0){
        return $results;
    }else{
        return false;
    }

}

?>