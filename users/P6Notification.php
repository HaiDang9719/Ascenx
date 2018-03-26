
<?php 
require_once 'init.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

	$currentTime = date('Y-m-d H:i:s');
	echo "runP6";
	$db = DB::getInstance();
	$query1 = $db->query("SELECT * FROM senderEmailSetting");
	$result1 = $query1->results();
	foreach ($result1 as $key) {
		$futureTime = $key->TimeWillSendP6;
		
	}
	
	
	if(strtotime($currentTime)>= strtotime($futureTime))
	{
		generateAndSendMessageP6();
		$query2 = $db->query("SELECT * FROM senderEmailSetting");
	$result2 = $query2->results();
	foreach ($result2 as $key ) {
		$P6_Hour=$key->P6_Hour;
		$P6_Minute=$key->P6_Minute;
	}
		$string ='tomorrow '.$P6_Hour.' hours '.$P6_Minute.' minute'; 

		$futureTime = strtotime($string);

		$timeZone = date_default_timezone_get();
		$aaaa = date('Y-m-d H:i:s',$futureTime);

		$datetime = new DateTime($aaaa);
		$la_time = new DateTimeZone($timeZone);
	
		$datetime->setTimezone($la_time);
		$id = 0;
		
		$FormatDateTime = $datetime->format('Y-m-d H:i:s');
		echo $futureTime."====".strtotime($datetime->format('Y-m-d H:i:s'))."====".$FormatDateTime;
		$query3 = $db->query("UPDATE senderEmailSetting SET TimeWillSendP6 = ? WHERE id = ?",[$FormatDateTime,$id]);
		$result3 = $query3->results();
	}
	

?>
