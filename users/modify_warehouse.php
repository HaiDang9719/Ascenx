<?php
require_once 'init.php';
if(!securePage($_SERVER['PHP_SELF'])){die();}

if(isset($_POST['edit_row_email']))
{
	
	$email=$_POST['email'];
	$password = $_POST['password'];
 	$id=0;
 	
 	$db = DB::getInstance();
	$query1 = $db->query("UPDATE senderEmailSetting SET email = ?,password = ? WHERE id = ?",[$email,$password,$id]);
	$result1 = $query1->results();
	$currentUser = $user->data()->username;
	$currentTime = date('Y-m-d H:i:s');
	$Activity = "edit Sender email Setting in NotificationSetting.php ";
	$field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
	$db->insert('userActivityLog', $field1); 
 	echo "success";
 	exit();
}

if(isset($_POST['edit_row_checkbox']))
{
	
	$P1=$_POST['P1'];
	$P2=$_POST['P2'];
	$P3=$_POST['P3'];
	$P4=$_POST['P4'];
	$P5=$_POST['P5'];
	$P6=$_POST['P6'];
 	$id=0;
 	
 	$db = DB::getInstance();
	$query1 = $db->query("UPDATE senderEmailSetting SET P1 = ?, P2 = ?, P3 = ?, P4 = ?, P5 = ?, P6 = ? WHERE id = ?",[$P1,$P2,$P3,$P4,$P5,$P6,$id]);
	$result1 = $query1->results();
	$currentUser = $user->data()->username;
	$currentTime = date('Y-m-d H:i:s');
	$Activity = "edit Global Enable in NotificationSetting.php ";
	$field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
	$db->insert('userActivityLog', $field1); 
 	echo "success";
 	exit();
}

if(isset($_POST['edit_row_time']))
{
	
	$P2_Time=$_POST['P2_Time'];
	$P3_Week=$_POST['P3_Week'];
	$P3_Day=$_POST['P3_Day'];
	$P3_Hour=$_POST['P3_Hour'];
	$P3_Minute=$_POST['P3_Minute'];
	$P6_Hour=$_POST['P6_Hour'];
	$P6_Minute=$_POST['P6_Minute'];
 	$id=0;
 	
 	$db = DB::getInstance();
 	$query2 = $db->query("SELECT * FROM senderEmailSetting");
	$result2 = $query2->results();
	foreach ($result2 as $key ) {
		$P3_Week_old=$key->P3_Week;
		$P3_Day_old=$key->P3_Day;
		$P3_Hour_old=$key->P3_Hour;
		$P3_Minute_old=$key->P3_Minute;
		$P6_Hour_old=$key->P6_Hour;
		$P6_Minute_old=$key->P6_Minute;
	}
	$query1 = $db->query("UPDATE senderEmailSetting SET P2_Time = ?, P3_Week = ?, P3_Day = ?, P3_Hour = ?, P3_Minute = ?, P6_Hour = ?, P6_Minute = ? WHERE id = ?",[$P2_Time,$P3_Week,$P3_Day,$P3_Hour,$P3_Minute,$P6_Hour,$P6_Minute,$id]);
	$result1 = $query1->results();
	
	if($P3_Week != $P3_Week_old or $P3_Day != $P3_Day_old or $P3_Hour != $P3_Hour_old or $P3_Minute != $P3_Minute_old)
	{
		$week = $P3_Week-1;
		$string ='+'.$week.' week '.'next '.$P3_Day.' '.$P3_Hour.' hours '.$P3_Minute.' minute'; 

		$futureTime = strtotime($string);

		$timeZone = date_default_timezone_get();
		$aaaa = date('Y-m-d H:i:s',$futureTime);

		$datetime = new DateTime($aaaa);
		$la_time = new DateTimeZone($timeZone);
	
		$datetime->setTimezone($la_time);

		//echo $futureTime."====".strtotime($datetime->format('Y-m-d H:i:s'))."====".strtotime($lastTime);
		$FormatDateTime = $datetime->format('Y-m-d H:i:s');

		$query3 = $db->query("UPDATE senderEmailSetting SET TimeWillSendP3 = ? WHERE id = ?",[$FormatDateTime,$id]);
		$result3 = $query3->results();
	}
	if( $P6_Hour != $P6_Hour_old or $P6_Minute != $P6_Minute_old)
	{
			
		$string ='tomorrow '.$P6_Hour.' hours '.$P6_Minute.' minute'; 

		$futureTime = strtotime($string);

		$timeZone = date_default_timezone_get();
		$aaaa = date('Y-m-d H:i:s',$futureTime);

		$datetime = new DateTime($aaaa);
		$la_time = new DateTimeZone($timeZone);
	
		$datetime->setTimezone($la_time);

		//echo $futureTime."====".strtotime($datetime->format('Y-m-d H:i:s'))."====".strtotime($lastTime);
		$FormatDateTime = $datetime->format('Y-m-d H:i:s');

		$query6 = $db->query("UPDATE senderEmailSetting SET TimeWillSendP6 = ? WHERE id = ?",[$FormatDateTime,$id]);
		$result6 = $query6->results();
	}
		
	
	$currentUser = $user->data()->username;
	$currentTime = date('Y-m-d H:i:s');
	$Activity = "edit Times of Checking in NotificationSetting.php ";
	$field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
	$db->insert('userActivityLog', $field1); 
 	echo "success";
 	exit();
}




