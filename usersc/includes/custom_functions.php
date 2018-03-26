<?php
/*
UserSpice 4
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//Put your custom functions in this file and they will be automatically included.

//bold("<br><br>custom helpers included");

//*** FUNCTIONS TO SUPPORT FLIPPER *****///
function getDomainName()
{
	$domainName =  $_SERVER['HTTP_HOST'];
	$result = substr($domainName, 0, 4);
	if($result == "http") $MydomainName = $domainName."/KTproj/";
	else
	{
		//echo "don't have http";
		$MydomainName = "http://".$domainName."/KTproj/";
	}
	//$MydomainName = "http://essdepots.com:82/KTproj/";
	return $MydomainName;
}
function debugToConsole($msg) {
       $msg = str_replace('"', '\\"', $msg); // Escaping double quotes 
        echo "<script>console.log(\"$msg\")</script>";
}

function createTemperatureTable($tablename)
{
	 $db = DB::getInstance();

	$value = '';
	$sql = "CREATE TABLE IF NOT EXISTS $tablename (`Time` DATETIME NOT NULL, `Temperature` DOUBLE NULL, PRIMARY KEY (`Time`)) ENGINE = InnoDB";
	
	if (!$db->query($sql, $value)->error())
	{
	
		return true;
	}

	return false;
	
}

function insertTemperatureToDatabase($tablename, $temperature)
{
	$db = DB::getInstance();


	if(!$db->tableExists($tablename))
	{
		createTemperatureTable($tablename);
	}
	
	$updateDate = date('Y-m-d H:i:s');
	$dataArray = array('Time'=> $updateDate, 'Temperature' =>$temperature);
	
	$db->insert($tablename, $dataArray);
}


/**** FUNCTIONS TO SUPPORT IOT EGUN *****/


//Retrieve information for all users
function fetchAllWarehouses() {
	$db = DB::getInstance();
	$query = $db->query("SELECT * FROM warehouses");
	$results = $query->results();
	return ($results);
}

// Retrieve information from warehouse
function fetchAllStations($warehouseName){
	$db = DB::getInstance();
	$query = $db->query("SELECT * FROM stations WHERE warehouseName = ?",array($warehouseName));
	$results = $query->results();
	return ($results);
}
//Delete warehouses 
function deleteWarehouses($warehouses) {
	$db = DB::getInstance();
	$i = 0;
	foreach($warehouses as $warehousename){
		$query1 = $db->query("DELETE FROM warehouses WHERE warehousename = ?",array($warehousename));
		$i++;
	}
	return $i;
}


// get warehouseName by MAC addr

function getWarehouseNameByMACAddr($MAC)
{
	$db = DB::getInstance();
	$query1 = $db->query("SELECT warehouseName FROM warehouses WHERE MAC = ?",array($MAC));
	$result1 = $query1->results();
	foreach($result1 as $a){ $num = $a->warehouseName;echo $num;}
	return $num;
	//echo $query->results();

}

function getMACaddrByWarehouseName($Name)
{

	 $db = DB::getInstance();

	
	$sql = "SELECT * FROM warehouses WHERE warehouseName = ? ";
	$query = $db ->get('warehouses',['warehouseName','=',$Name],false);

	return $query->results();
}

// create RFID Table to Database
function createRFIDTable($tablename)
{
         $db = DB::getInstance();

        $value = '';
        $sql = "CREATE TABLE IF NOT EXISTS $tablename (
  `Time` DATETIME NOT NULL,
  `Pressure` DOUBLE NULL,
  `Voltage` DOUBLE NULL,
  `Current` DOUBLE NULL,
  PRIMARY KEY (`Time`),
  UNIQUE INDEX `Time_UNIQUE` (`Time` ASC))
ENGINE = InnoDB";

        if (!$db->query($sql, $value)->error())
        {

                return true;
        }

	return false;

}


// Insert data to RFID Table in Database phase 1
function insertRFIDTableToDatabasePhase1($RFID,$pressure,$voltage,$currentI)
{
	$db = DB::getInstance();
	//if(!$db->tableExists($RFID))
	//{
	//	createRFIDTable($RFID);
	//}
	$updateDate = date('Y-m-d H:i:s');
	$dataArray = array('Time'=> $updateDate,'Pressure' =>$pressure,'Voltage'=>$voltage,'Current'=>$currentI);
	
	$db->insert($RFID, $dataArray);
	

}

// Insert data to RFID Table in Database phase 2
function insertRFIDTableToDatabasePhase2($Time,$RFID,$pressure,$voltage,$currentI)
{
	$db = DB::getInstance();
	//if(!$db->tableExists($RFID))
        //{
	//	createRFIDTable($RFID);
        //}
        //$updateDate = date('Y-m-d H:i:s');
        $dataArray = array('Time'=> $Time,'Pressure' =>$pressure,'Voltage'=>$voltage,'Current'=>$currentI);

        $db->insert($RFID, $dataArray);
}

//Find RFID Table base on RFID
function findRFID($RFID)
{
	$db = DB::getInstance();
	$query = $db->query("SELECT * FROM $RFID");
        return $query->results();
}


//Find RFID Table base on StationID
function findRFIDwithStationID($StationID)
{
	$db = DB::getInstance();
	$query1 = $db->query("SELECT RFID FROM stations WHERE id=?",array($StationID));
	//$query1 = $db ->get('stations',['id','=',$StationID],false);
	$results=$query1->results();
	foreach($results as $a){ $rfid=$a->RFID; return(findRFID($rfid));}
}

//Find StationID 
function findStationID($sdcsAddr,$sdcsCH,$warehouseName)
{
	$db = DB::getInstance();
	$query1 = $db->query("SELECT id FROM stations WHERE sdcsAddr = ? AND sdcsCH = ? AND warehouseName = ?  ",[$sdcsAddr,$sdcsCH,$warehouseName]);
        $result1 = $query1->results();
        foreach($result1 as $a){ $num = $a->id;echo $num;}

}

//Insert status InStock of Station with RFID
function stationInStock($RFID)
{
	$db=DB::getInstance();
	$updateDate = date('Y-m-d H:i:s');
	$status = "Arrived";
	$field = array('RFID'=>$RFID,'Time'=>$updateDate,'status'=>$status);
    $db ->insert('EgunTransaction',$field);
    $field2 = array('DateInStock'=>$updateDate,'RFID'=>$RFID);
    $db->insert('frus',$field2);
}


//Insert RFID to rfids Table phase 1
function insertRFIDtorfidsTablePhase1($RFID,$pressure,$voltage,$currentI){
	$db = DB::getInstance();
	$sql = $db->query("SELECT count(*) as total  FROM rfids WHERE RFID = ?",array($RFID));
	$result1 = $sql->results();
	foreach($result1 as $a){$num = $a->total;}
	if ($num ==0){
	$field = array('RFID'=>$RFID);
        $db ->insert('rfids',$field);
	createRFIDTable($RFID);
	insertRFIDTableToDatabasePhase1($RFID,$pressure,$voltage,$currentI);
	stationInStock($RFID);
	}else{
		insertRFIDTableToDatabasePhase1($RFID,$pressure,$voltage,$currentI);
	}

	//Notification Setting
	$updateDate = date('Y-m-d H:i:s');
	$query1= $db->query("SELECT thresholdUpP FROM stations WHERE RFID =?",array($RFID));
	$result2 = $query1->results();
	foreach ($result2 as $key) {
		$thresholdUpP_s = $key->thresholdUpP;
	}
	if($pressure>$thresholdUpP_s){
		$query_WH = $db->query("SELECT warehouseName FROM stations WHERE RFID = ?",array($RFID));
		$result_WH = $query_WH->results();
		foreach ($result_WH as $key ) {$WHName_noti = $key->warehouseName;}
		$link_noti = getDomainName()."users/station.php?RFID=$RFID";
		$query3 = $db->query("SELECT count(*) as total FROM egunOOS WHERE RFID = ?", array($RFID));
		$result3 = $query3->results();
		foreach($result3 as $a){$num = $a->total;}
		if($num ==0){
			$field3 = array('RFID'=>$RFID,'Time'=>$updateDate,'Pressure'=>$pressure,'StartOOS'=>$updateDate,'Location'=>$WHName_noti,'Link'=>$link_noti);
			$db->insert('egunOOS',$field3);
		}else{
			$query1 = $db->query("UPDATE egunOOS SET Time = ?, Pressure = ? WHERE RFID = ?",[$updateDate,$pressure,$RFID]);
   			$result1 = $query1->results();
		}
	}

}

