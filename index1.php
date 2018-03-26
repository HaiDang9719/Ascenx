<?php 
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

	require_once 'dbconnect.php';
	$db = mysql_select_db("flipper");

// Fetch the data
// Limit the data rows to optimize performance 
// only get 3 lastest days of data to show on the graph 
// 60*24*3 = 4320 rows 
$query = "(SELECT * FROM CH1 ORDER BY time DESC LIMIT 4320) ORDER BY time ASC";
$result = mysql_query( $query );

// Print out rows
$data = array();
while ( $row = mysql_fetch_assoc($result) ) {
  $data[] = $row;
}

$data_json = json_encode($data);

//echo($data_json);
mysql_free_result($result);




?>

       <!-- <p id="sitetitle" style="text-align: center; color:  #0e6889"><strong style="font-size: 200%">Flipper CH1</strong></p> -->
    <script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="http://www.amcharts.com/lib/3/serial.js"></script>
  <style type='text/css'>
    #chartdiv {
        position: absolute;
        top: 25%;
        left: 15%;
        
        margin-right: auto;
        margin-left: auto;
}

#boxdiv{
        position: absolute;
        top: 25%;
        left: 15%;
        width : 20%;
        height  : 600px;
        margin-right: auto;
        margin-left: auto;
}           
  </style>



<div id="page-wrapper">
<div class="container">
	<div class="page-header">
    	<h1><?php echo $config[0]?> - FLIPPER - HOME</h1>
    	</div>
        
        <div>
         <h3>Dew Points - CH1</h3>   
        </div>
        <div id="chartdiv" style="position: relative; width: 1000px; height: 600px; margin:0%; margin-left: 0%;"> </div>

</div> <!-- /container -->

</div> <!-- /#page-wrapper -->

<script>
var chartData = <?php echo $data_json; ?>;
var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "marginRight": 0,
    "autoMarginOffset": 0,
    "dataDateFormat": "YYYY-MM-DD JJ:NN:SS",
    "valueAxes": [{
        "id": "v1",
        "axisAlpha": 1,
        "position": "right",
        "logarithmic": false,
        
        "title" : "Celcius"
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
        "lineThickness": 1,///display line between bullets - 0 is no line
        "title": "red line",
        "useLineColorForBulletBorder": true,
        "valueField":"value" // BECAREFUL WITH THIS
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
    chart.zoomToIndexes(chart.dataProvider.length - 1440, chart.dataProvider.length - 1);
    chart.dataProvider.shift();
}

</script>
<!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->


<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
