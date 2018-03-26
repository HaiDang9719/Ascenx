<?php
require_once 'users/init.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

$data_decoded  = json_decode(file_get_contents("php://input"), true);
$numStation =count($data_decoded);
while (list($key, $val) = each($data_decoded))
{	
	while (list($key1,$val1) = each($val)) {
		# code...
	
	echo $val1["pressure"]."------";
	insertRFIDtorfidsTablePhase2($val1["time"],$val1["rfid"],$val1["pressure"],$val1["voltage"],$val1["current"]);
	}
}
	echo $numStation;

?>