// Insert RFID to rfids Table phase 2
function insertRFIDtorfidsTablePhase2($Time,$RFID,$pressure,$voltage,$currentI){
        $db = DB::getInstance();
        $sql = $db->query("SELECT count(*) as total  FROM rfids WHERE RFID = ?",array($RFID));
        $result1 = $sql->results();
        foreach($result1 as $a){$num = $a->total;}
        if ($num ==0){
        $field = array('RFID'=>$RFID);
        $db ->insert('rfids',$field);
        createRFIDTable($RFID);
        insertRFIDTableToDatabasePhase2($Time,$RFID,$pressure,$voltage,$currentI);
        stationInStock($RFID);
        }else{
              	insertRFIDTableToDatabasePhase2($Time,$RFID,$pressure,$voltage,$currentI);
        }


}

//Override RFID in stations Table
function insertRFIDtoStationTablePhase1($RFID,$sdcsAddr,$sdcsCH,$warehouseName)
{
	$db = DB::getInstance();
	$isPhase1 = 1;
	$query1 = $db->query("SELECT * FROM stations WHERE sdcsAddr = ? AND sdcsCH = ? AND warehouseName = ?  ",[$sdcsAddr,$sdcsCH,$warehouseName]);
	$result1 = $query1->results();
	foreach($result1 as $a){ $num = $a->id;$count = $a->count;}
	
	if($RFID == "R0000" and $count <5)
	{
		$count = $count+1;
		$field = array('count'=>$count);
	$db->update('stations',$num,$field);
	}
	else if($RFID == "R0000" and $count >2 ){
		$field = array('RFID'=>$RFID,'sdcsAddr'=>$sdcsAddr,'sdcsCH'=>$sdcsCH,'warehouseName'=>$warehouseName,'isPhase1'=>$isPhase1);
	$db->update('stations',$num,$field);
	}
	else{
		$count = 0;
		$field = array('RFID'=>$RFID,'sdcsAddr'=>$sdcsAddr,'sdcsCH'=>$sdcsCH,'warehouseName'=>$warehouseName,'isPhase1'=>$isPhase1,'count'=>$count);
	$db->update('stations',$num,$field);
	}
	

}


// insert MAC to warehousesStatus Table. If MAC is not exist in warehousesStatus Table, this function will create MAC this MAC column and 
// insert time to latestTimeStamp column, else if MAC is exist, this function will override time in latestTimeStamp column.
function insertMACtowarehousesStatusTable($MAC)
{
	$db = DB::getInstance();
	$query1 = $db->query("SELECT count(*) as total FROM warehousesStatus WHERE MAC = ?", array($MAC));
	$result1 = $query1->results();
	foreach ($result1 as $key) {
		# code...
		$num = $key->total;
	}
	$updateDate = date('Y-m-d H:i:s');
	if ($num ==0){
		$field = array('latestTimeStamp'=>$updateDate,'MAC'=>$MAC);
		$db ->insert('warehousesStatus',$field);
	}else{
		$query2 = $db->query("UPDATE warehousesStatus SET latestTimeStamp = ? WHERE MAC = ?",[$updateDate,$MAC]);
		$result2 = $query2->results();
	}
}

// this function will return the status color of warehouse base on MAC. 
// function getWarehouseStatusColor($MAC)
// {
// 	$db = DB::getInstance();
// 	$query1 = $db->query("SELECT latestTimeStamp FROM warehousesStatus WHERE MAC = ?", array($MAC));
// 	$result1 = $query1->results();
// 	$ho = 0;
// 	foreach ($result1 as $key ) {
// 		$ho = $key->latestTimeStamp;
// 	}
// 	$updateDate = date('Y-m-d H:i:s');
// 	echo $ho."------";
// 	echo $updateDate."-----------";
// 	$hour = (strtotime($updateDate)-strtotime($ho))/3600;
// 	echo $hour."---------";
// 	if ($hour < "24" )
// 	{
// 		return "green";
// 	}
// 	else if ($hour >= "24" and $hour < "48" )
// 	{
// 		return "yellow";
// 	}
// 	else if($hour >= "48")
// 	{
// 		return "gray";
// 	}
// }

function getWarehouseStatusColor($MAC)
{
	$db = DB::getInstance();
	$query1 = $db->query("SELECT latestTimeStamp FROM warehousesStatus WHERE MAC = ?", array($MAC));
	$result1 = $query1->results();

	$ho="";
	foreach ($result1 as $key ) {
		$ho = $key->latestTimeStamp;
		//echo $ho."--hoohoho----";
	}
	$updateDate = date('Y-m-d H:i:s');
	
	//echo $updateDate."-----------";
	$hour = (strtotime($updateDate)-strtotime($ho))/3600;
	//echo $hour."---------";
	if ($hour < "24" )
	{
		return "green";
	}
	else if ($hour >= "24" and $hour < "48" )
	{
		return "yellow";
	}
	else if($hour >= "48")
	{
		return "gray";
	}
}

// set HV On
function setHVOn($id)
{
	$db = DB::getInstance();
	$HV = 1;
	$query1 = $db->query("UPDATE stations SET setHVOn = ? WHERE id = ?",[$HV,$id]);
	$result1 = $query1->results();
}

// set HV Off
function setHVOff($id)
{
	$db = DB::getInstance();
	$HV = 0;
	$query1 = $db->query("UPDATE stations SET setHVOn = ? WHERE id = ?",[$HV,$id]);
	$result1 = $query1->results();
}

// set Valve On
function setRoughValveOn($id)
{
	$db = DB::getInstance();
	$Valve = 1;
	$query1 = $db->query("UPDATE stations SET setRoughValveOn = ? WHERE id = ?",[$Valve,$id]);
	$result1 = $query1->results();
}

// set Rough Off
function setRoughValveOff($id)
{
	$db = DB::getInstance();
	$Valve = 0;
	$query1 = $db->query("UPDATE stations SET setRoughValveOn = ? WHERE id = ?",[$Valve,$id]);
	$result1 = $query1->results();
}


//
function insertStationPackageTostationsTable()
{
	
}

function convertToTorrPressurePhase1($digitalValue)
{
    $voltage = 2.5/((2**14)-1)*$digitalValue*2;
     $pressure = 10**(-11)*10**(6/5*$voltage);

     	return $pressure;
}


// SUPPORT FUNCTIONS OF "STATIONS" TABLE

//Function to return status color of a station, defined by StationID (primary key of table stations)
// Function to check if "isEmpty = true", return "gray", otherwise continue to check Status color
// Status color is definded by comparing latest pressure level to Pressure threshold in table stations
// Let's call pressure "P"
// Let's call pressure upper threshold is "UP"
// Let's call pressure lower threshold is "LP"
// "green" : P < LP
// "yellow": LP =< P =< UP
// "red": P > UP

