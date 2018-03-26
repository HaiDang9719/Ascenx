<?php require_once 'init.php';?>
<?php if (!securePage($_SERVER['PHP_SELF'])) {die();}?>

<?php


	//PHP Goes Here!
$DaysOfSample = $_POST['Range'];
$WHName = $_POST['WHName'];
$nameFlipper = $WHName."FlipperCH1";
$NumberOfSamples = $DaysOfSample * 1440;
$db              = DB::getInstance();
$query1          = $db->query("SELECT * FROM (SELECT * FROM $nameFlipper ORDER BY Time DESC LIMIT $NumberOfSamples) T1 ORDER BY Time ASC");
//$query1 = $db ->get('stations',['id','=',$StationID],false);
$results = $query1->results();
$data    = array();
foreach ($results as $a) {$data[] = $a;}
$data_json = json_encode($data);

echo $data_json;

?>
	