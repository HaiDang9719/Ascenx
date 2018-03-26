<?php 
require_once 'users/init.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

$data_decoded  = json_decode(file_get_contents("php://input"), true);

$TemperatureTableName = '';
$TemperatureTableName .= $data_decoded["Location"];
$TemperatureTableName .= "FlipperCH1";

insertTemperatureToDatabase($TemperatureTableName, $data_decoded["FlipperCH1"]);
$db = DB::getInstance();
$currentTime = date('Y-m-d H:i:s');
$query1 = $db->query("SELECT count(*) as total FROM latestDataFlipper WHERE Location = ?",array($data_decoded["Location"]));
$result1 = $query1->results();
foreach ($result1 as $key) {
	$num = $key->total;
}
if($num == 0)
{
	$field = array('Location'=>$data_decoded["Location"],'Time'=>$currentTime,'Dewpoint'=>$data_decoded["FlipperCH1"]);
	$db->insert('latestDataFlipper',$field);
}
else {
	$query2 = $db->query("UPDATE latestDataFlipper SET Time = ?, Dewpoint = ? WHERE Location = ?",[$currentTime,$data_decoded["FlipperCH1"],$data_decoded["Location"]]);
	$result2 = $query2->results();
}
$query3 = $db->query("SELECT count(*) as total FROM flippers WHERE Location = ?",array($data_decoded['Location']));
$result3 = $query3->results();
foreach ($result3 as $a) {
	$num1 = $a->total;
}
if($num1 == 0)
{
	$field1 = array('Location'=>$data_decoded["Location"],'Time'=>$currentTime);
	$db->insert('flippers',$field1);
}
else
{
	$query4 = $db->query("UPDATE flippers SET Time = ? WHERE Location = ?",[$currentTime,$data_decoded["Location"]]);
	$result4 = $query4->results();
}
$query5 = $db->query("SELECT * from flippers WHERE Location = ?",array($data_decoded['Location']));
$result5 = $query5->results();
foreach ($result5 as $b) {
	$UpperThreshold = $b->UpperThreshold;
}

if ($temperatureFlipperGDC > $UpperThreshold)
{
	$query6 = $db->query("SELECT count(*) as total FROM dewpointOOS WHERE Location = ?",array($data_decoded['Location']));
	$result6 = $query6->results();
	foreach ($result6 as $c) {
		$num2 = $c->total;
	}
	if($num2 == 0)
	{
		$field2 = array('Location'=>$data_decoded["Location"],'Dewpoint'=>$data_decoded["FlipperCH1"],'Time'=>$currentTime);
		$db->insert('dewpointOOS',$field2);
	}
	else
	{
		$query7 = $db->query("UPDATE dewpointOOS SET Dewpoint = ?, Time = ? WHERE Location = ?",[$data_decoded["FlipperCH1"],$currentTime,$data_decoded['Location']]);
		$result7 = $query7->results();
	}
    
}
$query9 = $db->query("SELECT * FROM dewpointOOS WHERE Location = ?",array($data_decoded['Location']));
$result9 = $query9->results();
foreach ($result9 as $d) {
	$timeOOS = $d->Time;
	$minuteTimeOOS = (strtotime($currentTime)-strtotime($timeOOS))/60;
	if($minuteTimeOOS >10)
	{
		$query10 = $db->query("DELETE FROM dewpointOOS WHERE Location = ?",array($data_decoded['Location']));
		$result10 = $query10->results();
	}
}

$query8 = $db->query("DELETE FROM noDataFaultFlipper WHERE Location = ?",array($data_decoded['Location']));
$result8 = $query8->results();
?>