function getStationColorStatus($StationID)
{
	$db = DB::getInstance();
	$query1 = $db->query("SELECT isEmpty, thresholdUpP,thresholdDownP,RFID FROM stations WHERE id = ?",array($StationID));
	$result1 = $query1->results();
	$isEmpty="";
	foreach ($result1 as $key ) {
		$isEmpty = $key->isEmpty;
		$UP = $key->thresholdUpP;
		$LP = $key->thresholdDownP;
		$RFID = $key->RFID;
		//echo $isEmpty."isEmpty";
		//echo $UP."UPUPUPUP";
		//echo $LP."LPLPLP";
		echo $RFID."RFID";
	}
	$query2 = $db->query("SELECT Pressure FROM ".$RFID." ORDER BY Time DESC LIMIT 1");
	$result2 = $query2->results();
	foreach ($result2 as $key) {
		$P = $key->Pressure;
		//echo $P."pressure";
	}
	if ($isEmpty == "1") return "gray";
	else if ($P < $LP) return "green";
	else if ($P >= $LP and $P <= $UP) return "yellow";
	else if ($P > $UP) return "red";
}


// set isEmpty to true in table stations per StationID
function setStationIsEmpty($StationID)
{
	$db = DB::getInstance();
	$value = 1;
	$query1 = $db->query("UPDATE stations SET isEmpty = ? WHERE id = ?",[$value,$StationID]);
	$result1 = $query1->results();
}

// set isEmpty to false in table stations per StationID
function unsetStationIsEmpty($StationID)
{
	$db = DB::getInstance();
	$value = 0;
	$query1 = $db->query("UPDATE stations SET isEmpty = ? WHERE id = ?",[$value,$StationID]);
	$result1 = $query1->results();
}
function unsetStationIsEmptywithRFID($RFID)
{
	$db = DB::getInstance();
	$value = 0;
	$query1 = $db->query("UPDATE stations SET isEmpty = ? WHERE RFID = ?",[$value,$RFID]);
	$result1 = $query1->results();
}

// Auto generate a specified number of stations for a warehouse. 
function initializesStationperWarehouse($WHMAC, $numberOfStations)
{
	$db = DB::getInstance();
	$warehouseName = getWarehouseNameByMACAddr($WHMAC);
	$i = 0;
	while ($i < $numberOfStations) {
		$updateDate = date('Y-m-d H:i:s');
		$dataArray = array('warehouseMAC'=> $WHMAC, 'Time'=> $updateDate, 'warehouseName' =>$warehouseName);
		$db->insert('stations', $dataArray);
	
		$i++;
	}
}

//generate stations in stations number with warehouseName
function initializesStationWithWarehouseName($warehouseName){
	$db = DB::getInstance();
	$query1 = $db->query("SELECT stationNumber, MAC FROM warehouses WHERE warehouseName = ?", array($warehouseName));
	$result1 = $query1->results();
	foreach ($result1 as $key) {
		$stationNumber = $key->stationNumber;
		$MAC = $key->MAC;
		echo $stationNumber;
		echo $MAC;
	}
	initializesStationperWarehouse($MAC,$stationNumber);
}


function insertGaugetogaugesTable($sdcsAddr,$WHMAC,$Pressure){
	$db = DB::getInstance();
	$updateDate = date('Y-m-d H:i:s');
	$WHName = getWarehouseNameByMACAddr($WHMAC);
	$sql = $db->query("SELECT count(*) as total  FROM gauges WHERE sdcsAddr = ? AND WHMAC = ?",[$sdcsAddr,$WHMAC]);
	$result1 = $sql->results();
	foreach($result1 as $a){$num = $a->total;}
	if ($num ==0){
	$field = array('sdcsAddr'=>$sdcsAddr,'WHName'=>$WHName,'WHMAC'=>$WHMAC,'Time'=>$updateDate);
        $db ->insert('gauges',$field);
    $query2=$db->query("SELECT id FROM gauges WHERE sdcsAddr = ? AND WHMAC = ?",[$sdcsAddr,$WHMAC]);
    $result2=$query2->results();
    foreach ($result2 as $key) {
    	$id = $key->id;
    }
    $name = "G".$id;
	createGaugesTable($name);
	$field1 = array('Time'=>$updateDate,'Pressure'=>$Pressure);
	$db->insert($name,$field1);
	}else{
		$query2=$db->query("SELECT id FROM gauges WHERE sdcsAddr = ? AND WHMAC = ?",[$sdcsAddr,$WHMAC]);
    	$result2=$query2->results();
    	foreach ($result2 as $key) {
    		$id = $key->id;
    	}
    	$field2 = array('Time'=>$updateDate,'WHName'=>$WHName);
    	$db->update('gauges',$id,$field2);
    	$name = "G".$id;
		$field1 = array('Time'=>$updateDate,'Pressure'=>$Pressure);
		$db->insert($name,$field1);
	}

	//Notification Settings
	$query2=$db->query("SELECT id FROM gauges WHERE sdcsAddr = ? AND WHMAC = ?",[$sdcsAddr,$WHMAC]);
    $result2=$query2->results();
    foreach ($result2 as $key) {
    		$id = $key->id;
    }
	$query3 = $db->query("SELECT thresholdUpP FROM gauges WHERE id = ?",array($id));
	$result3 = $query3->results();
	foreach ($result3 as $key) {
		$thresholdUpP_g = $key->thresholdUpP;
	}
	if($Pressure > $thresholdUpP_g){
		$query_WH = $db->query("SELECT WHName FROM gauges WHERE id = ?", array($id));
		$result_WH = $query_WH->results();
		foreach ($result_WH as $key ) {$WHName_noti = $key->WHName;}
		$link_noti = getDomainName()."users/gauge.php?GID=$id";
		$query3 = $db->query("SELECT count(*) as total FROM gaugeOOS WHERE id = ?", array($id));
		$result3 = $query3->results();
		foreach($result3 as $a){$num = $a->total;}
		if($num ==0){
			$field3 = array('id'=>$id,'Time'=>$updateDate,'Pressure'=>$Pressure,'StartOOS'=>$updateDate,'Location'=>$WHName_noti,'Link'=>$link_noti);
			$db->insert('gaugeOOS',$field3);
		}else{
			$field3 = array('Time'=>$updateDate,'Pressure'=>$Pressure);
			$db->update('gaugeOOS',$id,$field3);
		}
	}
}


function createGaugesTable($tablename){
	 $db = DB::getInstance();

        $value = '';
        $sql = "CREATE TABLE IF NOT EXISTS $tablename (
  `Time` DATETIME NOT NULL,
  `Pressure` DOUBLE NULL,
  PRIMARY KEY (`Time`),
  UNIQUE INDEX `Time_UNIQUE` (`Time` ASC))
ENGINE = InnoDB";

        if (!$db->query($sql, $value)->error())
        {

                return true;
        }

	return false;
}


function checkStatusOOSIngaugeOOSandegunOOS()
{
	$db = DB::getInstance();
	$currentTime = date('Y-m-d H:i:s');
	$query3 = $db->query("SELECT * FROM gaugeOOS");
	$result3 = $query3->results();
	foreach($result3 as $key){
		$TimeGauge = $key->Time;
		$minute = (strtotime($currentTime)-strtotime($TimeGauge))/60;
		if($minute > 10){
			$GID = $key->id;
			$query1 = $db->query("DELETE FROM gaugeOOS WHERE id = ?",array($GID));
   			$result1 = $query1->results();
		}
	}
	$query2 = $db->query("SELECT * FROM egunOOS");
	$result2 = $query2->results();
	foreach ($result2 as $key) {
		$TimeEgun = $key->Time;
		$minute = (strtotime($currentTime)-strtotime($TimeEgun))/60;
		if($minute > 10){
			$RFID = $key->RFID;
			$query1 = $db->query("DELETE FROM egunOOS WHERE RFID = ?",array($RFID));
   			$result1 = $query1->results();
		}
	}
}

