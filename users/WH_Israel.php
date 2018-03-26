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
<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/navigation.php'; ?>
<script src="http://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="http://www.amcharts.com/lib/3/serial.js"></script>
    <script src="http://www.amcharts.com/lib/3/plugins/responsive/responsive.min.js" type="text/javascript"></script>
    <script src="js/search.js" charset="utf-8"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="modify_station.js?"></script>
<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
//PHP Goes Here!
//$RFID = $_REQUEST['RFID'];
$RFID = "R96b659e";
$db = DB::getInstance();
$query1 = $db->query("SELECT * FROM $RFID ORDER BY Time ASC LIMIT 1");
  //$query1 = $db ->get('stations',['id','=',$StationID],false);
  $results=$query1->results();
 
  foreach($results as $a){
   $Pressure = $a->Pressure;
   $Voltage = $a->Voltage;
   $Current = $a->Current;
 }
 $query2 = $db->query("SELECT frus_LPN FROM rfids WHERE RFID = ?",array($RFID));
 $result2 = $query2->results();
 foreach ($result2 as $key) {
   $LPN = $key->frus_LPN;
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
        <p id="sitetitle" style="text-align: center; color:  #0e6889"><strong style="font-size: 200%">Warehouse Location: Israel  <!--?php echo $vale["p4"]?--> </strong></p>
      </div>
    </div>
  
    <div class="row" style="background-color: white">
      
              <div class=" col-md-4 col-xs-4 col-sm-2"></div>
                <div class=" col-md-4 col-xs-4 col-sm-2 btn-group-vertical ">
                  
                  
                  <button style="height:40px;width:50px;background-color: #3385ff" type="button" class="btn " id="button_control_HV" >S2</button>
                  <div class="dropdown">
                      <button style="height:40px;width:50px; background-color: blue" class="btn" type="button" data-toggle="dropdown">
                          <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                              <li><a href="#">LPN: <?php echo $LPN;?></a></li>
                              <li><a href="#">P: <?php printf("%e\n", $Pressure);;?> Torr</a></li>
                              <li><a href="#">V: <?php echo $Voltage;?></a></li>
                              <li><a href="#">I: <?php echo $Current;?></a></li>
                            </ul>
                  </div>
                  <button style="height:40px;width:50px;background: transparent;" type="button" class="btn " id="button_control_HV" >ID:2</button>
              </div>
      </div>
    </div>
</body>
 
  <!-- End of main content section -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

    <!-- Place any per-page javascript here -->
<script src="js/search.js" charset="utf-8"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="modify_warehouse.js"></script>
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
