<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$conn = mysql_connect( 'localhost', 'klaremote', 'klaremote' );
//check location and load database

$location=$_REQUEST["location"];

if($location=="USA"){
    $database = "USA";
}
if($location=="Amsterdam"){
    $database = "Amsterdam";
}
if($location=="Taiwan_TN"){
    $database = "Taiwan_TN";
}
if($location=="Taiwan_HSC"){
    $database = "Taiwan_HSC";
}
if($location=="Fukuoka"){
    $database = "Fukuoka";
}
if($location=="Seoul"){
    $database = "Seoul";
}
if($location=="Tokyo"){
    $database = "Tokyo";
}
if($location=="Dublin"){
    $database = "Dublin";
}
if($location=="Singapore"){
    $database = "Singapore";
}
if($location=="Shanghai"){
    $database = "Shanghai";
}
if($location=="Israel"){
    $database = "Israel";
}

$db = mysql_select_db($database);

$query = "SELECT MAX(time) FROM data2";
$do1 = mysql_query($query,$conn);
$maxtime = mysql_fetch_row($do1);
$string_to_time = strtotime($maxtime[0]);
$fault_time = $string_to_time+20;
$now_time_unix = date("U");
$checking_time = date("U",$string_to_time);
$fault = date("U",$fault_time);
//get time - seconds
$get_time = date("Y-m-d H:i:s",$string_to_time);
$check = "SELECT * FROM data2 WHERE time = '$get_time' ";
$do = mysql_query($check,$conn);
$yeah = mysql_fetch_assoc($do);
$pressure = $yeah['3STATION_P2_2'];
$pressure1 = $yeah['3STATION_P1_2'];
$rfid_tag = $yeah['3STATION_RFID_2'];
if ($rfid_tag == NULL){
    echo "Gray";
}else
if($rfid_tag != "0 0 0 0 ")
{
    if($pressure<1*pow(10,-9)){
        echo "Green";}
    if ($pressure>1*pow(10,-9) && $pressure <2*pow(10,-9)){
        echo "Yellow";}
    if ($pressure>2*pow(10,-9)){
        echo "Red";}
}
else {echo "Gray";}
mysql_free_result($do1);
mysql_free_result($do);
mysql_close($conn);
mysql_close($conn);
mysql_close($conn);
mysql_close($conn);
mysql_close($conn);
mysql_close($conn);