function doubletoMyString($value)
      {
            // convert 0.0000000022 to string 2.2E-9
            // structure  (x E- y) 
            // string value Svalue

            $Svalue="";
            $x = 0;
            $y = 0;
            for( $i = 11; $i>=5 ; $i-- ) 
            {
                   $x = $value * pow(10,$i);
            
                  if ($x  < 10)
                  {
                  $y= $i;
                  $formatted = number_format($x, 2, '.', ',');
                  $Svalue.= "$formatted";
                  $Svalue.="E-";
                  $Svalue.="$y Torr" ;
                  return $Svalue;
                  }
            }      
      return $Svalue;
      }


function generateAndSendMessageP1()
{
	
	//$mail->SmtpClose();

	set_time_limit(0);
	$currentTime = date('Y-m-d H:i:s');
	$mail = new PHPMailer();
	$mail->IsSMTP();  
    $mail->Host = "smtp.gmail.com"; 
    $mail->Port = 465;   
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $db = DB::getInstance();
    $query3 = $db->query("SELECT * FROM senderEmailSetting");
	$result3 = $query3->results();
	foreach ($result3 as $b) {
		$username = $b->email;
		$password = $b->password;
		
	}
    $mail->Username = $username;  
    $mail->Password = $password;  
    $mail->AltBody = " "; 
    $mail->From = $username;
    $mail->FromName = 'ESS Alert System Notification'; 
$query_P1 = $db->query("SELECT * FROM senderEmailSetting");
$result_P1 = $query_P1->results();
foreach ($result_P1 as $e) {
	if($e->P1 == "checked")
	{
		$sql = $db->query("SELECT count(*) as total  FROM egunOOS");
		$result1 = $sql->results();
		foreach($result1 as $a){$numEgun = $a->total;}
		$sql = $db->query("SELECT count(*) as total  FROM gaugeOOS");
		$result1 = $sql->results();
		foreach($result1 as $a){$numGauge = $a->total;}
		
		if($numGauge!=0 or $numEgun!=0){	
			if($numGauge!=0 and $numEgun!=0){
				$title = "ESS - P1 - egunOOS - gaugeOOS";
			}
			else if($numGauge==0 and $numEgun!=0){
				$title = "ESS - P1 - egunOOS";
			}
			else if($numGauge!=0 and $numEgun==0){
				$title = "ESS - P1 - gaugeOOS";
			}
			
			$query1 = $db->query("SELECT * FROM notifycationSetting");
			$result1 = $query1->results();
			foreach ($result1 as $a) {
				$priority_string = explode(",", $a->Priority);
				for($j=0;$j<count($priority_string);$j++)
				{
					if($priority_string[$j]=="1")
					{
						$warehouse=array();
						$warehouse_string = explode(",", $a->WHName);
						for($i=0;$i<count($warehouse_string);$i++)
            				{
                				$query2 = $db->query("SELECT count(*) as total FROM egunOOS WHERE Location = ?",array($warehouse_string[$i]));
                				$result2 = $query2->results();
                				foreach ($result2 as $b) {
                					$num1 = $b->total;
                			}
                				$query3 = $db->query("SELECT count(*) as total FROM gaugeOOS WHERE Location = ?",array($warehouse_string[$i]));
                				$result3 = $query3->results();
                				foreach ($result3 as $c) {
                					$num2 = $c->total;
                				}
                				if($num1 !=0 or $num2 !=0)
                				{
                					array_push($warehouse, $warehouse_string[$i]);
                				}
							}
			
							
							//echo count($warehouse);
							var_dump($warehouse);

							if(count($warehouse) != 0){
							$email=$a->email;
							echo $a->user;
							echo $a->email;
							
							
							$wh = implode("', '", $warehouse);
							echo "----".$wh."------";
							//echo $email;
							$db = DB::getInstance();
							$query1 = $db->query("SELECT * FROM egunOOS WHERE Location IN ('$wh')");
							$result1 = $query1->results();
							$query2 = $db->query("SELECT * FROM gaugeOOS WHERE Location IN ('$wh')");
							$result2 = $query2->results();
	
							$query4 = $db->query("SELECT * FROM egunOOS WHERE Location IN ('$wh') ORDER BY StartOOS DESC LIMIT 1");
	$result4 = $query4->results();
	foreach ($result4 as $d) {
		$latestTimeEgun = $d->StartOOS;
	}
	$query4 = $db->query("SELECT * FROM gaugeOOS WHERE Location IN ('$wh') ORDER BY StartOOS DESC LIMIT 1");
	$result4 = $query4->results();
	foreach ($result4 as $d) {
		$latestTimeGauge = $d->StartOOS;
	}
	$minuteEgun = (strtotime($currentTime)-strtotime($latestTimeEgun))/60;
	$minuteGauge = (strtotime($currentTime)-strtotime($latestTimeGauge))/60;
	echo "currentTime: ".strtotime($currentTime);
	echo "latestTimeEgun: ".strtotime($latestTimeEgun);
	echo "minuteEgun: ".$minuteEgun;
	echo "minuteGauge: ".$minuteGauge;
	if($minuteEgun <=2 or $minuteGauge <=2)
	{
	
	
    $mail->clearAddresses();
	$mail->AddAddress($email);
	
	$mail->Subject = $title;

	$mail->IsHTML(true);
	$mail->Body = '<html><body>';
	$mail->Body .= "<h3>Information about Egun Out Of Spec </h3>";
	$mail->Body .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
	$mail->Body .= '<table class="table table-border">';
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='background: #eee;'><strong>RFID</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>stationName</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Time</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Pressure</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Voltage</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Current</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>StartOOS</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Location</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Link</strong></th>";
	$mail->Body .= "</tr>";
	
	foreach ($result1 as $key) {
		$minuteE = (strtotime($currentTime)-strtotime($key->StartOOS))/60;
		if($minuteE <= 2)
		{
			$query_sN = $db->query("SELECT stationName FROM stations WHERE RFID = ?",array($key->RFID));
		$result_sN = $query_sN->results();
		foreach ($result_sN as $key1) {$stationName = $key1->stationName;}

	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->RFID."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$stationName."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Time."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".doubletoMyString($key->Pressure)."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Voltage."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Current."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->StartOOS."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Location."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong><a href=".$key->Link.">Click Here!</a></strong></th>";
	$mail->Body .= "</tr>";
		}		
			
		
		
	}
	$mail->Body .= "</table>";
	$mail->Body .= "<h3>Information about Gauge Out Of Spec </h3>";
	$mail->Body .= '<table class="table table-hover table-list-search">';
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='background: #eee;'><strong>id</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Time</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Pressure</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>StartOOS</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Location</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Link</strong></th>";
	$mail->Body .= "</tr>";
	foreach ($result2 as $key) {
		$minuteG = (strtotime($currentTime)-strtotime($key->StartOOS))/60;
		if($minuteG <= 2)
		{
			$mail->Body .= "<tr>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->id."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Time."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Pressure." Torr"."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->StartOOS."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Location."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong><a href=".$key->Link.">Click Here!</a></strong></th>";
	$mail->Body .= "</tr>";
		}
		
			
		

	
	}
	$mail->Body .= "</table>";
	$mail->Body .= "</body></html>";
	

	//$mail->AltBody="This is text only alternative body.";
	
	
	
		if(!$mail->Send())
		{
			
   			echo "Error sending: " . $mail->ErrorInfo;;
   		
		}
		else
		{
			
   			echo "Letter is sent";	
		}
		
}
	


							//$wh = implode("', '", $warehouse);
							//$query1 = $db->query("SELECT * FROM egunOOS WHERE Location IN ('$wh')");
							//$result1 = $query1->results();
							//foreach($result1 as $a){echo "---".$a->Time."OOOOO".$a->Location;}	

							}
							break;
					}
				}					
			}
		}
	}
}
	
}


