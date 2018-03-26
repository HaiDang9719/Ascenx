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

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
//PHP Goes Here!
$sql = $db->query("SELECT count(*) as total  FROM stations");
    $result1 = $sql->results();
    foreach($result1 as $a){$numStationTotal = $a->total;}
    $RFID_null = "R0000";
    $sql = $db->query("SELECT count(*) as total  FROM stations WHERE RFID = ?",array($RFID_null));
    $result1 = $sql->results();
    foreach($result1 as $a){$numStationNotReal = $a->total;}
    $numStation = $numStationTotal - $numStationNotReal;
$status = "Arrived";
$query1 = $db->query("SELECT * FROM EgunTransaction WHERE status =?", array($status));
$EgunArrived = $query1->results();

$query_Egun_Arrived = $db->query("SELECT count(*) as total  FROM EgunTransaction WHERE status = ?",array($status));
    $result_Egun_Arrived = $query_Egun_Arrived->results();
    foreach ($result_Egun_Arrived as $arrived) {$numEgunArrived = $arrived->total;}
    $status = "shipped";
$query2 = $db->query("SELECT * FROM EgunTransaction WHERE status =?", array($status));
$EgunShipped = $query2->results();
    $query_Egun_Shipped = $db->query("SELECT count(*) as total  FROM EgunTransaction WHERE status = ?",array($status));
    $result_Egun_Shipped = $query_Egun_Arrived->results();
    foreach ($result_Egun_Shipped as $shipped) {$numEgunShipped = $shipped->total;}
$query3 = $db->query("SELECT count(*) as total  FROM rfids");
    $result3 = $query3->results();
    foreach($result3 as $a){$TotalEgun = $a->total;}
    $query4 = $db->query("SELECT *  FROM rfids");
    $result4 = $query4->results();
    

 //Fetch information for all warehouses
