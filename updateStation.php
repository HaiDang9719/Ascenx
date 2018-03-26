<?php
require_once 'users/init.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}
$station_decoded  = json_decode(file_get_contents("php://input"), true);
?>
