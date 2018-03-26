<?php
require_once 'init.php';
if(!securePage($_SERVER['PHP_SELF'])){die();}
if(isset($_POST['edit_row_g']))
{
      $id=$_POST['id'];  
      $sdcsAddr=$_POST['sdcsAddr']; 
      $thresholdDownP=$_POST['thresholdDownP']; 
      $thresholdUpP=$_POST['thresholdUpP']; 
   $db = DB::getInstance();
   $query1 = $db->query("UPDATE gauges SET sdcsAddr = ?, thresholdDownP = ?, thresholdUpP = ? WHERE id = ?",[$sdcsAddr,$thresholdDownP,$thresholdUpP,$id]);
   $result1 = $query1->results();
   $currentUser = $user->data()->username;
   $currentTime = date('Y-m-d H:i:s');
   $Activity = "edit Gauge in admin_stations.php ";
   $field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
   $db->insert('userActivityLog', $field1); 
   echo "success";
   exit();
}
if(isset($_POST['delete_row_g']))
{

 $id=$_POST['row_id'];
 $warehouseName = $_POST['warehouseName'];
 $db = DB::getInstance();
   $query1 = $db->query("DELETE FROM gauges WHERE id = ?",array($id));
   $result1 = $query1->results();
   $currentUser = $user->data()->username;
   $currentTime = date('Y-m-d H:i:s');
   $Activity = "delete Gauge in admin_stations.php ";
   $field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
   $db->insert('userActivityLog', $field1); 
   
 echo "success";
 exit();
}
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
   $currentUser = $user->data()->username;
   $currentTime = date('Y-m-d H:i:s');
   $Activity = "edit Egun in admin_stations.php ";
   $field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
   $db->insert('userActivityLog', $field1); 
 	echo "success";
 	exit();
}
if(isset($_POST['delete_row']))
{

 $id=$_POST['row_id'];
 $warehouseName = $_POST['warehouseName'];
 //echo "aaa-----".$id;
 $db = DB::getInstance();
	$query1 = $db->query("DELETE FROM stations WHERE id = ?",array($id));
	$result1 = $query1->results();
   $query2 = $db->query("SELECT count(*) as total  FROM stations WHERE warehouseName = ?",array($warehouseName));
   $result2 = $query2->results();
   foreach($result2 as $a){$num = $a->total;}
   $query3 = $db->query("UPDATE warehouses SET stationNumber = ? WHERE warehouseName = ?",[$num,$warehouseName]);
   $result3 = $query3->results();
   $currentUser = $user->data()->username;
   $currentTime = date('Y-m-d H:i:s');
   $Activity = "delete Egun in admin_stations.php ";
   $field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
   $db->insert('userActivityLog', $field1); 
 echo "success";
 exit();
}
if(isset($_POST['button_control_HV']))
{
   $RFID = $_POST['RFID'];
   $value = $_POST['value'];
   $db = DB::getInstance();
   $query1 = $db->query("UPDATE stations SET setHVOn = ? WHERE RFID = ?",[$value,$RFID]);
   $result1 = $query1->results();
   $currentUser = $user->data()->username;
   $currentTime = date('Y-m-d H:i:s');
   $Activity = "Control HV in station.php ";
   $field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
   $db->insert('userActivityLog', $field1); 
}
if(isset($_POST['button_control_Pr']))
{
   $RFID = $_POST['RFID'];
   echo $RIFD;
   $value = $_POST['value'];
   $db = DB::getInstance();
   $query1 = $db->query("UPDATE stations SET setProtectOn = ? WHERE RFID = ?",[$value,$RFID]);
   $result1 = $query1->results();
   $currentUser = $user->data()->username;
   $currentTime = date('Y-m-d H:i:s');
   $Activity = "Control Protect Mode in station.php ";
   $field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
   $db->insert('userActivityLog', $field1);
}
if(isset($_POST['button_control_S']))
{
   $RFID = $_POST['RFID'];
   $value = $_POST['value'];
   $db = DB::getInstance();
   $query1 = $db->query("UPDATE stations SET setStationON = ? WHERE RFID = ?",[$value,$RFID]);
   $result1 = $query1->results();
   $currentUser = $user->data()->username;
   $currentTime = date('Y-m-d H:i:s');
   $Activity = "Control Station in station.php ";
   $field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
   $db->insert('userActivityLog', $field1);
}
if(isset($_POST['edit_row_station']))
{
   $RFID = $_POST['RFID'];
   $PN = $_POST['PN'];
   $Serial = $_POST['Serial'];
   $LPN = $_POST['LPN'];
   $TestDate = $_POST['TestDate'];
   $MFGPressure = $_POST['MFGPressure'];
   $PO = $_POST['PO'];
   $DateInStock = $_POST['DateInStock'];
   $DateShipped = $_POST['DateShipped'];
   $db = DB::getInstance();
   $query1 = $db->query("UPDATE frus SET LPN = ?, PN = ?, Serial = ?, TestDate = ?, MFGPressure = ?, PO = ?, DateInStock = ?, DateShipped = ? WHERE RFID = ?",[$LPN,$PN,$Serial,$TestDate,$MFGPressure,$PO,$DateInStock,$DateShipped,$RFID]);
   $result1 = $query1->results();
   $currentUser = $user->data()->username;
   $currentTime = date('Y-m-d H:i:s');
   $Activity = "Edit Information of station in station.php ";
   $field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
   $db->insert('userActivityLog', $field1);
   
   
   echo "success";
   exit();
}
?>