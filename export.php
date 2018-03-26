<?php 
mysql_connect('localhost', 'klaremote', 'klaremote');
mysql_select_db('flipper');
$qry = mysql_query("SELECT * FROM CH1");
$data = "";
while($row = mysql_fetch_array($qry)) {
  $data .= $row['time'].",".$row['value']."\n";
}

header('Content-Type: application/csv');
header('Content-Disposition: attachement; filename="CH1.csv"');
echo $data; exit();
?>