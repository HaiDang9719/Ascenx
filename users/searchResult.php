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


<?php if (!securePage($_SERVER['PHP_SELF'])) {die();}?>
<?php

$DateInStock = "";
$DateShipped = "";
$RFID = "";
$Serial = "";
$LPN = "";
$keyword = $_REQUEST['keyword'];
$db = DB::getInstance();
	$query1 = $db->query("SELECT * FROM rfids WHERE RFID like"."'".$keyword."%'");
	$result1 = $query1->results();
  $Title = "You have search follow RFID";
  if(count($result1) == 0){
    $query2 = $db->query("SELECT * FROM frus WHERE LPN like"."'".$keyword."%'");
  $result2 = $query2->results();
  $Title = "You have search follow LPN";
  if(count($result2) == 0){
     $query3 = $db->query("SELECT * FROM frus WHERE Serial like"."'".$keyword."%'");
  $result3 = $query3->results();
  $Title = "You have search follow Serial";
  if(count($result3) == 0){
     $query4 = $db->query("SELECT * FROM frus WHERE DateInStock like"."'".$keyword."%'");
  $result4 = $query4->results();
  $query5 = $db->query("SELECT * FROM frus WHERE DateShipped like"."'".$keyword."%'");
  $result5 = $query5->results();
  $Title = "You have search follow DateTime";
  if(count($result4) != 0 ){
    $DateInStock = "Date Received";
$RFID = "RFID";
$Serial = "Serial";
$LPN = "LPN";
  }
  
  if(count($result5) != 0 ){
    $DateShipped = "Date Shipped";
    $RFID = "RFID";
$Serial = "Serial";
$LPN = "LPN";
  }
  
  }
  }
  }

?>

<div id="page-wrapper">
  <div class="container">
    <!-- Page Heading -->
    <div class="row">
      <div class="col-xs-12">
        <div class="alluinfo">&nbsp;</div>
        <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="allutable table-responsive">
            <table class='table table-hover table-list-search'>
              <thead>
                <tr>
                  <th><strong><h3><?php echo $Title?></h3></strong></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  //Cycle through users

                
                  foreach ($result1 as $v1) {
                
                ?>
                <tr id="row_val_g">
                  <td><label class="form-control" id="id_val_g"><a href="/KTproj/users/station.php?RFID=<?=$v1->RFID?>"><?=$v1->RFID?></a></label></td>
                  
                 </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="alluinfo">&nbsp;</div>
        <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="allutable table-responsive">
            <table class='table table-hover table-list-search'>
              <thead>
                <tr>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  //Cycle through users

                
                  foreach ($result2 as $v1) {
                ?>
                <tr id="row_val_g">
                  <td><label class="form-control" id="id_val_g"><a href="/KTproj/users/station.php?RFID=<?=$v1->RFID?>"><?=$v1->LPN?></a></label></td>
                  
                 </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="alluinfo">&nbsp;</div>
        <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="allutable table-responsive">
            <table class='table table-hover table-list-search'>
              <thead>
                <tr>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  //Cycle through users

                
                  foreach ($result3 as $v1) {
                ?>
                <tr id="row_val_g">
                  <td><label class="form-control" id="id_val_g"><a href="/KTproj/users/station.php?RFID=<?=$v1->RFID?>"><?=$v1->Serial?></a></label></td>
                  
                 </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="alluinfo">&nbsp;</div>
        <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="allutable table-responsive">
            <table class='table table-hover table-list-search'>
              <thead>
                <tr>
                  <th><h4><?php echo $DateInStock?></h4></th><th><h4><?php echo $RFID?></h4></th><th><h4><?php echo $Serial?></h4></th><th><h4><?php echo $LPN?></h4></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  //Cycle through users

                
                  foreach ($result4 as $v1) {
                ?>
                <tr id="row_val_g">
                  <td><label class="form-control" id="id_val_g"><a href="/KTproj/users/station.php?RFID=<?=$v1->RFID?>"><?=$v1->DateInStock?></a></label></td>
                  <td><label class="form-control" id="id_val_g"><a href="/KTproj/users/station.php?RFID=<?=$v1->RFID?>"><?=$v1->RFID?></a></label></td>
                  <td><label class="form-control" id="id_val_g"><a href="/KTproj/users/station.php?RFID=<?=$v1->RFID?>"><?=$v1->Serial?></a></label></td>
                  <td><label class="form-control" id="id_val_g"><a href="/KTproj/users/station.php?RFID=<?=$v1->RFID?>"><?=$v1->LPN?></a></label></td>
                  
                 </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>            
    <div class="row">
      <div class="col-xs-12">
        <div class="alluinfo">&nbsp;</div>
        <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="allutable table-responsive">
            <table class='table table-hover table-list-search'>
              <thead>
                <tr>
                  <th><h4><?php echo $DateShipped?></h4></th><th><h4><?php echo $RFID?></h4></th><th><h4><?php echo $Serial?></h4></th><th><h4><?php echo $LPN?></h4></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  //Cycle through users

                
                  foreach ($result5 as $v1) {

                ?>
                <tr id="row_val_g">
                  <td><label class="form-control" id="id_val_g"><a href="/KTproj/users/station.php?RFID=<?=$v1->RFID?>"><?=$v1->DateShipped?></a></label></td>
                  <td><label class="form-control" id="id_val_g"><a href="/KTproj/users/station.php?RFID=<?=$v1->RFID?>"><?=$v1->RFID?></a></label></td>
                  <td><label class="form-control" id="id_val_g"><a href="/KTproj/users/station.php?RFID=<?=$v1->RFID?>"><?=$v1->Serial?></a></label></td>
                  <td><label class="form-control" id="id_val_g"><a href="/KTproj/users/station.php?RFID=<?=$v1->RFID?>"><?=$v1->LPN?></a></label></td>
                  
                 </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>                        
    </div>
  </div>


  <!-- End of main content section -->

<?php require_once $abs_us_root . $us_url_root . 'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

    <!-- Place any per-page javascript here -->
<script src="js/search.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; // currently just the closing /body and /html ?>

