<?php 
$conn = mysql_connect( 'localhost', 'klaremote', 'klaremote' );
//check location and load database
$location=$_REQUEST["location"];
if($location=="USA"){
    $database = "USA";
}
if($location=="Amsterdam"){
    $database = "Amsterdam";
}
if($location=="Taiwan_TN"){
    $database = "Taiwan_TN";
}
if($location=="Taiwan_HSC"){
    $database = "Taiwan_HSC";
}
if($location=="Fukuoka"){
    $database = "Fukuoka";
}
if($location=="Seoul"){
    $database = "Seoul";
}
if($location=="Tokyo"){
    $database = "Tokyo";
}
if($location=="Dublin"){
    $database = "Dublin";
}
if($location=="Singapore"){
    $database = "Singapore";
}
if($location=="Shanghai"){
    $database = "Shanghai";
}
if($location=="Israel"){
    $database = "Israel";
}
$db = mysql_select_db($database);
$find = "SELECT * FROM config WHERE time = (SELECT MAX(time) FROM config)";
$do = mysql_query($find,$conn);

$vale = mysql_fetch_assoc($do);
// Fetch the data
$query = "
  SELECT time,2STATION_P2_5
  FROM data";
$result = mysql_query( $query );

// Print out rows
$data = array();
while ( $row = mysql_fetch_assoc( $result ) ) {
  $data[] = $row;
}

$data_json = json_encode($data);
$que = "SELECT 2STATION_RFID_5 FROM data WHERE time =(SELECT MAX(time) FROM data)";
$do = mysql_query($que);

$row = mysql_fetch_assoc($do);
// Close the connection

mysql_free_result($do);
mysql_free_result($result);
mysql_free_result($do);
$rfid = $row['2STATION_RFID_5'];
$command = "SELECT * FROM rfid WHERE RFID_PN = '$rfid'";
$quer = mysql_query($command);
$rfinfo = mysql_fetch_assoc($quer);
mysql_free_result($quer);
mysql_close($conn);
mysql_close($conn);?>
<!DOCTYPE html>
<html>
<head>
  
    <meta http-equiv="refresh" content="300"/>
    
    
    
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Station Pressure Value</title>
  <script type='text/javascript' src='/js/lib/dummy.js'></script>
  <link rel="stylesheet" type="text/css" href="/css/normalize.css">
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  <style type='text/css'>
    #chartdiv {
        position: absolute;
        left: 0px;
	width	: 70%;
	height	: 500px;
}

#boxdiv{
        position: absolute;
        top: 50px;
        right: 50px; 
}						
  </style>
</head>
<body>
    <p id="sitetitle" style="text-align: center; color:  #0e6889"><strong style="font-size: 200%">Station <?php echo $vale["s5_2"]?> of SDCS <?php echo $vale["p5"]?> </strong></p>
    <script src="http://119.17.254.105/KTproj/JS/amcharts/amcharts.js"></script>
    <script src="http://119.17.254.105/KTproj/JS/amcharts/serial.js"></script>
      
<div id="chartdiv"></div>		
<script>
var chartData = <?php echo $data_json ?>;
var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "marginRight": 80,
    "autoMarginOffset": 20,
    "dataDateFormat": "YYYY-MM-DD JJ:NN:SS",
    "valueAxes": [{
        "id": "v1",
        "axisAlpha": 1,
        "position": "right",
        "logarithmic": true,
   
        "title" : "Torr"
    }],
    "mouseWheelZoomEnabled": true,
    "balloon": {
        "borderThickness": 1,
        "shadowAlpha": 0
    },
    "graphs": [{
        "id": "g1",
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletColor": "#FFFFFF",
        "bulletSize": 4,
        "hideBulletsCount": 50, //// this makes the chart to hide bullets when there are more than 50 series in selection
        "lineThickness": 1,
        "title": "red line",
        "useLineColorForBulletBorder": true,
        "valueField":"2STATION_P2_5"
        //"balloonText": "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>"
        
    }],
    "chartScrollbar": {
        "graph": "g1",
        "oppositeAxis":false,
        "offset":30,
        "scrollbarHeight": 80,
        "backgroundAlpha": 0,
        "selectedBackgroundAlpha": 0.1,
        "selectedBackgroundColor": "#888888",
        "graphFillAlpha": 0,
        "graphLineAlpha": 0.5,
        "selectedGraphFillAlpha": 0,
        "selectedGraphLineAlpha": 1,
        "autoGridCount":false,
        "color":"#000000"
    },
    "chartCursor": {
      "categoryBalloonDateFormat": "JJ:NN:SS DD MMMM",
      "cursorPosition": "mouse"
    },
    "categoryField": "time",
    "categoryAxis": {
        "minPeriod": "ss",
        "parseDates": true,
        "dashLength": 1,
        "minorGridEnabled": true,
        "title":"time"
    },
    "export": {
        "enabled": true
    },
    "dataProvider": chartData
    
});

chart.addListener("rendered", zoomChart);

zoomChart();

function zoomChart() {
    chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
    chart.dataProvider.shift();
}

</script>
<div id="boxdiv">
    <form>
    <p>ID of Electron Source: <?php echo $row['2STATION_RFID_5']?> </p> 
    <input type="button" value="Return to Warehouse" onclick="window.location.href='<?php echo("http://119.17.254.105/KTproj/warehouseUSA.php?location=$location");?>'" />
    <p>RFID Information</p>
    <p> </p>
    <table id="rfid-inforamtion">
            <tr>
                <th align="left">KT PN</th>
                <td><?php echo $rfinfo['KTPN'];?></td>
                
            </tr>
            <tr>
                <th align="left">KT Serial PN</th>
                <td><?php echo $rfinfo['KTSerialPN'];?></td>
            </tr>
            
            <tr>
                <th align="left">LPN</th>
                <td><?php echo $rfinfo['LicensePlatePN'];?></td>
            </tr>
            <tr>
                 <th align="left">Supplier Test Date</th>
                <td><?php echo $rfinfo['SupplierTestDate'];?></td>
            </tr>
            <tr>
                 <th align="left">MFG "Gun off GV Closed"</th>
                <td><?php echo $rfinfo['MFGGunOffGVClosed'];?></td>
                </tr>
                <tr>
                 <th align="left">Puchase Order</th>
                <td><?php echo $rfinfo['PurchasedOrder'];?></td>
                </tr>
                <tr>
                <th align="left">Date Received</th>
                <td><?php echo $rfinfo['DateReceive'];?></td>
                </tr>
                <tr>
                <th align="left">Date Shipped</th>
                <td><?php echo $rfinfo['DateShip'];?></td>
                </tr>
                
            </tr>
        </table>
    </form>
</div>
</body>

</html>