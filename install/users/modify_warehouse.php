<?php
require_once 'init.php';
if(!securePage($_SERVER['PHP_SELF'])){die();}
if(isset($_POST['edit_row']))
{
	
	$warehouseName=$_POST['warehouseName'];
 	$warehouseTitle=$_POST['warehouseTitle'];
 	$UHV4=$_POST['UHV4'];
 	$UHV2=$_POST['UHV2'];
 	$SDCS=$_POST['SDCS'];
 	echo "----".$warehouseName."------".$warehouseTitle;
 	//$MAC=$_POST['MAC'];
 	//$stationNumber = $_POST['stationNumber']
 	$db = DB::getInstance();
	$query1 = $db->query("UPDATE warehouses SET warehouseTitle = ?,UHV4 = ?, UHV2 = ?, SDCS = ? WHERE warehouseName = ?",[$warehouseTitle,$UHV4,$UHV2,$SDCS,$warehouseName]);
	$result1 = $query1->results();
 	//mysql_query("update warehouses set warehouseTitle='$warehouseTitle' where warehouseName='$warehouseName'");
 	echo "success";
 	exit();
}
if(isset($_POST['delete_row']))
{
 $warehouseName=$_POST['warehouseName'];
 // echo "aaa".$warehouseName;
 //mysql_query("delete from warehouses where id='$warehouseName'");
 $db = DB::getInstance();
	$query1 = $db->query("DELETE FROM warehouses WHERE warehouseName = ?",array($warehouseName));
	$result1 = $query1->results();
 echo "success";
 exit();
}
?>