function generateAndSendMessageP2()
{
	
	//$mail->SmtpClose();

	set_time_limit(0);

	$mail = new PHPMailer();
	$mail->IsSMTP();  
    $mail->Host = "smtp.gmail.com"; 
    $mail->Port = 465;   
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $db = DB::getInstance();
    $query3 = $db->query("SELECT * FROM senderEmailSetting");
	$result3 = $query3->results();
	foreach ($result3 as $b) {
		$username = $b->email;
		$password = $b->password;
		$Times = $b->P2_Time;
	}
    $mail->Username = $username;  
    $mail->Password = $password;  
    $mail->AltBody = " "; 
    $mail->From = $username;
    $mail->FromName = 'ESS Alert System Notification'; 
$query_P1 = $db->query("SELECT * FROM senderEmailSetting");
$result_P1 = $query_P1->results();
foreach ($result_P1 as $e) {
	if($e->P2 == "checked")
	{
		$sql = $db->query("SELECT count(*) as total  FROM egunOOS");
		$result1 = $sql->results();
		foreach($result1 as $a){$numEgun = $a->total;}
		$sql = $db->query("SELECT count(*) as total  FROM gaugeOOS");
		$result1 = $sql->results();
		foreach($result1 as $a){$numGauge = $a->total;}
		
		if($numGauge!=0 or $numEgun!=0){	
			if($numGauge!=0 and $numEgun!=0){
				$title = "ESS - P2 - egunOOS - gaugeOOS";
			}
			else if($numGauge==0 and $numEgun!=0){
				$title = "ESS - P2 - egunOOS";
			}
			else if($numGauge!=0 and $numEgun==0){
				$title = "ESS - P2 - gaugeOOS";
			}
			
			$query1 = $db->query("SELECT * FROM notifycationSetting");
			$result1 = $query1->results();
			foreach ($result1 as $a) {
				$priority_string = explode(",", $a->Priority);
				for($j=0;$j<count($priority_string);$j++)
				{
					if($priority_string[$j]=="2")
					{
						$warehouse=array();
						$warehouse_string = explode(",", $a->WHName);
						for($i=0;$i<count($warehouse_string);$i++)
            				{
                				$query2 = $db->query("SELECT count(*) as total FROM egunOOS WHERE Location = ?",array($warehouse_string[$i]));
                				$result2 = $query2->results();
                				foreach ($result2 as $b) {
                					$num1 = $b->total;
                			}
                				$query3 = $db->query("SELECT count(*) as total FROM gaugeOOS WHERE Location = ?",array($warehouse_string[$i]));
                				$result3 = $query3->results();
                				foreach ($result3 as $c) {
                					$num2 = $c->total;
                				}
                				if($num1 !=0 or $num2 !=0)
                				{
                					array_push($warehouse, $warehouse_string[$i]);
                				}
							}
			
							
							//echo count($warehouse);
							var_dump($warehouse);

							if(count($warehouse) != 0){
							$email=$a->email;
							echo $a->user;
							echo $a->email;
							
							
							$wh = implode("', '", $warehouse);
							echo "----".$wh."------";
							//echo $email;
							$db = DB::getInstance();
							$query1 = $db->query("SELECT * FROM egunOOS WHERE Location IN ('$wh')");
							$result1 = $query1->results();
							$query2 = $db->query("SELECT * FROM gaugeOOS WHERE Location IN ('$wh')");
							$result2 = $query2->results();
	
							$minutePerDay = (24*60)/$Times;
	 						
							
							$currentTime = date('Y-m-d H:i:s');
							$TimeDifferent = (strtotime($currentTime)-strtotime($a->TimeP2Send))/60;
							
							if($TimeDifferent >= $minutePerDay )
								{
								echo "nguoi dc gui la--".$email."--";
								$query6 = $db->query("UPDATE notifycationSetting set TimeP2Send = ? WHERE id = ?", [$currentTime,$a->id]);
								$result6 = $query6->results();
		
	
	
	
    $mail->clearAddresses();
	$mail->AddAddress($email);
	
	$mail->Subject = $title;

	$mail->IsHTML(true);
	$mail->Body = '<html><body>';
	$mail->Body .= "<h3>Information about Egun Out Of Spec </h3>";
	$mail->Body .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
	$mail->Body .= '<table class="table table-border">';
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='background: #eee;'><strong>RFID</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>stationName</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Time</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Pressure</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Voltage</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Current</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>StartOOS</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Location</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Link</strong></th>";
	$mail->Body .= "</tr>";
	
	foreach ($result1 as $key) {
		
		
			$query_sN = $db->query("SELECT stationName FROM stations WHERE RFID = ?",array($key->RFID));
		$result_sN = $query_sN->results();
		foreach ($result_sN as $key1) {$stationName = $key1->stationName;}

	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->RFID."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$stationName."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Time."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".doubletoMyString($key->Pressure)."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Voltage."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Current."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->StartOOS."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Location."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong><a href=".$key->Link.">Click Here!</a></strong></th>";
	$mail->Body .= "</tr>";
		
		
	}
	$mail->Body .= "</table>";
	$mail->Body .= "<h3>Information about Gauge Out Of Spec </h3>";
	$mail->Body .= '<table class="table table-hover table-list-search">';
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='background: #eee;'><strong>id</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Time</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Pressure</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>StartOOS</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Location</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Link</strong></th>";
	$mail->Body .= "</tr>";
	foreach ($result2 as $key) {
		
		
			$mail->Body .= "<tr>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->id."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Time."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Pressure." Torr"."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->StartOOS."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Location."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong><a href=".$key->Link.">Click Here!</a></strong></th>";
	$mail->Body .= "</tr>";
		

	
	}
	$mail->Body .= "</table>";
	$mail->Body .= "</body></html>";
	

	//$mail->AltBody="This is text only alternative body.";
	
	
		if(!$mail->Send())
		{
			
   			echo "Error sending: " . $mail->ErrorInfo;;
   		
		}
		else
		{
			
   			echo "Letter is sent";	
		}
		

	}


							//$wh = implode("', '", $warehouse);
							//$query1 = $db->query("SELECT * FROM egunOOS WHERE Location IN ('$wh')");
							//$result1 = $query1->results();
							//foreach($result1 as $a){echo "---".$a->Time."OOOOO".$a->Location;}	

							}
							break;
					}
				}					
			}
		}
	}
}
	
}




