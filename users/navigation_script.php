<?php
require_once 'init.php';
if(!securePage($_SERVER['PHP_SELF'])){die();}
if(!empty($_POST["keyword"])) 
{
	
$db = DB::getInstance();
	$query1 = $db->query("SELECT * FROM rfids WHERE RFID like"."'".$_POST['keyword']."%'"." ORDER BY RFID LIMIT 4");
	$result1 = $query1->results();
	
		$query2 = $db->query("SELECT * FROM frus WHERE LPN like"."'".$_POST['keyword']."%'"." ORDER BY RFID LIMIT 4");
	$result2 = $query2->results();
	$query3 = $db->query("SELECT * FROM frus WHERE Serial like"."'".$_POST['keyword']."%'"." ORDER BY RFID LIMIT 4");
	$result3 = $query3->results();
	$query4 = $db->query("SELECT * FROM frus WHERE DateInStock like"."'".$_POST['keyword']."%'"." ORDER BY RFID LIMIT 4");
	$result4 = $query4->results();
	$query5 = $db->query("SELECT * FROM frus WHERE DateShipped like"."'".$_POST['keyword']."%'"." ORDER BY RFID LIMIT 4");
	$result5 = $query5->results();
	
	

	if(!empty($result1)) 
	{ ?>

		<ul id="country-list">
	<?php foreach($result1 as $RFID) {?>

		<li onClick="selectCountry('<?php echo $RFID->RFID; ?>');">
		<a href="/KTproj/users/station.php?RFID=<?=$RFID->RFID?>"><?php echo $RFID->RFID; ?></a></li>

	<?php } ?>
		</ul>
	<?php 

	}
	
	else if(!empty($result2)) 
	{ ?>

		<ul id="country-list">
	<?php foreach($result2 as $LPN) {?>

		<li onClick="selectCountry('<?php echo $LPN->LPN; ?>');">
		<a href="/KTproj/users/station.php?RFID=<?=$LPN->RFID?>"><?php echo $LPN->LPN; ?></a></li>

	<?php } ?>
		</ul>
	<?php 

	}
	else if(!empty($result3)) 
	{ ?>

		<ul id="country-list">
	<?php foreach($result3 as $Serial) {?>

		<li onClick="selectCountry('<?php echo $Serial->Serial; ?>');">
		<a href="/KTproj/users/station.php?RFID=<?=$Serial->RFID?>"><?php echo $Serial->Serial; ?></a></li>

	<?php } ?>
		</ul>
	<?php 

	}
	else if(!empty($result4)) 
	{ ?>

		<ul id="country-list">
	<?php foreach($result4 as $Date) {?>

		<li onClick="selectCountry('<?php echo $Date->DateInStock; ?>');">
		<a href="/KTproj/users/station.php?RFID=<?=$Date->RFID?>"><?php echo $Date->DateInStock; ?></a></li>

	<?php } ?>
		</ul>
	<?php 

	}
	else if(!empty($result5)) 
	{ ?>

		<ul id="country-list">
	<?php foreach($result5 as $Date) {?>

		<li onClick="selectCountry('<?php echo $Date->DateShipped; ?>');">
		<a href="/KTproj/users/station.php?RFID=<?=$Date->RFID?>"><?php echo $Date->DateShipped; ?></a></li>

	<?php } ?>
		</ul>
	<?php 

	}
	}
else
	{?>
		<script type="text/javascript"> disappear();</script>
	<?php
	}	

?>




