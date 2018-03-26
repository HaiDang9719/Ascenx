<?php
require_once 'users/init.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

$json  = $_REQUEST["field1"].$_REQUEST["field2"].$_REQUEST["field3"].$_REQUEST["field4"].$_REQUEST["field5"].$_REQUEST["field6"].$_REQUEST["field7"].$_REQUEST["field8"];
$result = json_decode ($json,true);
$mac_count = 0;
$WHMAC = "";
while ($mac_count <= 5) {
        $WHMAC .= dechex((float)$result['m'][$mac_count])." ";
        $mac_count++;
}
$sdcsAddr_gauges = $result['g']['a'][0];
//echo "----".$sdcsAddr_gauges;
$pressure_gauges = $result['g']['p'][0]/1000000;
//echo "....".$pressure_gauges;
insertGaugetogaugesTable($sdcsAddr_gauges,$WHMAC,$pressure_gauges);
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

	$sdcsCH = $rfid_count;
		echo $sdcsCH."---sdcsCH------";
		echo $sdcsAddr."---sdcsAddr------";
		$pressure = $result['p'][$sdcsAddr_count]['d'][$rfid_count-1]['p'][0];
		echo $result['p'][$sdcsAddr_count]['d'][$rfid_count-1]['p'][0]."----Pressure------";
		echo $RFID."---RFID"."\n";
		//echo $WHMAC;
		$warehouseName=getWarehouseNameByMACAddr($WHMAC);
		// update warehouse Status
		insertMACtowarehousesStatusTable($WHMAC);
		//echo $warehouseName;
		//echo $sdcsAddr;
		//echo $sdcsCH;
		
		insertRFIDtoStationTablePhase1($RFID,$sdcsAddr,$sdcsCH,$warehouseName);

	if ($RFID != 'R0000') {	
		unsetStationIsEmptywithRFID($RFID);
		insertRFIDtorfidsTablePhase1($RFID,convertToTorrPressurePhase1($pressure),0,0);
	}
	echo "aaaaaa";
	$RFID = "R";
	
	$rfid_count ++;
}
	$rfid_count = 1;
	$RFID = "R";
	$sdcsAddr_count++;
}
checkStatusOOSIngaugeOOSandegunOOS();
?>