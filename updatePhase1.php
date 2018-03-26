<?php
require_once 'users/init.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

$json  = $_REQUEST["field1"].$_REQUEST["field2"].$_REQUEST["field3"].$_REQUEST["field4"].$_REQUEST["field5"].$_REQUEST["field6"].$_REQUEST["field7"].$_REQUEST["field8"];
$result = json_decode ($json,true);
$mac_count = 0;
$WHMAC = "";
while ($mac_count <= 5) {
        $WHMAC .= dechex((float)$result['m'][$mac_count]);
        $mac_count++;
}
$i=0;
$RFID = "R";
$rfid_count = 1;
$sdcsAddr_count = 0;
$sdcsCH = 0;
$numberOfsdcsAddr = count($result['p']);
while (($sdcsAddr_count <=$numberOfsdcsAddr-1) and ($numberOfsdcsAddr >0)){
	
while ($rfid_count <=6){
	$sdcsAddr = $result['p'][$sdcsAddr_count]['a'];
	
	
	while ( $i<= 3) {
	# code...

		$RFID .= dechex((float)$result['p'][$sdcsAddr_count]['d'][$rfid_count-1]['r'][$i]);
		$i++;
	}
	$i=0;
	if ($RFID != 'R0000') {
		$sdcsCH = $rfid_count;
		echo $sdcsCH."---sdcsCH------";
		echo $sdcsAddr."---sdcsAddr------";
		$pressure = $result['p'][$sdcsAddr_count]['d'][$rfid_count-1]['p'][0];
		echo $result['p'][$sdcsAddr_count]['d'][$rfid_count-1]['p'][0]."----Pressure------";
		echo $RFID."---RFID"."\n";
		//echo $WHMAC;
		$warehouseName=getWarehouseNameByMACAddr($WHMAC);
		//echo $warehouseName;
		//echo $sdcsAddr;
		//echo $sdcsCH;
		insertRFIDtorfidsTablePhase1($RFID,$pressure,0,0);
		insertRFIDtoStationTablePhase1($RFID,$sdcsAddr,$sdcsCH,$warehouseName);
		echo "aaaaaa";

		
	}
	$RFID = "R";
	
	$rfid_count ++;
}
	$rfid_count = 1;
	$RFID = "R";
	$sdcsAddr_count++;
}

?>