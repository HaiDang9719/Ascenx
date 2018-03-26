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
    
    <script type="text/javascript" src="modify_station.js?"></script>
<?php if (!securePage($_SERVER['PHP_SELF'])) {die();}?>
<?php
//PHP Goes Here!
// $DaysOfSample = 1;
$RFID = $_REQUEST['RFID'];
$db = DB::getInstance();
if (!empty($_POST)) {
  if (!empty($_POST['ship_station'])){
    $currentTime = date('Y-m-d H:i:s');
    $status = "shipped";
    $query_ship1 = $db->query("UPDATE EgunTransaction SET Time = ?, status = ? WHERE RFID = ?",[$currentTime,$status,$RFID]);
    $result_ship1 = $query_ship1->results();
    $currentDate = date('Y-m-d');
    $query_ship2 = $db->query("UPDATE frus SET DateShipped = ? WHERE RFID = ?",[$currentDate,$RFID]);
    $result_ship2 = $query_ship2->results();
    generateAndSendMessageP4($RFID);
    $query_ship = $db->query("SELECT * FROM stations WHERE RFID = ?",array($RFID));
    $result_ship = $query_ship->results();
    foreach ($result_ship as $key) {
      $idS = $key->id;
    }
    $nullRFID = "R0000";
    $query_ship3 = $db->query("UPDATE stations SET RFID = ? WHERE id = ?",[$nullRFID,$idS]);
    $result_ship3 = $query_ship3->results();
    $currentUser = $user->data()->username;
   
   $Activity = "Ship Station";
   $field1 = array('Time' => $currentTime, 'user' => $currentUser, 'Activity' => $Activity);
   $db->insert('userActivityLog', $field1);

  }}

$query1  = $db->query("SELECT stationName, warehouseName FROM stations WHERE RFID = ?", array($RFID));
    $results = $query1->results();
    foreach ($results as $a) {$nameStation = $a->stationName;
      $nameWarehouse = $a->warehouseName;
    }
    $query2 = $db->query("SELECT * FROM stations WHERE RFID = ?",array($RFID));
                          $result2 = $query2->results(); 
                          if($result2 == NULL)
                              {
                                $stationshipped = "1";
                                $control_HV_status = "HV On";
                              $class_HV = "btn btn-default btn-block";
                              $control_Pr_status = "Protect On";
                              $class_Pr = "btn btn-default btn-block";
                              $control_S_status = "Station On";
                              $class_S = "btn btn-default btn-block";
                              }
                              else 
                              {
                                foreach ($result2 as $a) { 
                              
                              if($a->isPhase1 == "1"){
                                $Phase1 = "1";
                              }
                              else $Phase1 = "0";
                            if($a->setHVOn =="1") {
                              $control_HV_status = "HV Off";
                              $class_HV = "btn btn-warning btn-block";
                            }else if ($a->setHVOn == "0"){
                              $control_HV_status = "HV On";
                              $class_HV = "btn btn-success btn-block";
                            }
                            if($a->setProtectOn =="1") {
                              $control_Pr_status = "Protect Off";
                              $class_Pr = "btn btn-warning btn-block";
                            }else if ($a->setProtectOn == "0"){
                              $control_Pr_status = "Protect On";
                              $class_Pr = "btn btn-success btn-block";
                            }
                            if($a->setStationON =="1") {
                              $control_S_status = "Station Off";
                              $class_S = "btn btn-warning btn-block";
                            }else if ($a->setStationON == "0"){
                              $control_S_status = "Station On";
                              $class_S = "btn btn-success btn-block";
                            }
                              }                 
                            

                          }
                          

                          
    $query4 = $db->query("SELECT * FROM EgunTransaction WHERE RFID =?",array($RFID));
    $result4 = $query4->results();
    foreach ($result4 as $key) {
      if($key->status == "shipped")
      {
        $station_status ="shipped";
        $class_ship_station = "btn btn-default btn-block";
      }
      else 
      {
        $station_status ="ship";
        $class_ship_station = "btn btn-info btn-block";
      }
    }



$array = array();
$array1 = array();
$array_value = array("Pressure","Voltage","Current");
$array_value1 = array("round","square","triangleUp");
$array_Numberformater_PI = array();
$array_Numberformater_V = array();

// "numberFormatter": {
//             "precision": 13,
//             "decimalSeparator": ".",
//             "thousandsSeparator": ","
//         },
$array_Numberformater_PI['precision'] = 13;
$array_Numberformater_PI['decimalSeparator'] = ".";
$array_Numberformater_PI['thousandsSeparator'] = ",";

$array_Numberformater_V['precision'] = 2;
$array_Numberformater_V['decimalSeparator'] = ".";
$array_Numberformater_V['thousandsSeparator'] = ",";

