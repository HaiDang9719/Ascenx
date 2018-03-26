<?php require_once 'init.php';?>
<?php if (!securePage($_SERVER['PHP_SELF'])) {die();}?>

<?php


	//PHP Goes Here!
$DaysOfSample = $_POST['Range'];

$RFID = $_POST['RFID'];
$timeZone = $_POST['timeZone'];
if($timeZone == "server" || $timeZone == "") $timeZone = date_default_timezone_get();
$NumberOfSamples = $DaysOfSample * 1440;
$db              = DB::getInstance();
$query1          = $db->query("SELECT * FROM (SELECT * FROM $RFID ORDER BY Time DESC LIMIT $NumberOfSamples) T1 ORDER BY Time ASC");
//$query1 = $db ->get('stations',['id','=',$StationID],false);
$results = $query1->results();
$data    = array();



foreach ($results as $a) {
	$datetime = new DateTime($a->Time);
	$la_time = new DateTimeZone($timeZone);
	$datetime->setTimezone($la_time);
	$data1['Time'] = $datetime->format('Y-m-d H:i:s');
	$data1['Pressure'] = $a->Pressure;
	$data1['Voltage'] = $a->Voltage;
	$data1['Current'] = $a->Current;
	$data[] = $data1;
}
$data_json = json_encode($data);

echo $data_json;

?>
	