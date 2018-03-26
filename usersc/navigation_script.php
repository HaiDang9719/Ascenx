<?php
require_once 'init.php';
if(!securePage($_SERVER['PHP_SELF'])){die();}
if(!empty($_POST["keyword"])) {
	$db = DB::getInstance();
	$query1 = $db->query("SELECT * FROM rfids WHERE RFID like"."'".$_POST['keyword']."%'"." ORDER BY RFID LIMIT 4");
	$result1 = $query1->results();
	if(!empty($result1)) {
	?>
		<ul id="country-list">
	<?php
	foreach($result1 as $RFID) {
	?>
		<li onClick="selectCountry('<?php echo $RFID->RFID; ?>');"><a href="admin_stations.php?warehouseName=Singapore"><?php echo $RFID->RFID; ?></a></li>
	<?php 
	} 
	?>
		</ul>
	<?php 
	} 
	}
?>