?>
<div id="page-wrapper">
  <div class="container">
    <!-- Page Heading -->
    <div class="row">
       <div class="col-xs-12 col-md-6">
            <h1>Statistics</h1>
       </div>
       <div class="col-xs-12 col-md-6">
            <form class="">
                <label for="system-search">Search:</label>
                <div class="input-group">
          <input class="form-control" id="system-search" name="q" placeholder="Search Users..." type="text">
          <span class="input-group-btn">
                     <button type="submit" class="btn btn-default"><i class="fa fa-times"></i></button>
          </span>
        </div>
             </form>
          </div>
    </div>


        <div class="row">
          <div class="col-md-12">
        <?php echo resultBlock($errors,$successes);?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <?php
          if (!$form_valid && Input::exists()){
            echo display_errors($validation->errors());
          }
        ?>
       <h3 style="color: red;font-weight: bold;"> Total Egun is being monitored: <?php echo $numStation;?></h3>
      </div>
    </div>
    <div class="row">
    <h3 style="color: red;font-weight: bold;">Egun Received Information: Total: <?php echo $numEgunArrived;?></h3>
      <div class="col-xs-12">
             <div class="alluinfo">&nbsp;</div>
               <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                  <div class="allutable table-responsive">
                     <table class='table table-hover table-list-search'>
                       <thead style="display:block ;">
                         <tr>
                            <th style="width: 140px">RFID</th>
                            <th style="width: 180px">LPN</th>
                            <th style="width: 195px">Time</th>
                            <th style="width: 100px">Location</th>
                            
                         </tr>
                       </thead>
                     <tbody style="display:block;height: 500px;overflow-y: auto;overflow-x: hidden;">
              <tr style="visibility: hidden;">
                <th >RFID</th><th>LPN</th><th>Time</th><th>Location</th>
              </tr>
              <?php
                //Cycle through users
                foreach ($EgunArrived as $v1) {
                    $Location3 = "";
                    $LPN1 = "";
                    $query_LPN = $db->query("SELECT LPN FROM frus WHERE RFID = ?",array($v1->RFID));
                    $result_LPN = $query_LPN->results();
                    foreach ($result_LPN as $key1) {$LPN1 = $key1->LPN;};
                    
                    $query_sN = $db->query("SELECT warehouseName FROM stations WHERE RFID = ?",array($v1->RFID));
                    $result_sN = $query_sN->results();
                    foreach ($result_sN as $key2) {$Location3 = $key2->warehouseName;}
              ?>
              <tr id="row<?php echo $v1->id;?>">
                <td ><label class="form-control"><a href='station.php?RFID=<?=$v1->RFID?>'><?=$v1->RFID?></a></label></td>
                <td ><label class="form-control"><?=$LPN1?></label></td>
                <td><label  class="form-control"><?=$v1->Time?></label></td>
                <td ><label class="form-control"><?=$Location3?></label></td>
                
              <?php } ?>
                     </tbody>
                    </table>
                  </div>
                </form>
          </div>
        </div>

        <div class="row">
    <h3 style="color: red;font-weight: bold;">Egun Shipped Information: Total: <?php echo $numEgunShipped;?></h3>
      <div class="col-xs-12">
             <div class="alluinfo">&nbsp;</div>
               <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                  <div class="allutable table-responsive">
                     <table class='table table-hover table-list-search'>
                       <thead style="display:block ;">
                         <tr>
                            <th style="width: 140px">RFID</th>
                            <th style="width: 180px">LPN</th>
                            <th style="width: 195px">Time</th>
                            <th style="width: 100px">Location</th>
                            
                         </tr>
                       </thead>
                     <tbody style="display:block;height: 500px;overflow-y: auto;overflow-x: hidden;">
              <tr style="visibility: hidden;">
                <th >RFID</th><th>LPN</th><th>Time</th><th>Location</th>
              </tr>
              <?php
                //Cycle through users
                foreach ($EgunShipped as $v1) {
                    $Location2="";
                    $LPN2 = "";
                    $query_LPN = $db->query("SELECT LPN FROM frus WHERE RFID = ?",array($v1->RFID));
                    $result_LPN = $query_LPN->results();
                    foreach ($result_LPN as $key1) {$LPN2 = $key1->LPN;};
                    
                    $query_sN = $db->query("SELECT warehouseName FROM stations WHERE RFID = ?",array($v1->RFID));
                    $result_sN = $query_sN->results();
                    foreach ($result_sN as $key2) {$Location2 = $key2->warehouseName;}
              ?>
              <tr id="row<?php echo $v1->id;?>">
                <td ><label class="form-control"><a href='station.php?RFID=<?=$v1->RFID?>'><?=$v1->RFID?></a></label></td>
                <td ><label class="form-control"><?=$LPN2?></label></td>
                <td><label  class="form-control"><?=$v1->Time?></label></td>
                <td ><label class="form-control"><?=$Location2?></label></td>
                
              <?php } ?>
                     </tbody>
                    </table>
                  </div>
                </form>
          </div>
        </div>

        <div class="row">
    <h3 style="color: red;font-weight: bold;">Egun Information: Total: <?php echo $TotalEgun;?></h3>
      <div class="col-xs-12">
             <div class="alluinfo">&nbsp;</div>
               <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                  <div class="allutable table-responsive">
                     <table class='table table-hover table-list-search'>
                       <thead style="display:block ;">
                         <tr>
                            <th style="width: 140px">RFID</th>
                            <th style="width: 180px">LPN</th>
                            <th style="width: 210px">Serial</th>
                            <th style="width: 100px">Location</th>
                            
                         </tr>
                       </thead>
                     <tbody style="display:block;height: 500px;overflow-y: auto;overflow-x: hidden;">
              <tr style="visibility: hidden;">
                <th >RFID</th><th>LPN</th><th>Time</th><th>Location</th>
              </tr>
              <?php
                //Cycle through users
                foreach ($result4 as $v1) {
                    $Location1="";
                    $LPN3 = "";
                    $query_LPN = $db->query("SELECT * FROM frus WHERE RFID = ?",array($v1->RFID));
                    $result_LPN = $query_LPN->results();
                    foreach ($result_LPN as $key1) {$LPN3 = $key1->LPN;$Serial = $key1->Serial;};
                    
                    $query_sN = $db->query("SELECT warehouseName FROM stations WHERE RFID = ?",array($v1->RFID));
                    $result_sN = $query_sN->results();
                    foreach ($result_sN as $key2) {$Location1 = $key2->warehouseName;}
              ?>
              <tr id="row<?php echo $v1->id;?>">
                <td ><label class="form-control"><a href='station.php?RFID=<?=$v1->RFID?>'><?=$v1->RFID?></a></label></td>
                <td ><label class="form-control"><?=$LPN3?></label></td>
                <td><label  class="form-control"><?=$Serial?></label></td>
                <td ><label class="form-control"><?=$Location1?></label></td>
                
              <?php } ?>
                     </tbody>
                    </table>
                  </div>
                </form>
          </div>
        </div>
  </div>
</div>

    <!-- End of main content section -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

    <!-- Place any per-page javascript here -->
<script src="js/search.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="modify_warehouse.js"></script>
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>

   