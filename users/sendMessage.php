<?php
require_once 'init.php';
if(!securePage($_SERVER['PHP_SELF'])){die();}

if(isset($_POST['sendMessageP2']))
{
	$title = $_POST['title'];
	$warehouse = $_POST['warehouse'];
	$email=$_POST['email'];
 	echo $email;
 	$db = DB::getInstance();
	generateAndSendMessageP2($title,$warehouse,$email);
	
 	echo "success";
 	exit();
}



?>