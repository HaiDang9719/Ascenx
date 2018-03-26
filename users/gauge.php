<?php
/*
UserSpice 4
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>
<?php require_once 'init.php';?>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/header.php';?>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/navigation.php';?>
<script src="/KTproj/JS/amcharts/amcharts.js"></script>
    <script src="/KTproj/JS/amcharts/serial.js"></script>
    <script src="/KTproj/JS/responsive.min.js" type="text/javascript"></script>
    <script src="js/search.js" charset="utf-8"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="modify_station.js?"></script>
<?php if (!securePage($_SERVER['PHP_SELF'])) {die();}?>
<?php
//PHP Goes Here!
$GID     = $_REQUEST['GID'];
$query1  = $db->query("SELECT WHName FROM gauges WHERE id = ?", array($GID));
$results = $query1->results();
foreach ($results as $a) {
    $warehouseName = $a->WHName;
}

?>

<style type='text/css'>
    #chartdiv {

  height  : 500px;
}

  </style>

<body>
<br><br>
<div id="page-wrapper" style="background-color: white">

  <div class="container" style="background-color: white">
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <p id="sitetitle" style="text-align: center; color:  #0e6889"><strong style="font-size: 200%">Gauge <?php echo "G" . $GID ?> at <?php echo $warehouseName ?> <!--?php echo $vale["p4"]?--> </strong></p>
      </div>
    </div>

    <div class="row" style="background-color: white">
      <div id="chartdiv1" class="col-md-8 col-xs-12 col-sm-10" style="background-color: white">

        <div id="chartdiv" class="col-md-12 col-xs-12 col-sm-12"></div>
        <div id="RangeSelector" onchange="newRangeSelected()" class="col-md-12 col-xs-12 col-sm-12">
                <select class="form-control" name="pumpType" id="pumpType">
                        <option value="1">1 day</option>
                        <option value="3">3 days</option>
                        <option value="7">1 week</option>
                        <option value="30">1 month</option>
                        <option value="90">3 months</option>

                </select>
        </div>
      </div>
        <div class="col-md-4 col-xs-12 col-sm-2">


          <p> </p>

              <div class=" col-md-4 col-xs-4 col-sm-2"></div>

      </div>
    </div>
  </div>
</div>
</body>
<script >
function newRangeSelected()
{
  var anArray = [];
  var RangeValue = $('#RangeSelector').find(":selected").val();
  console.log(RangeValue);
  $.getJSON({
            type: "POST",
            url: 'gaugeDataService.php',
            data:

            {
            GID: '<?php echo $GID ?>',
            Range: RangeValue
            },

            success: function(data) {

              console.log("success");
              // console.log(data);
                chart.dataProvider = data;
                chart.validateData();

            }
            });
setInterval(function(){
  $.getJSON({
            type: "POST",
            url: 'gaugeDataService.php',
            data:

            {
            GID: '<?php echo $GID ?>',
            Range: RangeValue
            },

            success: function(data) {

              console.log("success");
              // console.log(data);
                chart.dataProvider = data;
                chart.validateData();

            }
            });
 }, 60000);
}

var aData = newRangeSelected();
             var chart = AmCharts.makeChart("chartdiv", {
            "type": "serial",


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
        "valueField":"Pressure",

        //"balloonText": "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>"

    },

    ],


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
    "categoryField": "Time",
    "categoryAxis": {
        "minPeriod": "ss",
        "parseDates": true,
        "dashLength": 1,
        "minorGridEnabled": true,
        "title":"Time"
    },
    "export": {
        "enabled": true
    },
     "responsive": {
    "enabled": true
  }
            });

            chart.addListener("drawn", zoomChart);

            zoomChart();

            function zoomChart() {
                chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);


            }
      </script>
  <!-- End of main content section -->

<?php require_once $abs_us_root . $us_url_root . 'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

    <!-- Place any per-page javascript here -->
<script src="js/search.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
