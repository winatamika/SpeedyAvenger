<?php

define('WP_USE_THEMES', false);
/** Loads the WordPress Environment and Template */
require('../wp-blog-header.php');

set_time_limit(0);

$csvFile = "data-aam.csv";
$csvSeparator = ",";
$csvFileLength = filesize($csvFile);

$sql = array();

$handle = fopen($csvFile, "r");
//$csvData = fgetcsv($handle, $csvFileLength, $csvSeparator);
//fclose($handle);
while (($csvData = fgetcsv($handle, $csvFileLength, $csvSeparator)) !== FALSE) {

    $str = array();
    $num = count($csvData);
    //echo "<p> $num fields in line $row: <br /></p>\n";
    //for ($c = 0; $c < $num; $c++) {
    //    $str[] = '"' . addslashes($csvData[$c]) . '"';
    //}
    $pass = explode("@", $csvData[3]);
    $name = explode(" ", $csvData[4]);
    if (sizeof($name) == 1) {
        $firstname = $csvData[4];
        $lastname = "";
    } elseif (sizeof($name) == 2) {
        $firstname = $name[0];
        $lastname = $name[1];
    } elseif (sizeof($name) == 3) {
        $firstname = $name[0] . " " . $name[1];
        $lastname = $name[2];
    } elseif (sizeof($name) == 4) {
        $firstname = $name[0] . " " . $name[1];
        $lastname = $name[2]. " " . $name[3];
    } else {
        $firstname = $csvData[4];
        $lastname = "";
    }

    $sql[] = array(
        "username" => $csvData[3],
        "email" => $csvData[3],
        "password" => $pass[0],
        "firstname" => $firstname,
        "lastname" => $lastname,
    ); //"INSERT INTO photos VALUES (" . implode(",", $str) . ");";
}
fclose($handle);

foreach ($sql as $row) {
    //print_r($row);
    $user = get_user_by( "email", $row["email"] );
    echo wp_update_user(array('ID' => $user->ID, 'first_name' => $row["firstname"], 'last_name' => $row["lastname"]));
    echo "\r\n";
    //$user_id = wp_create_user($row["username"], $row["password"], $row["email"]);
    //wp_insert_user(array('ID' => $user_id, 'first_name' => $row["firstname"], 'last_name' => $row["lastname"]));
    //update_usermeta($user_id, 'tipe_user', 'aam');
}
?>