function generateAndSendMessageP3()
{
	$db = DB::getInstance();
	$sql = $db->query("SELECT count(*) as total  FROM stations");
	$result1 = $sql->results();
	foreach($result1 as $a){$numStationTotal = $a->total;}
	$RFID_null = "R0000";
	$sql = $db->query("SELECT count(*) as total  FROM stations WHERE RFID = ?",array($RFID_null));
	$result1 = $sql->results();
	foreach($result1 as $a){$numStationNotReal = $a->total;}
	$numStation = $numStationTotal - $numStationNotReal;
	$currentTime = date('Y-m-d');
	$currentTimeFull = date('Y-m-d H:i:s');
	require("class.phpmailer.php");
	$query3 = $db->query("SELECT * FROM senderEmailSetting");
	$result3 = $query3->results();
	foreach ($result3 as $b) {
		$username = $b->email;
		$password = $b->password;
		$mail = new PHPMailer();
		$mail->IsSMTP();  
    	$mail->Host = "smtp.gmail.com"; 
    	$mail->Port = 465;   
    	$mail->SMTPAuth = true;
    	$mail->SMTPSecure = 'ssl';
    	$mail->Username = $username;  
   		$mail->Password = $password;  
    	$mail->AltBody = " "; 
    	$mail->From = $username;
    	$mail->FromName = 'ESS Alert System Notification'; 
	$mail->clearAddresses();
	//$mail->Sender="mailer@example.com";
	//$mail->AddReplyTo("replies@example.com", "Replies for my site");
	
	if($b->P3 == "checked")
		{
	$query2 = $db->query("SELECT * FROM notifycationSetting");
			$result2 = $query2->results();
			foreach ($result2 as $a) {
				$priority_string = explode(",", $a->Priority);
				for($j=0;$j<count($priority_string);$j++)
				{
					if($priority_string[$j]=="3")
					{
						
						$mail->AddAddress($a->email);
					}
				}
			}
			$mail->Subject = "ESS - P3 - Statistics - ".$currentTime;

	$mail->IsHTML(true);
	$mail->Body = '<html><body>';
	$mail->Body .= "<h3 style='color: red;''>Total Egun in all warehouses: ".$numStation." </h3>";
	$mail->Body .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';

	$fulldatetime = $b->TimeSendP3;
	$dt = new DATETIME($fulldatetime);
	$mail->Body .= "<h3>Information about Egun Arrived </h3>";
	$mail->Body .= '<table class="table table-hover table-list-search">';
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='background: #eee;'><strong>Egun Recieved| from ".$dt->format('Y-m-d')." to ".$currentTime."</strong></th>";
	$mail->Body .= "</tr>";
	$status_station = "Arrived";
	$query_Egun_Arrived = $db->query("SELECT count(*) as total  FROM EgunTransaction WHERE status = ? AND Time >= ? ",[$status_station,$b->TimeSendP3]);
	$result_Egun_Arrived = $query_Egun_Arrived->results();
	foreach ($result_Egun_Arrived as $arrived) {$numEgunArrived = $arrived->total;}
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>Total: ".$numEgunArrived."</strong></th>";
	$mail->Body .= "</tr>";
	$mail->Body .= "</table>";
	$mail->Body .= "<br><br>";
	$mail->Body .= '<table class="table table-border">';
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='background: #eee;'><strong>RFID</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>LPN</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Time</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Location</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Link</strong></th>";
	$mail->Body .= "</tr>";

	$query10=$db->query("SELECT * FROM EgunTransaction WHERE status = ? AND Time >= ?",[$status_station,$b->TimeSendP3]);
	$result10 = $query10->results();
	if(count($result10) > 0){
		foreach ($result10 as $key) {
		$warehouseName1 = "";
		$LPN1 = "";

		$query_LPN = $db->query("SELECT LPN FROM frus WHERE RFID = ?",array($key->RFID));
		$result_LPN = $query_LPN->results();
		foreach ($result_LPN as $key1) {$LPN1 = $key1->LPN;};
		
		 $Link1 = getDomainName()."users/station.php?RFID=$key->RFID";
		$query_sN = $db->query("SELECT warehouseName FROM stations WHERE RFID = ?",array($key->RFID));
		$result_sN = $query_sN->results();
		foreach ($result_sN as $key2) {$warehouseName1 = $key2->warehouseName;}

	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->RFID."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$LPN1."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Time."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$warehouseName1."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong><a href=".$Link1.">Click Here!</a></strong></th>";
	$mail->Body .= "</tr>";
	}
		
	
	
	}
	$mail->Body .= "</table>";
	$mail->Body .= "<br><br><br><br>";


	$mail->Body .= "<h3>Information about Egun Shipped </h3>";
	$mail->Body .= '<table class="table table-hover table-list-search">';
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='background: #eee;'><strong>Egun Shipped| from ".$dt->format('Y-m-d')."  to ".$currentTime." </strong></th>";
	$mail->Body .= "</tr>";
	$status_station = "shipped";
	$query_Egun_shipped = $db->query("SELECT count(*) as total  FROM EgunTransaction WHERE status = ? AND Time >= ? ",[$status_station,$b->TimeSendP3]);
	$result_Egun_shipped = $query_Egun_shipped->results();
	foreach ($result_Egun_shipped as $shipped) {$numEgunshipped = $shipped->total;}
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>Total: ".$numEgunshipped."</strong></th>";
	$mail->Body .= "</tr>";
	$mail->Body .= "</table>";
	$mail->Body .= "<br><br>";
	$mail->Body .= '<table class="table table-border">';
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='background: #eee;'><strong>RFID</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>LPN</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Time</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Location</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Link</strong></th>";
	$mail->Body .= "</tr>";

	$query11=$db->query("SELECT * FROM EgunTransaction WHERE status = ? AND Time >= ?",[$status_station,$b->TimeSendP3]);
	$result11 = $query11->results();
	if(count($result11) > 0)
	{
		foreach ($result11 as $key) {
		$warehouseName2 = "";
		$LPN2 = "";
		$query_LPN = $db->query("SELECT LPN FROM frus WHERE RFID = ?",array($key->RFID));
		$result_LPN = $query_LPN->results();
		foreach ($result_LPN as $key1) {$LPN2 = $key1->LPN;};
		$Link = getDomainName()."users/station.php?RFID=$key->RFID";
		$query_sN = $db->query("SELECT warehouseName FROM stations WHERE RFID = ?",array($key->RFID));
		$result_sN = $query_sN->results();
		foreach ($result_sN as $key2) {$warehouseName2 = $key2->warehouseName;}

	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->RFID."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$LPN2."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Time."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$warehouseName2."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong><a href=".$Link.">Click Here!</a></strong></th>";
	$mail->Body .= "</tr>";
	}
	}
	
	$mail->Body .= "</table>";
	
	
	$mail->Body .= "</body></html>";
	

	//$mail->AltBody="This is text only alternative body.";

	if(!$mail->Send())
	{
   		echo "Error sending: " . $mail->ErrorInfo;;
	}
	else
	{
   		echo "Letter is sent";
   		$idSendEmail = "0";
   		$query4 = $db->query("UPDATE senderEmailSetting set TimeSendP3 = ? WHERE id = ? ",[$currentTimeFull,$idSendEmail]);
   		$result4 = $query4->results();
	}


		}
	}
    	
	//$mail->AddCC("tam.duong@ascenx.com");
	//$mail->AddCC("tam.duong@kla-tencor.com");
	

}


