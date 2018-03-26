<?php require_once 'init.php';?>
<?php if (!securePage($_SERVER['PHP_SELF'])) {die();}?>

<?php
$WHName = $_POST['WHName'];
$db              = DB::getInstance();
$nameFlipper = $WHName."FlipperCH1";
        $query5 = $db->query("SELECT * FROM $nameFlipper ORDER BY Time DESC LIMIT 1 ");
$result5 = $query5->results();
foreach ($result5 as $q) {
    $temperatureFlipperGDC = $q->Temperature;
    $testTime = $q->Time;
    
}

$query6 = $db->query("SELECT * from flippers WHERE Location = ?",array($WHName));
$result6 = $query6->results();
foreach ($result6 as $b) {
	$LowerThreshold = $b->LowerThreshold;
	$UpperThreshold = $b->UpperThreshold;
}
if($temperatureFlipperGDC < $LowerThreshold and $temperatureFlipperGDC > -100)
{
    $tempColor = "#008000";
}
else if ($temperatureFlipperGDC <= $UpperThreshold and $temperatureFlipperGDC >= $LowerThreshold)
{

    $tempColor = "#ffff00";
}
else if ($temperatureFlipperGDC < 0 and $temperatureFlipperGDC > $UpperThreshold)
{
    
    $tempColor = "#ff0000";
}
$data    = array();
$percent = ((100 - $temperatureFlipperGDC * -1)/1)."%";
$percentLocation = ((($temperatureFlipperGDC * -1)/100)*590)."px";

	$data1['percent'] = $percent;
	$data1['percentLocation'] = $percentLocation;
	$data1['temperature'] = $temperatureFlipperGDC;
	$data1['color'] = $tempColor;
	$data[] = $data1;

$data_json = json_encode($data);

echo $data_json;

?>
	