<?php 
require_once 'users/init.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}


// $MAC = getMACaddrByWarehouseName("USA1");

// foreach ($MAC as $M) {
//     echo $M->MAC;
// }
// $RFID = "100hg";
// $pressure = 100;
// $voltage = 120;
// createRFIDTable("abcde");
// createTemperatureTable("abcd");
// $currentI = 100;
// insertRFIDTableToDatabase("abcd","100","20","30");
// $k = findRFID("1a");

// foreach ($k as $M) {
//     echo $M->Pressure;
// }

// $fk = findRFIDwithStationID("2");
// foreach ($fk as $M) {
//     echo $M->Voltage;
//}
//insertRFIDtorfidsTable("10p");
//insertRFIDtoStationTablePhase1("8391029","5","6","ok");

//createRFIDTable('R123456'); 
//insertRFIDtorfidsTable('R456345',190,200,10);
//findStationID("5","6","ok");
//$json = '{"e":0,"i":{"r": 0,"d":   0},"g":{"a":[1    ],"p":[ 5000            ]},"p":[{"a":1,"d":[{"p":["3.4e-9"       ],"r":[ 42, 14, 63,126]},{"p":[ 3855      ],"r":[250,158, 77,126]},{"p":[   60      ],"r":[  0,  0,  0,  0]},{"p":[   61      ],"r":[  0,  0,  0,  0]},{"p":[   62      ],"r":[  0,  0,  0,  0]},{"p":[   58      ],"r":[  0,  0,  0,  0]}]},{"a":2,"d":[{"p":[   30      ],"r":[ 22,108, 33,158]},{"p":[   37      ],"r":[ 86,160,  3,158]},{"p":[ 2514      ],"r":[166, 61, 53,158]},{"p":[ 2493      ],"r":[214,246, 49,158]},{"p":[ 2495      ],"r":[ 86,160, 17,158]},{"p":[ 2975      ],"r":[102,152,255,157]}]}],"m":[  0, 26,182,  3,  4, 25]}';
//$result = json_decode ($json,true);
//$mac_count = 0;
//$WHMAC = "";
//while ($mac_count <= 5) {
//        $WHMAC .= dechex((float)$result['m'][$mac_count]);
//        $mac_count++;
//}
//$i=0;
//$RFID = "R";
//$rfid_count = 1;
//$sdcsAddr_count = 0;
//$sdcsCH = 0;
//$numberOfsdcsAddr = count($result['p']);
//while (($sdcsAddr_count <=$numberOfsdcsAddr-1) and ($numberOfsdcsAddr >0)){
	
//while ($rfid_count <=6){
//	$sdcsAddr = $result['p'][$sdcsAddr_count]['a'];
	
	
//	while ( $i<= 3) {
	# code...

//		$RFID .= dechex((float)$result['p'][$sdcsAddr_count]['d'][$rfid_count-1]['r'][$i]);
//		$i++;
//	}
//	$i=0;
//	if ($RFID != 'R0000') {
//		$sdcsCH = $rfid_count;
//		//echo $sdcsCH."---sdcsCH------";
//		//echo $sdcsAddr."---sdcsAddr------";
//		$pressure = $result['p'][$sdcsAddr_count]['d'][$rfid_count-1]['p'][0];
//		//echo $result['p'][$sdcsAddr_count]['d'][$rfid_count-1]['p'][0]."----Pressure------";
//		//echo $RFID."---RFID"."\n";
//		//echo $WHMAC;
//		$warehouseName=getWarehouseNameByMACAddr($WHMAC);
//		//echo $warehouseName;
//		echo $sdcsAddr;
//		echo $sdcsCH;
//		insertRFIDtorfidsTablePhase1($RFID,$pressure,0,0);
//		insertRFIDtoStationTablePhase1($RFID,$sdcsAddr,$sdcsCH,$warehouseName);

		
//	}
//	$RFID = "R";
	
//	$rfid_count ++;
//}
///	$rfid_count = 1;
//	$RFID = "R";
//	$sdcsAddr_count++;
//}


//echo $WHMAC."----WHMac";
//$json= '[{"1":{"current":"300","pressure":"3.4e-9","rfid":"R166c219e","time":"2017-05-27T16:48:37","voltage":"200"}},
//{"2":{"current":"0","pressure":"3.4e-9","rfid":"R2ae3f7e","time":"2017-05-07T01:46:08","voltage":"0"}},
//{"3":{"current":"0","pressure":"2495","rfid":"R56a0119e","time":"2017-05-07T01:46:08","voltage":"0"}},
//{"4":{"current":"0","pressure":"37","rfid":"R56a039e","time":"2017-05-07T01:46:08","voltage":"0"}},
//{"5":{"current":"0","pressure":"2975","rfid":"R6698ff9d","time":"2017-05-07T01:46:08","voltage":"0"}},
//{"6":{"current":"0","pressure":"2514","rfid":"Ra63d359e","time":"2017-05-07T01:46:08","voltage":"0"}}]';
//$result = json_decode ($json,true);
//echo $result[1]["2"]["current"];
//for( $i=0; $i< count($result);$i++){
//	$num=$i+1;
	
//	echo $result[$i][$i+1]["pressure"]."\n";
//}

//while(list($key, $val) = each($result))
//{
//	echo "KeyGIDO. $key-----";
//	while(list($key1, $val1) = each($val))
//	{
		//echo "Global ID: ". $key. "=> ". $val1["pressure"] ."\n";
//		echo $key. "=> ". $val1["pressure"] ."\n";
//	}
//}
//insertMACtowarehousesStatusTable("guweg");
//$a = getWarehouseStatusColor("guweg");
//echo $a;
//setHVOff(1);
//setRoughValveOff(1);
//$b = getStationColorStatus("2");
//echo "stationColor".$b."-----";
//setStationIsEmpty("2");
//unsetStationIsEmpty("2");
//for( $i=0; $i< 5;$i++){
//	initializesStationperWarehouse("0 1a b6 3 4 4b",5);
//}
	//initializesStationWithWarehouseName("Israel");
	//initializesStationWithWarehouseName("Shanghai");
	//initializesStationWithWarehouseName("USA1");
	//initializesStationWithWarehouseName("USA2");
	//initializesStationWithWarehouseName("Singapore");
	//initializesStationWithWarehouseName("Fukuoka");
	//initializesStationWithWarehouseName("Tokyo");
	//initializesStationWithWarehouseName("Osaka");
	//initializesStationWithWarehouseName("Seoul");
	//initializesStationWithWarehouseName("Taiwan_HSC");
	//initializesStationWithWarehouseName("Taiwan_TN");
	//initializesStationWithWarehouseName("Amsterdam");
//insertGaugetogaugesTable(1,"abc",5000);
//$RFID = "R166c219e";
//echo "abc";
//stationInStock($RFID);
//checkStatusOOSIngaugeOOSandegunOOS();
//generateAndSendMessageP1P2("a","a","dang.mai@ascenx.com");
//generateAndSendMessageP4("Ra63d359e");
//generateAndSendMessageP3();
//generateAndSendMessageP2("a","a","dang.mai@ascenx.com");
//generateAndSendMessageP2("a","a","dang.mai@ascenx.com");
//generateAndSendMessageP2("a","a","dang.mai@ascenx.com");

//echo strtotime('next wednesday 15 hours 32 minute'); 
//deleteAllDatainDatabase();
$domainName =  $_SERVER['HTTP_HOST'];
$result = substr($domainName, 0, 4);
if($result == "http") echo $domainName."/KTproj/";
else
{
	echo "don't have http";
	echo "http://".$domainName."/KTproj/";
}
?>