function generateAndSendMessageP4($RFID)
{
	require_once("class.phpmailer.php");
	$title="ESS - P4 - Shipping Notice";
	$db = DB::getInstance();
	$query1 = $db->query("SELECT * FROM frus WHERE RFID = ?", array($RFID));
	$result1 = $query1->results();
	$query_sN = $db->query("SELECT warehouseName FROM stations WHERE RFID = ?",array($RFID));
	$result_sN = $query_sN->results();
	foreach ($result_sN as $key2) {$warehouseName1 = $key2->warehouseName;}
	$query3 = $db->query("SELECT * FROM senderEmailSetting");
	$result3 = $query3->results();
	foreach ($result3 as $b) {
		$username = $b->email;
		$password = $b->password;
		$mail = new PHPMailer();
		$mail->IsSMTP();  
    	$mail->Host = "smtp.gmail.com"; 
    	$mail->Port = 465;   
    	$mail->SMTPAuth = true;
    	$mail->SMTPSecure = 'ssl';
    	$mail->Username = $username;  
   		$mail->Password = $password;  
    	$mail->AltBody = " "; 
    	$mail->From = $username;
    	$mail->FromName = 'ESS Alert System Notification'; 
		if($b->P4 == "checked")
		{
			$query5 = $db->query("SELECT * FROM notifycationSetting");
			$result5 = $query5->results();
			foreach ($result5 as $a) {
				$priority_string = explode(",", $a->Priority);
				for($j=0;$j<count($priority_string);$j++)
				{
					if($priority_string[$j]=="4")
					{
						$warehouse=array();
						$warehouse_string = explode(",", $a->WHName);
						for($i=0;$i<count($warehouse_string);$i++)
            				{
            					if($warehouse_string[$i] == $warehouseName1)
            					{
            						
									$mail->clearAddresses();
									$mail->AddAddress($a->email);
									//$mail->AddCC("tam.duong@ascenx.com");
									//$mail->AddCC("tam.duong@kla-tencor.com");
									
		
            					}
            				}
            		}
            	}
        	}
        	$mail->Subject = $title;
									$mail->IsHTML(true);
									$mail->Body = '<html><body>';
									$mail->Body .= "<h3>Information about Shipping Egun </h3>";
									$mail->Body .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
									$mail->Body .= '<table class="table table-border">';
									$mail->Body .= "<tr>";
									$mail->Body .= "<th style='background: #eee;'><strong>RFID</strong></th>";
									$mail->Body .= "<th style='background: #eee;'><strong>stationName</strong></th>";
									$mail->Body .= "<th style='background: #eee;'><strong>Location</strong></th>";
									$mail->Body .= "<th style='background: #eee;'><strong>KT PN</strong></th>";
									$mail->Body .= "<th style='background: #eee;'><strong>KT Serial PN</strong></th>";
									$mail->Body .= "<th style='background: #eee;'><strong>LPN</strong></th>";
									$mail->Body .= "<th style='background: #eee;'><strong>Supplier Test Day </strong></th>";
									$mail->Body .= "<th style='background: #eee;'><strong>MFG Gun of GV Closed</strong></th>";
									$mail->Body .= "<th style='background: #eee;'><strong>Purchase Order</strong></th>";
									$mail->Body .= "<th style='background: #eee;'><strong>Date Received</strong></th>";
									$mail->Body .= "<th style='background: #eee;'><strong>Date Shipped</strong></th>";
									
									$mail->Body .= "<th style='background: #eee;'><strong>Link</strong></th>";
									$mail->Body .= "</tr>";
	
									foreach ($result1 as $key) {
										$query_sN = $db->query("SELECT stationName FROM stations WHERE RFID = ?",array($RFID));
										$result_sN = $query_sN->results();
										foreach ($result_sN as $key1) {$stationName = $key1->stationName;}
										$Link = getDomainName()."users/station.php?RFID=$key->RFID";
				
										$mail->Body .= "<tr>";
										$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->RFID."</strong></th>";
										$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$stationName."</strong></th>";
										$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$warehouseName1."</strong></th>";
										$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->PN."</strong></th>";
										$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Serial."</strong></th>";
										$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->LPN."</strong></th>";
										$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->TestDate."</strong></th>";
										$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->MFGPressure."</strong></th>";
										$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->PO."</strong></th>";
										$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->DateInStock."</strong></th>";
										$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->DateShipped."</strong></th>";
										
										$mail->Body .= "<th style='color: red;text-align:left;'><strong><a href=".$Link.">Click Here!</a></strong></th>";
										$mail->Body .= "</tr>";	
									}
									$mail->Body .= "</table>";
									$mail->Body .= "</body></html>";
	

									//$mail->AltBody="This is text only alternative body.";
	
									if(!$mail->Send())
									{
   										echo "Error sending: " . $mail->ErrorInfo;;
   		
									}
									else
									{
   										echo "Letter is sent";	
									}
			
		}	
	}
}

	
function generateAndSendMessageP5()
{
	
	//$mail->SmtpClose();

	set_time_limit(0);
	$currentTime = date('Y-m-d H:i:s');
	$mail = new PHPMailer();
	$mail->IsSMTP();  
    $mail->Host = "smtp.gmail.com"; 
    $mail->Port = 465;   
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $db = DB::getInstance();
    $query3 = $db->query("SELECT * FROM senderEmailSetting");
	$result3 = $query3->results();
	foreach ($result3 as $b) {
		$username = $b->email;
		$password = $b->password;
		
	}
    $mail->Username = $username;  
    $mail->Password = $password;  
    $mail->AltBody = " "; 
    $mail->From = $username;
    $mail->FromName = 'ESS Alert System Notification'; 
$query_P5 = $db->query("SELECT * FROM senderEmailSetting");
$result_P5 = $query_P5->results();
foreach ($result_P5 as $e) {
	if($e->P5 == "checked")
	{

		$sql = $db->query("SELECT count(*) as total  FROM dewpointOOS");
		$result1 = $sql->results();
		foreach($result1 as $a){$numFLip = $a->total;}
		$sql = $db->query("SELECT * FROM latestDataFlipper");
		$result1 = $sql->results();
		foreach($result1 as $a){
			$minuteFlipper = (strtotime($currentTime)-strtotime($a->Time))/60;
			if($minuteFlipper >= 60)
			{
				$numFlipperLoss = 1;
				$field = array('Location'=>$a->Location,'Time'=>$a->Time);
				$db->insert('noDataFaultFlipper',$field);
			}
			else
			{
				$numFlipperLoss = 0;
			}
			
		}
		
		if($numFlip!=0 or $numFlipperLoss!=0){	
			if($numFLip!=0 and $numFlipperLoss!=0){
				$title = "ESS - P5 - Dewpoint OOS - No Data Fault";
			}
			else if($numFlip==0 and $numFlipperLoss!=0){
				$title = "ESS - P5 - No Data Fault";
			}
			else if($numFlip!=0 and $numFlipperLoss==0){
				$title = "ESS - P5 - Dewpoint OOS";
			}
			
			$query1 = $db->query("SELECT * FROM notifycationSetting");
			$result1 = $query1->results();
			foreach ($result1 as $a) {
				$priority_string = explode(",", $a->Priority);
				for($j=0;$j<count($priority_string);$j++)
				{
					if($priority_string[$j]=="5")
					{
						$warehouse=array();
						$warehouse_string = explode(",", $a->WHName);

						for($i=0;$i<count($warehouse_string);$i++)
            				{
            					if($warehouse_string[$i] == "USA1") $warehouse_string[$i] = "USA";
            					if($warehouse_string[$i] == "USA2") $warehouse_string[$i] = "USA";
                				$query2 = $db->query("SELECT count(*) as total FROM dewpointOOS WHERE Location = ?",array($warehouse_string[$i]));
                				$result2 = $query2->results();
                				foreach ($result2 as $b) {
                					$num1 = $b->total;
                			}
                				$query3 = $db->query("SELECT count(*) as total FROM noDataFaultFlipper WHERE Location = ?",array($warehouse_string[$i]));
                				$result3 = $query3->results();
                				foreach ($result3 as $c) {
                					$num2 = $c->total;
                				}

                				if($num1 !=0 or $num2 !=0)
                				{
                					array_push($warehouse, $warehouse_string[$i]);
                				}
							}
			
							
							//echo count($warehouse);
							var_dump($warehouse);

							if(count($warehouse) != 0){
							$email=$a->email;
							echo $a->user;
							echo $a->email;
							
							
							$wh = implode("', '", $warehouse);
							echo "----".$wh."------";
							//echo $email;
							$db = DB::getInstance();

							$query1d = $db->query("SELECT * FROM dewpointOOS WHERE Location IN ('$wh')");
							$result1d = $query1d->results();
							$query2n = $db->query("SELECT * FROM noDataFaultFlipper WHERE Location IN ('$wh')");
							$result2n = $query2n->results();
	
							$query41 = $db->query("SELECT * FROM dewpointOOS WHERE Location IN ('$wh') ORDER BY TimeSend DESC LIMIT 1");
	$result41 = $query41->results();
	foreach ($result41 as $d) {
		$latestTimeDewpointOOS = $d->TimeSend;
	}
	$query42 = $db->query("SELECT * FROM noDataFaultFlipper WHERE Location IN ('$wh') ORDER BY TimeSend DESC LIMIT 1");
	$result42 = $query42->results();
	foreach ($result42 as $d) {
		$latestTimeNoDataFault = $d->TimeSend;
	}

	$minuteDewpointOOS = (strtotime($currentTime)-strtotime($latestTimeDewpointOOS))/60;
	$minuteNoDataFault = (strtotime($currentTime)-strtotime($latestTimeNoDataFault))/60;
	if(count($result41) == 0) $minuteDewpointOOS = 0;
	if(count($result42) == 0) $minuteNoDataFault = 0;
	echo "currentTime: ".strtotime($currentTime);
	echo "minuteDewpointOOS: ".$minuteDewpointOOS;
	echo "minuteNoDataFault: ".$minuteNoDataFault;
	if($minuteDewpointOOS >30 or $minuteNoDataFault >60 )
	{
	
	
    $mail->clearAddresses();
	$mail->AddAddress($email);
	
	$mail->Subject = $title;

	$mail->IsHTML(true);
	$mail->Body = '<html><body>';
	$mail->Body .= "<h3>Information about FLipper Out Of Spec </h3>";
	$mail->Body .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
	$mail->Body .= '<table class="table table-border">';
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='background: #eee;'><strong>Location</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Dewpoint</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>StartOOS</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Link</strong></th>";
	$mail->Body .= "</tr>";
	
	foreach ($result1d as $key) {
		$minuteE = (strtotime($currentTime)-strtotime($key->TimeSend))/60;
		if($minuteE >30)
		{
			$LocationFlipperOOS = $key->Location;
			$Link = getDomainName()."users/flipper.php?WHName=$key->Location";
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Location."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Dewpoint."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Time."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong><a href=".$Link.">Click Here!</a></strong></th>";
	$mail->Body .= "</tr>";
		}		
			
		
		
	}
	$mail->Body .= "</table>";
	$mail->Body .= "<h3>Information about No Data Fault </h3>";
	$mail->Body .= '<table class="table table-hover table-list-search">';
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='background: #eee;'><strong>StartNoDataFault</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Location</strong></th>";
	$mail->Body .= "</tr>";
	foreach ($result2n as $key2) {
		$minuteG = (strtotime($currentTime)-strtotime($key2->TimeSend))/60;
		if($minuteG >60)
		{
			$mail->Body .= "<tr>";
	$LocationFlipperNoData = $key2->Location;
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key2->Time."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key2->Location."</strong></th>";
	$mail->Body .= "</tr>";
		}
		
			
		

	
	}
	$mail->Body .= "</table>";
	$mail->Body .= "</body></html>";
	

	//$mail->AltBody="This is text only alternative body.";
	
	
	
		if(!$mail->Send())
		{
			
   			echo "Error sending: " . $mail->ErrorInfo;;
   		
		}
		else
		{
			
   			echo "Letter is sent";	
   			$query4 = $db->query("UPDATE dewpointOOS set TimeSend = ? WHERE Location = ? ",[$currentTime,$LocationFlipperOOS]);
   			$result4 = $query4->results();
   			$query5 = $db->query("UPDATE noDataFaultFlipper set TimeSend = ? WHERE Location = ? ",[$currentTime,$LocationFlipperNoData]);
   			$result5 = $query5->results();
		}
		
}
	


							//$wh = implode("', '", $warehouse);
							//$query1 = $db->query("SELECT * FROM egunOOS WHERE Location IN ('$wh')");
							//$result1 = $query1->results();
							//foreach($result1 as $a){echo "---".$a->Time."OOOOO".$a->Location;}	

							}
							break;
					}
				}					
			}
		}
	}
}
	
}
	




