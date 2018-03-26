<?php
require_once 'init.php';
if(!securePage($_SERVER['PHP_SELF'])){die();}
if(isset($_POST['edit_row']))
{
 	$id=$_POST['id'];  
   	$stationName=$_POST['stationName']; 
   	
   	$pumpType=$_POST['pumpType']; 
   	$pumpAddr=$_POST['pumpAddr']; 
   	$pumpCH=$_POST['pumpCH']; 
   	$sdcsAddr=$_POST['sdcsAddr']; 
   	$sdcsCH=$_POST['sdcsCH']; 
   	$thresholdDownP=$_POST['thresholdDownP']; 
   	$thresholdUpP=$_POST['thresholdUpP']; 
   	$thresholdUpI=$_POST['thresholdUpI']; 
   	$thresholdDownI=$_POST['thresholdDownI']; 
   	
 	//echo "----".$warehouseName."------".$warehouseTitle;
 	//$MAC=$_POST['MAC'];
 	//$stationNumber = $_POST['stationNumber']
 	$db = DB::getInstance();
	$query1 = $db->query("UPDATE stations SET stationName = ?, pumpType = ?, pumpAddr = ?, pumpCH = ?, sdcsAddr = ?, sdcsCH = ?, thresholdDownP = ?, thresholdUpP = ?, thresholdUpI = ?, thresholdDownI = ? WHERE id = ?",[$stationName,$pumpType,$pumpAddr,$pumpCH,$sdcsAddr,$sdcsCH,$thresholdDownP,$thresholdUpP,$thresholdUpI,$thresholdDownI,$id]);
	$result1 = $query1->results();
 	echo "success";
 	exit();
}
if(isset($_POST['delete_row']))
{

 $id=$_POST['row_id'];
 //echo "aaa-----".$id;
 $db = DB::getInstance();
	$query1 = $db->query("DELETE FROM stations WHERE id = ?",array($id));
	$result1 = $query1->results();
 echo "success";
 exit();
}
?>