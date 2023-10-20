<?php
$conn = mysql_connect("localhost","speedyav_user","]oKQuf*)Xz6{") or die ("SERVER DOWN");
$db= mysql_select_db("speedyav_db",$conn) or die("database nggak ada");


$sqllimit= "update wp_users SET uni_hash='', last_update='0000-00-00' where DATE_SUB(last_update,INTERVAL 8 hour) < NOW();";
$querylim= mysql_query($sqllimit,$conn) or die (mysql_error());
if(!$querylim){
echo "gagal";
}
else{
echo "sukses";
}
?>