function generateAndSendMessageP6()
{
	
	//$mail->SmtpClose();

	$db = DB::getInstance();
	$currentTime = date('Y-m-d');
	$currentTimeFull = date('Y-m-d H:i:s');
	require("class.phpmailer.php");
	$query3 = $db->query("SELECT * FROM senderEmailSetting");
	$result3 = $query3->results();
	foreach ($result3 as $b) {
		$username = $b->email;
		$password = $b->password;
		$mail = new PHPMailer();
		$mail->IsSMTP();  
    	$mail->Host = "smtp.gmail.com"; 
    	$mail->Port = 465;   
    	$mail->SMTPAuth = true;
    	$mail->SMTPSecure = 'ssl';
    	$mail->Username = $username;  
   		$mail->Password = $password;  
    	$mail->AltBody = " "; 
    	$mail->From = $username;
    	$mail->FromName = 'ESS Alert System Notification'; 
	$mail->clearAddresses();
	//$mail->Sender="mailer@example.com";
	//$mail->AddReplyTo("replies@example.com", "Replies for my site");
	
	if($b->P6 == "checked")
		{
	$query2 = $db->query("SELECT * FROM notifycationSetting");
			$result2 = $query2->results();
			foreach ($result2 as $a) {
				$priority_string = explode(",", $a->Priority);
				for($j=0;$j<count($priority_string);$j++)
				{
					if($priority_string[$j]=="6")
					{
						
						$mail->AddAddress($a->email);
					}
				}
			}
			$mail->Subject = "ESS - P6 - Statistics - ".$currentTimeFull;

	$mail->IsHTML(true);
	$mail->Body = '<html><body>';
	$mail->Body .= "<h3>Information about Flipper </h3>";
	$mail->Body .= '<table class="table table-border">';
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='background: #eee;'><strong>Location</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Time</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Dewpoint</strong></th>";
	$mail->Body .= "<th style='background: #eee;'><strong>Link</strong></th>";
	$mail->Body .= "</tr>";

	$query_Flipper = $db->query("SELECT *  FROM latestDataFlipper");
	$result_Flipper = $query_Flipper->results();
	if(count($result_Flipper) > 0){
		foreach ($result_Flipper as $key) {
		$Link1 = getDomainName()."users/flipper.php?WHName=$key->Location";
	$mail->Body .= "<tr>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Location."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Time."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong>".$key->Dewpoint."</strong></th>";
	$mail->Body .= "<th style='color: red;text-align:left;'><strong><a href=".$Link1.">Click Here!</a></strong></th>";
	$mail->Body .= "</tr>";
	}
		
	
	
	}
	
	
	$mail->Body .= "</body></html>";
	

	//$mail->AltBody="This is text only alternative body.";

	if(!$mail->Send())
	{
   		echo "Error sending: " . $mail->ErrorInfo;;
	}
	else
	{
   		echo "Letter is sent";
   		$idSendEmail = "0";
   		$query4 = $db->query("UPDATE senderEmailSetting set TimeSendP6 = ? WHERE id = ? ",[$currentTimeFull,$idSendEmail]);
   		$result4 = $query4->results();
	}


		}
	}
    	
	//$mail->AddCC("tam.duong@ascenx.com");
	//$mail->AddCC("tam.duong@kla-tencor.com");
	

}



function deleteAllDatainDatabase()
{
	$db = DB::getInstance();
	$query0 = $db->query("SELECT * FROM rfids");
	$result0 = $query0->results();
	foreach ($result0 as $a) {
		$RFID = $a->RFID;
		$query2 = $db->query("DROP TABLE $RFID");
		$result2 = $query2->results();
	}
	$query3 = $db->query("SELECT * FROM gauges");
	$result3 = $query3->results();
	foreach ($result3 as $b) {
		$gaugeID = "G".$b->id;
		$query4 = $db->query("DROP TABLE $gaugeID");
		$result4 = $query4->results();
	}
	$query7 = $db->query("SELECT * FROM flippers");
	$result7 = $query7->results();
	foreach ($result7 as $c) {
		$nameFlipper = $c->Location."FLipperCH1";
		$query8 = $db->query("DROP TABLE $nameFlipper");
		$result8 = $query8->results();
	}
	$query5 = $db->query("DELETE FROM rfids");
	$result5 = $query5->results();
	$query6 = $db->query("DELETE FROM EgunTransaction");
	$result6 = $query6->results();
	$query6 = $db->query("DELETE FROM egunOOS");
	$result6 = $query6->results();
	$query6 = $db->query("DELETE FROM gaugeOOS");
	$result6 = $query6->results();
	$query6 = $db->query("DELETE FROM flippers");
	$result6 = $query6->results();
	$query6 = $db->query("DELETE FROM dewpointOOS");
	$result6 = $query6->results();
	$query6 = $db->query("DELETE FROM noDataFaultFlipper");
	$result6 = $query6->results();

	
}