if($Phase1 =="1"){   
    $array['id']="g1";
    $array['valueAxis']="v1";
    $array['bullet'] = $array_value1[0];
    $array['bulletBorderAlpha'] = "1";
    $array['bulletColor'] = "#FFFFFF";
    $array['bulletSize'] = 6;
    $array['hideBulletsCount'] = 50;
    $array['lineThickness'] = 1;
    $array['title'] = $array_value[0];
    $array['useLineColorForBulletBorder'] = true;
    $array['valueField'] = $array_value[0];
    $array['numberFormatter'] = $array_Numberformater_PI;
    $data_encode[] = $array;
    $array1['id']="v1";
    $array1['axisAlpha']=1;
    $array1['position'] = "right";
    $array1['logarithmic'] = true;
    
    
    $array1['showBalloon'] = true;
    $array1['animationPlayed'] = false;
    $array1['title'] = "Torr";
    
    $data_encode1[] = $array1;
  $data = json_encode($data_encode);
  //echo $data.$axes;
  $axes = json_encode($data_encode1);
}else{
  for ($i=0;$i<3;$i++){
    
    $array['id']="g".$i;
    $array['valueAxis']="v".$i;
    $array['bullet'] = $array_value1[$i];
    $array['bulletBorderAlpha'] = "1";
    $array['bulletColor'] = "#FFFFFF";
    $array['bulletSize'] = 6;
    $array['hideBulletsCount'] = 50;
    $array['lineThickness'] = 1;
    $array['title'] = $array_value[$i];
    $array['useLineColorForBulletBorder'] = true;
    $array['valueField'] = $array_value[$i];
    $array['numberFormatter'] = $array_Numberformater_PI;
    
    $array1['id']="v".$i;
    $array1['axisAlpha']=1;
    $array1['gridAlpha']=0;
    if($i==1){
      $array1['position'] = "left";
      $array1['title'] = "Volt";
      $array['numberFormatter'] = $array_Numberformater_V;
      $array1['offset']=0;
    }else{
      $array1['position'] = "right";
      if($i==0)
      {
        $array1['title'] = "Presure (Torr)";
        $array1['offset']=100;
      }
    else if($i==2){
      // $array1['offset']=100;
       // $array['valueAxis'] = "v0";
       $array1['title'] = "Current (Ampe)";
       $array1['offset']=0;
    }
    }
    
    $array1['logarithmic'] = true;

    
    $array1['showBalloon'] = true;
    $array1['animationPlayed'] = false;
    $data_encode[] = $array;
    $data_encode1[] = $array1;
    }   

$data = json_encode($data_encode);
$axes = json_encode($data_encode1);
}
$query11 = $db->query("SELECT * FROM warehouses WHERE warehouseName = ?", array($nameWarehouse));
$result11 = $query11->results();
foreach ($result11 as $t) {
  $timeZone = $t->timeZone;
}
// $NumberOfSamples = $DaysOfSample * 1440;
// $db              = DB::getInstance();
// $query1          = $db->query("SELECT * FROM $RFID ORDER BY Time ASC LIMIT $NumberOfSamples ");
// //$query1 = $db ->get('stations',['id','=',$StationID],false);
// $results = $query1->results();
// $data    = array();
// foreach ($results as $a) {$data[] = $a;}
// $data_json = json_encode($data);
?>

<style type='text/css'>
    #chartdiv {

  height  : 600px;
}

  </style>