if(isset($_POST['edit_row_noti']))
{
	
	$WHName=$_POST['WHName_multi'];
	$Priority = $_POST['Priority_multi'];
 	$id=$_POST['id'];
 	echo "----".$Priority;
 	//$MAC=$_POST['MAC'];
 	//$stationNumber = $_POST['stationNumber']
 	$db = DB::getInstance();
	$query1 = $db->query("UPDATE notifycationSetting SET WHName = ?,Priority = ? WHERE id = ?",[$WHName,$Priority,$id]);
	$result1 = $query1->results();
	$currentUser = $user->data()->username;
	$currentTime = date('Y-m-d H:i:s');
	$Activity = "edit Notification routes in NotificationSetting.php ";
	$field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
	$db->insert('userActivityLog', $field1); 
 	//mysql_query("update warehouses set warehouseTitle='$warehouseTitle' where warehouseName='$warehouseName'");
 	echo "success";
 	exit();
}
if(isset($_POST['delete_row_noti']))
{
 $id=$_POST['id'];
 // echo "aaa".$warehouseName;
 //mysql_query("delete from warehouses where id='$warehouseName'");
 $db = DB::getInstance();
	$query1 = $db->query("DELETE FROM notifycationSetting WHERE id = ?",array($id));
	$result1 = $query1->results();
 echo "success";
 exit();
}

if(isset($_POST['edit_row_camera']))
{
	
	$Location=$_POST['WHName_multi'];
	$Link=$_POST['Link'];
 	$id=$_POST['id'];
 	
 	$db = DB::getInstance();
	$query1 = $db->query("UPDATE cameraSetting SET Location = ?, Link = ? WHERE id = ?",[$Location,$Link,$id]);
	$result1 = $query1->results();
	$currentUser = $user->data()->username;
	$currentTime = date('Y-m-d H:i:s');
	$Activity = "edit camera Setting in cameraSettings.php ";
	$field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
	$db->insert('userActivityLog', $field1); 
 	echo "success";
 	exit();
}

if(isset($_POST['delete_row_camera']))
{
 $id=$_POST['id'];
 
 $db = DB::getInstance();
	$query1 = $db->query("DELETE FROM cameraSetting WHERE id = ?",array($id));
	$result1 = $query1->results();
	$currentUser = $user->data()->username;
	$currentTime = date('Y-m-d H:i:s');
	$Activity = "deleta camera in cameraSettings.php ";
	$field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
	$db->insert('userActivityLog', $field1); 
 echo "success";
 exit();
}

if(isset($_POST['edit_row']))
{
	
	$warehouseName=$_POST['warehouseName'];
 	$warehouseTitle=$_POST['warehouseTitle'];
 	$UHV4=$_POST['UHV4'];
 	$UHV2=$_POST['UHV2'];
 	$SDCS=$_POST['SDCS'];
 	$latitude = $_POST['latitude'];
 	$longitude = $_POST['longitude'];
 	$timeZ = $_POST['timeZ'];
 	echo "----".$warehouseName."------".$warehouseTitle;
 	//$MAC=$_POST['MAC'];
 	//$stationNumber = $_POST['stationNumber']
 	$db = DB::getInstance();
	$query1 = $db->query("UPDATE warehouses SET warehouseTitle = ?,UHV4 = ?, UHV2 = ?, SDCS = ?, latitude = ?, longitude = ?, timeZone = ? WHERE warehouseName = ?",[$warehouseTitle,$UHV4,$UHV2,$SDCS,$latitude,$longitude,$timeZ,$warehouseName]);
	$result1 = $query1->results();
	$currentUser = $user->data()->username;
	$currentTime = date('Y-m-d H:i:s');
	$Activity = "edit warehouse in admin_warehouses.php ";
	$field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
	$db->insert('userActivityLog', $field1); 
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
 	$query0 = $db->query("DELETE FROM stations WHERE warehouseName = ?",array($warehouseName));
 	$result0 = $query0->results();
 	$query0 = $db->query("DELETE FROM gauges WHERE WHName = ?",array($warehouseName));
 	$result0 = $query0->results();
	$query1 = $db->query("DELETE FROM warehouses WHERE warehouseName = ?",array($warehouseName));
	$result1 = $query1->results();
	$currentUser = $user->data()->username;
	$currentTime = date('Y-m-d H:i:s');
	$Activity = "delete warehouse in admin_warehouses.php ";
	$field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
	$db->insert('userActivityLog', $field1); 
 echo "success";
 exit();
}
if(isset($_POST['edit_row_flipper']))
{
	
	$id=$_POST['id'];
 	$LowerThreshold = $_POST['LowerThreshold'];
 	$UpperThreshold = $_POST['UpperThreshold'];
 	$timeZ = $_POST['timeZ'];
 	
 	$db = DB::getInstance();
	$query1 = $db->query("UPDATE flippers SET LowerThreshold = ?, UpperThreshold = ?, timeZone = ? WHERE id = ?",[$LowerThreshold,$UpperThreshold,$timeZ,$id]);
	$result1 = $query1->results();
	$currentUser = $user->data()->username;
	$currentTime = date('Y-m-d H:i:s');
	$Activity = "edit flipper in admin_flippers.php ";
	$field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
	$db->insert('userActivityLog', $field1); 
 	//mysql_query("update warehouses set warehouseTitle='$warehouseTitle' where warehouseName='$warehouseName'");
 	echo "success";
 	exit();
}
if(isset($_POST['delete_row_flipper']))
{
 $id=$_POST['id'];
 // echo "aaa".$warehouseName;
 //mysql_query("delete from warehouses where id='$warehouseName'");
 $db = DB::getInstance();
 	$query0 = $db->query("DELETE FROM flippers WHERE id = ?",array($id));
 	$result0 = $query0->results();
	$currentUser = $user->data()->username;
	$currentTime = date('Y-m-d H:i:s');
	$Activity = "delete flipper in admin_flippers.php ";
	$field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
	$db->insert('userActivityLog', $field1); 
 echo "success";
 exit();
}


?>