<body>
<br><br>
<div id="page-wrapper" style="background-color: white">
  <div class="container" style="background-color: white">
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <p id="sitetitle" style="text-align: center; color:  #0e6889"><strong style="font-size: 200%">Station <?php echo $nameStation?> at <?php echo $nameWarehouse?> <!--?php echo $vale["p4"]?--> </strong></p>
      </div>
    </div>

    <div class="row" style="background-color: white">
      <div class="col-md-8 col-xs-12 col-sm-12 ">
        <div id="chartdiv"></div>
        <div id="RangeSelector" onchange="newRangeSelected()">
                <!-- <select class="form-control" name="pumpType" id="pumpType">
                        <option value="1">1 day</option>
                        <option value="3">3 days</option>
                        <option value="7">1 week</option>
                        <option value="30">1 month</option>
                        <option value="90">3 months</option>
                </select>   -->        
            <input id="dataPointInput" type="range" name="Datapoints" min="1" max = "500" value="1">              
        </div>
      </div>
      <div class="col-md-4 col-xs-12 col-sm-12" id="DropDownTimezone">
        TimeZone<select class="form-control" name="DropDownTimezone" id="DropDown" onchange="newRangeSelected()">
                  <option value="<?php echo $timeZone?>">Depot TimeZone: <?php echo $timeZone?></option>
                  <option value="GMT-8:00">USA TimeZone: GMT-8:00</option>
                  <option value="server">Server TimeZone: <?php echo date_default_timezone_get();?></option>
      
                </select>
        <p>ID of Electron Source: <?php echo $RFID ?> </p>
        <p>Information:                 
          <input type="button" class="" id ="edit_button_station" value="edit" onclick="edit_row_station();">
          <input type='button' class="" id ="save_button_station" value="save" onclick="save_row_station('<?php echo $RFID;?>');">
        </p>
        <p> </p>
          <?php
            $sql = $db->query("SELECT count(*) as total  FROM frus WHERE RFID = ?",array($RFID));
            $result1 = $sql->results();
            foreach($result1 as $a){$num = $a->total;}
            if ($num ==0){
              $field = array('RFID'=>$RFID);
              $db ->insert('frus',$field);
            }
            $query3 = $db->query("SELECT * FROM frus WHERE RFID = ?", array($RFID));
            $result3 = $query3->results();
            foreach ($result3 as $key) {
    
          ?>
            
            <table id="rfid-inforamtion" class="table table-hover">
                  <tr>
                      <th align="left">KT PN:</th>
                      <td id="PN_val"><?php echo $key->PN; ?></td>
                  </tr>
                  <tr>
                      <th align="left">KT Serial PN:</th>
                      <td id="Serial_val"><?php echo $key->Serial; ?></td>
                  </tr>
                  <tr>
                      <th align="left">LPN:</th>
                      <td id="LPN_val"><?php echo $key->LPN; ?></td>
                  </tr>
                  <tr>
                      <th align="left">Supplier Test Date:</th>
                      <td id="TestDate_val"><?php echo $key->TestDate; ?></td>
                  </tr>
                  <tr>
                      <th align="left">MFG "Gun off GV Closed":</th>
                      <td id="MFGPressure_val"><?php echo $key->MFGPressure; ?></td>
                  </tr>
                  <tr>
                      <th align="left">Puchase Order:</th>
                      <td id="PO_val"><?php echo $key->PO; ?></td>
                  </tr>
                  <tr>
                      <th align="left">Date Received:</th>
                      <td id="DateInStock_val"><?php echo $key->DateInStock; ?></td>
                  </tr>
                  <tr>
                      <th align="left">Date Shipped:</th>
                      <td id="DateShipped_val"><?php echo $key->DateShipped; ?></td>
                  </tr>
            </table>
              
          <?php }?>
          
            <div class=" col-md-6 col-xs-6 col-sm-4 ">
            <p>Control station : </p>
              <div class="btn-group-horizontal">
                  <button  type="button" class="<?=$class_HV?>"  id="button_control_HV"onclick="button_control_HV('<?php echo $RFID ?>')"><?php echo $control_HV_status ?></button>
                  <button  type="button" class="<?=$class_Pr?>" id="button_control_Pr"  onclick="button_control_Pr('<?php echo $RFID ?>')"><?php echo $control_Pr_status ?></button>
                  <button  type="button" class="<?=$class_S?>" id="button_control_S"  onclick="button_control_S('<?php echo $RFID ?>')"><?php echo $control_S_status ?></button>
              </div>
            </div>
            <div class=" col-md-6 col-xs-6 col-sm-4 ">
            <p>Ship station: </p>
            <form class="form-signup" action="station.php?RFID=<?=$RFID?>" method="POST" id="payment-form">
              <div class="btn-group-horizontal">
                  <input  type="submit" class="<?=$class_ship_station?>" name="ship_station"  id="ship_station" <?php if ($station_status == 'shipped'){ ?> disabled <?php   } ?> onclick="return confirm('Are you sure?')" value="<?php echo $station_status ?>">
              </div>
            </form>
            </div>
      </div>
    </div>
  </div>
</div>
</body>

<script >
var abc = {};
function newRangeSelected()
{
  var anArray = [];
  // var RangeValue = $('#RangeSelector').find(":selected").val();
  var RangeValue = $('#dataPointInput').val();
  var timeZ = $('#DropDownTimezone').find(":selected").val();
  console.log(RangeValue);

  // $.post('stationDataService.php',
  //   {
  //     RFID: '<?php echo $RFID ?>',
  //     Range: RangeValue
  //   }, function(data_json) { anArray =data_json;})
  $.getJSON({
            type: "POST",
            url: 'stationDataService.php',
            data:

            {
            RFID: '<?php echo $RFID ?>',
            timeZone: timeZ,
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
            url: 'stationDataService.php',
            data:

            {
            RFID: '<?php echo $RFID ?>',
            timeZone: timeZ,
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
            "legend": {
        "useGraphSettings": true,
        "logarithmic": true,
        "valueAlign": "left",
        "valueWidth": 150,

          

    },
  
             "dataDateFormat": "YYYY-MM-DD JJ:NN:SS",
              "valueAxes": <?php echo $axes;?>,
    "mouseWheelZoomEnabled": true,
    "balloon": {
        "borderThickness": 1,
        "shadowAlpha": 0
    },
    "graphs":<?php echo $data;?>,
     
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
