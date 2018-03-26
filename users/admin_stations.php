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
//PHP Goes Here!
$errors     = $successes     = [];
$form_valid = true;
$query_g_m = $db->query("SELECT MAC FROM warehouses WHERE warehouseName = ?", array($_REQUEST['warehouseName']));
$result_g_m = $query_g_m->results();
foreach ($result_g_m as $key) {
  $MAC_g = $key->MAC;
}

if (!empty($_POST)) 
{
  if (!empty($_POST['addGauge'])) 
  {
    //echo ("DZOO");
    $Time        = date('Y-m-d H:i:s');  
    $sdcsAddr       = Input::get('sdcsAddr');
    $thresholdDownP = Input::get('thresholdDownP');
    $thresholdUpP   = Input::get('thresholdUpP');
    $token          = $_POST['csrf'];
    //echo $stationName;
    //echo $token;
    //echo $pumpType;
    if (!Token::check($token)) {die('Token doesn\'t match!');}
    $form_valid = false; // assume the worst
    $validation = new Validate();
    $validation->check($_POST, array());
    if ($validation->passed()) 
    {
      $form_valid = true;
      echo ("Form valid = TRUE");
      try 
      {
        // echo "Trying to create user";
        $fields = array(
          'WHName'         => $_REQUEST['warehouseName'],
          'WHMac'          => $MAC_g,
          'sdcsAddr'       => Input::get('sdcsAddr'),
          'thresholdDownP' => Input::get('thresholdDownP'),
          'thresholdUpP'   => Input::get('thresholdUpP'),
          'Time'           => $Time,
        );
        $db->insert('gauges', $fields); 
        $successes[] = lang("ACCOUNT_USER_ADDED");
      } 
      catch (Exception $e)
      {
        die($e->getMessage());
      }
    }
  }
  if (!empty($_POST['addStation']))
  {
    echo ("DZOO");
    $Time           = date('Y-m-d H:i:s');
    $stationName    = Input::get('stationName');
    $pumpType       = $_POST['pumpType'];
    $pumpAddr       = Input::get('pumpAddr');
    $pumpCH         = Input::get('pumpCH');
    $sdcsAddr       = Input::get('sdcsAddr');
    $sdcsCH         = Input::get('sdcsCH');
    $thresholdDownP = Input::get('thresholdDownP');
    $thresholdUpP   = Input::get('thresholdUpP');
    $thresholdUpI   = Input::get('thresholdUpI');
    $thresholdDownI = Input::get('thresholdUpI');
    $RFID           = Input::get('RFID');
    $token          = $_POST['csrf'];

        //echo $stationName;
        //echo $token;
        //echo $pumpType;
    if (!Token::check($token)) {die('Token doesn\'t match!');}
    $form_valid = false; // assume the worst
    $validation = new Validate();
    $validation->check($_POST, array(
      'stationName' => array(
        'display'  => 'stationName',
        'required' => false,
        'min'      => 2,
        'max'      => 35,
       ),
    ));
    if ($validation->passed())
    {
      $form_valid = true;
      echo ("Form valid = TRUE");
      try 
      {
        // echo "Trying to create user";
        $fields = array(
          'warehouseName'  => $_REQUEST['warehouseName'],
          'stationName'    => Input::get('stationName'),
          'pumpType'       => Input::get('pumpType'),
          'pumpAddr'       => Input::get('pumpAddr'),
          'pumpCH'         => Input::get('pumpCH'),
          'sdcsAddr'       => Input::get('sdcsAddr'),
          'sdcsCH'         => Input::get('sdcsCH'),
          'thresholdDownP' => Input::get('thresholdDownP'),
          'thresholdUpP'   => Input::get('thresholdUpP'),
          'thresholdUpI'   => Input::get('thresholdUpI'),
          'thresholdDownI' => Input::get('thresholdUpI'),
          'Time'           => $Time,
          'warehouseMAC'   => $MAC_g,
        );
        $db->insert('stations', $fields);
        $query2  = $db->query("SELECT count(*) as total  FROM stations WHERE warehouseName = ?", array($_REQUEST['warehouseName']));
        $result2 = $query2->results();
        foreach ($result2 as $a) {$num = $a->total;}
        $query3      = $db->query("UPDATE warehouses SET stationNumber = ? WHERE warehouseName = ?", [$num, $_REQUEST['warehouseName']]);
        $result3     = $query3->results();
        $successes[] = lang("ACCOUNT_USER_ADDED");
      }
      catch (Exception $e)
      {
        die($e->getMessage());
      }
    }
  }
  $see = "not see";
  if (!empty($_POST['editStation']))
  {
    $see     = "see";
    $Time_r  = date('Y-m-d H:i:s');
    $token_r = $_POST['csrf'];
    if (!Token::check($token_r)) {die('Token doesn\'t match!');}
    $form_valid_r = false; // assume the worst
    $validation_r = new Validate();
    $validation_r->check($_POST, array(
      'thresholdDownP_r' => array(
        'display'  => 'stationName',
        'required' => true,
        'min'      => 2,
        'max'      => 35,
      ),
      'thresholdUpP_r'   => array(
        'display'  => 'isEmpty',
        'required' => true,
        'min'      => 2,
        'max'      => 35,
      ),
      'thresholdUpI_r'   => array(
        'display'  => 'RFID',
        'required' => true,
      ),
    ));
    if ($validation_r->passed())
    {
      $form_valid_r = true;
      echo ("Form valid = TRUE");
      try
      {
        // echo "Trying to create user";
        $fields = array(
          'thresholdDownP' => Input::get('thresholdDownP_r'),
          'thresholdUpP'   => Input::get('thresholdUpP_r'),
          'thresholdUpI'   => Input::get('thresholdUpI_r'),
          'thresholdDownI' => Input::get('thresholdUpI_r'),
          'Time'           => $Time_r,
        );
        if (!empty($_POST['checkboxes']))
        {
          $globalStationIDArray = explode(',', $_POST['checkboxes']);
          foreach ($globalStationIDArray as $globalStationID)
          {
            echo $globalStationID;
            if ($globalStationID !== -1)
            {
              $db->update('stations', $globalStationID, $fields);
            }
          }
        }
        $successes[] = lang("ACCOUNT_USER_ADDED");
      }
      catch (Exception $e)
      {
        die($e->getMessage());
      }
    }
  }
}
//echo "-----------------------aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa".$_REQUEST['warehouseName'];
$stationData     = fetchAllStations($_REQUEST['warehouseName']);
$nameOfWarehouse = $_REQUEST['warehouseName'];
$query_g_1       = $db->query("SELECT * FROM gauges WHERE WHName = ?", array($nameOfWarehouse));
$result_g_1      = $query_g_1->results();
//Fetch information for all warehouses

//generate a local token for POST requests

$postToken = Token::generate();

?>

<div id="page-wrapper">
  <div class="container">
    <!-- Page Heading -->
    <div class="row">
      <div class="col-xs-12 col-md-12">
        <h1>Manage Stations at <?=$nameOfWarehouse?> Depot <?=$see?></h1>
      </div>
      <div class="col-xs-12 col-md-6">
        <!--form class="">
          <label for="system-search">Search:</label>
          <div class="input-group">
                    <input class="form-control" id="system-search" name="q" placeholder="Search Users..." type="text">
                    <span class="input-group-btn">
            <button type="submit" class="btn btn-default"><i class="fa fa-times"></i></button>
                    </span>
                </div>
        </form-->
      </div>
    </div>


    <div class="row">
      <div class="col-md-12">
        <?php echo resultBlock($errors, $successes);
        ?>
      </div>
    </div>  
    <div class="row">
      <div class="col-md-12">
        <?php
          if (!$form_valid && Input::exists())
          {
            echo display_errors($validation->errors());
          }
        ?>
        <form class="form-signup" action="admin_stations.php?warehouseName=<?=$nameOfWarehouse?> " method="POST" id="payment-form">
          <div class="well well-sm">
            <h3 class="form-signin-heading"> Manually add Gauge</h3>
            <div class="form-group">
              <div class="col-xs-6 col-md-4">
                <input class="form-control" type="text" name="sdcsAddr" id="sdcsAddr" placeholder="sdcs Address" value="<?php if (!$form_valid && !empty($_POST)) {echo $sdcsAddr;}?>" required >
              </div>
              <div class="col-xs-6 col-md-4">
                <input class="form-control" type="text" name="thresholdDownP" id="thresholdDownP" placeholder="thresholdDownP" value="<?php if (!$form_valid && !empty($_POST)) {echo $thresholdDownP;}?>" required >
              </div>
              <div class="col-xs-6 col-md-4">
                <input class="form-control" type="text" name="thresholdUpP" id="thresholdUpP" placeholder="thresholdUpP" value="<?php if (!$form_valid && !empty($_POST)) {echo $thresholdUpP;}?>" required >
              </div><br></br>
            </div> 
            <input type="hidden" value="<?=$postToken;?>" name="csrf">
            <input class='btn btn-primary' type='submit' name='addGauge' value='Manually Add Gauge' />
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
                  <th>id</th><th>sdcsAddr</th><th>WHName</th><th>WHMac</th><th>Time</th><th>thresholdDownP</th><th>thresholdUpP</th><th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  //Cycle through users
                  foreach ($result_g_1 as $v1) {
                ?>
                <tr id="row_val_g<?php echo $v1->id; ?>">
                  <td><label class="form-control" id="id_val_g<?php echo $v1->id; ?>"><?=$v1->id?></label></td>
                  <td><label class="form-control" id="sdcsAddr_val_g<?php echo $v1->id; ?>"><?=$v1->sdcsAddr?></label></td>
                  <td><label class="form-control" id="WHName_val_g<?php echo $v1->id; ?>"><?=$v1->WHName?></label></td>
                  <td><label class="form-control" id="WHMac_val_g<?php echo $v1->id; ?>"><?=$v1->WHMac?></label></td>
                  <td><label class="form-control" id="Time_val_g<?php echo $v1->id; ?>"><?=$v1->Time?></label></td>
                  <td><label class="form-control" id="thresholdDownP_val_g<?php echo $v1->id; ?>"><?php printf("%.2e\n", $v1->thresholdDownP)?></label></td>
                  <td><label class="form-control" id="thresholdUpP_val_g<?php echo $v1->id; ?>"><?php printf("%.2e\n", $v1->thresholdUpP)?></label></td>
                  <td><input type="button" class="btn btn-primary" id ="edit_button_g<?php echo $v1->id; ?>" value="edit" onclick="edit_row_g('<?php echo $v1->id; ?>');"></td>
                  <td><input type='button' class="btn btn-primary" id ="save_button_g<?php echo $v1->id; ?>" name='button' value="save" onclick="save_row_g('<?php echo $v1->id; ?>');"></td>
                  <td><input type='button' class="btn btn-primary" id="delete_button_g<?php echo $v1->id; ?>" name='delete' value="delete" onclick="delete_row_g('<?php echo $v1->id; ?>','<?php echo $v1->warehouseName; ?>');"></td>
                <?php }?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <?php echo resultBlock($errors, $successes);
        ?>
      </div>
    </div>  


    <div class="row">
      <div class="col-md-6">
        <?php
          if (!$form_valid && Input::exists())
          {
            echo display_errors($validation->errors());
          }
        ?>
        <form class="form-signup" action="admin_stations.php?warehouseName=<?=$nameOfWarehouse?> " method="POST" id="payment-form">
          <div class="well well-sm">
            <h3 class="form-signin-heading"> Manually add Station</h3>
              <div class="form-group" >
                <div class="col-xs-6 col-md-4">
                  <input  class="form-control" type="text" name="stationName" id="stationName" placeholder="Station Name" value="<?php if (!$form_valid && !empty($_POST)) {echo $stationName;}?>" required autofocus>
                </div>
                <div class="col-xs-6 col-md-4">
                  <select class="form-control" name="pumpType" id="pumpType">
                    <option value="1">UHV2</option>
                    <option value="2">UHV4</option>
                  </select>
                </div>
                <div class="col-xs-6 col-md-4">
                  <input class="form-control" type="text" name="pumpAddr" id="pumpAddr" placeholder="Pump Address" value="<?php if (!$form_valid && !empty($_POST)) {echo $pumpAddr;}?>" required >
                </div>
                <div class="col-xs-6 col-md-4">
                  <input class="form-control" type="text" name="pumpCH" id="pumpCH" placeholder="pump Chanel" value="<?php if (!$form_valid && !empty($_POST)) {echo $pumpCH;}?>" required >
                </div>
                <div class="col-xs-6 col-md-4">
                  <input class="form-control" type="text" name="sdcsAddr" id="sdcsAddr" placeholder="sdcs Address" value="<?php if (!$form_valid && !empty($_POST)) {echo $sdcsAddr;}?>" required >
                </div>
                <div class="col-xs-6 col-md-4">
                  <input class="form-control" type="text" name="sdcsCH" id="sdcsCH" placeholder="sdcs Chanel" value="<?php if (!$form_valid && !empty($_POST)) {echo $sdcsCH;}?>" required >
                </div>
                <div class="col-xs-6 col-md-4">
                  <input class="form-control" type="text" name="thresholdDownP" id="thresholdDownP" placeholder="thresholdDownP" value="<?php if (!$form_valid && !empty($_POST)) {echo $thresholdDownP;}?>" required >
                </div>
                <div class="col-xs-6 col-md-4">
                  <input class="form-control" type="text" name="thresholdUpP" id="thresholdUpP" placeholder="thresholdUpP" value="<?php if (!$form_valid && !empty($_POST)) {echo $thresholdUpP;}?>" required >
                </div>
                <div class="col-xs-6 col-md-4">
                  <input class="form-control" type="text" name="thresholdUpI" id="thresholdUpI" placeholder="thresholdUpI" value="<?php if (!$form_valid && !empty($_POST)) {echo $thresholdUpI;}?>" required >
                </div>
                <div class="col-xs-6 col-md-4">
                  <input class="form-control" type="text" name="thresholdDownI" id="thresholdDownI" placeholder="thresholdDownI" value="<?php if (!$form_valid && !empty($_POST)) {echo $thresholdDownI;}?>" required >
                </div><br></br>
              </div>
              <input type="hidden" value="<?=$postToken;?>" name="csrf">
              <input class='btn btn-primary' type='submit' name='addStation' value='Manually Add Station' />
            </div>
          </form>
        </div>
        <div class="col-md-6">
          <form class="form-signup" action="admin_stations.php?warehouseName=<?=$nameOfWarehouse?> " method="POST" id="editForm" >
            <div class="well well-sm">
              <h3 class="form-signin-heading"> Manually Edit Selected Station</h3>
                <div class="form-group" >
                  <div class="col-xs-6 col-md-4">
                    <input class="form-control" type="text" name="thresholdDownP_r" id="thresholdDownP_r" placeholder="thresholdDownP" value="<?php if (!$form_valid_r && !empty($_POST)) {echo $thresholdDownP_r;}?>" required >
                  </div>
                  <div class="col-xs-6 col-md-4">
                    <input class="form-control" type="text" name="thresholdUpP_r" id="thresholdUpP_r" placeholder="thresholdUpP" value="<?php if (!$form_valid_r && !empty($_POST)) {echo $thresholdUpP_r;}?>" required >
                  </div>
                  <div class="col-xs-6 col-md-4">
                    <input class="form-control" type="text" name="thresholdUpI_r" id="thresholdUpI_r" placeholder="thresholdUpI" value="<?php if (!$form_valid_r && !empty($_POST)) {echo $thresholdUpI_r;}?>" required >
                  </div>
                  <div class="col-xs-6 col-md-4">
                    <input class="form-control" type="text" name="thresholdDownI_r" id="thresholdDownI_r" placeholder="thresholdDownI" value="<?php if (!$form_valid_r && !empty($_POST)) {echo $thresholdDownI_r;}?>" required >
                  </div><br><br></br></br>
                </div>
                <input type="hidden" value="<?=$postToken;?>" name="csrf">
                <input class='btn btn-primary' type='submit' name='editStation'  value='Update Selected Station'/>
            </div>
          </form>
        </div>
      </div>


      <div class="row" >
        <div class="col-xs-12" >
        <div class="alluinfo">&nbsp;</div>
        <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="allutable table-responsive">
            <table class='table table-hover table-list-search' >  
              <thead style="display:block;">
                <tr >
                  <th style="width: 0.2%"><input type="button" value="Select All" id="myButton" class="btn btn-primary btn-xs"></th>
                    <script type="text/javascript">
                      $(function(){
                        $('#myButton').click(function(){
                          var select_all = (this.value === 'Select All');
                          $('input:checkbox').attr('checked', select_all);
                          this.value = (select_all) ? 'Deselect All' : 'Select All';        
                        });
                      });
                    </script>
                  <th style="width: 1.7%">id</th>
                  <th style="width: 0.4%">stationName</th>
                  <th style="width: 0.4%">isEmpty</th>
                  <th style="width: 0.4%">setRoughValveOn</th>
                  <th style="width: 0.4%">setHVOn</th>
                  <th style="width: 0.4%">setStationON</th>
                  <th style="width: 0.4%">pumpType</th>
                  <th style="width: 0.4%">pumpAddr</th>
                  <th style="width: 0.4%">pumpCH</th>
                  <th style="width: 0.4%">sdcsAddr</th>
                  <th style="width: 0.4%">sdcsCH</th>
                  <th style="width: 0.4%">thresholdDownP</th>
                  <th style="width: 0.4%">thresholdUpP</th>
                  <th style="width: 0.4%">thresholdUpI</th>
                  <th style="width: 0.4%">thresholdDownI</th>
                  <th style="width: 5.1%">RFID</th>
                  <th style="width: 0.4%">warehouseName</th>
                  <th style="width: 8.3%">Time</th>
                  <th style="width: 6%">warehouseMAC</th>
                  <th style="width: 0.4%">setProtectOn</th>
                  <th style="width: 0.4%">isPhase1</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody style="display:block;height: 500px;overflow-y: auto;">
                <tr style="visibility: hidden;">
                  <th>Select</th><th >id</th><th>stationName</th><th>isEmpty</th><th>setRoughValveOn</th><th>setHVOn</th><th>setStationON</th><th>pumpType</th><th>pumpAddr</th><th>pumpCH</th><th>sdcsAddr</th><th>sdcsCH</th><th>thresholdDownP</th><th>thresholdUpP</th><th>thresholdUpI</th><th>thresholdDownI</th><th >RFID</th><th>warehouseName</th><th>Time</th><th >warehouseMAC   </th><th>setProtectOn</th><th>isPhase1</th><th>Modify</th>
                </tr>
                <?php
                  //Cycle through users
                  foreach ($stationData as $v1) {
                ?>
                <tr id="row_val<?php echo $v1->id; ?>">
                  <td><label ><input type="hidden" class="form-control" value="0" name="edit_Multi_Row"><input style="width: 30px;height:30px; float:left;clear:left;" type="checkbox" name="edit_Multi_Row" onchange="toggleCheckbox(this)" value="<?=$v1->id?>"/></label></td>
                  <td><label class="form-control" id="id_val<?php echo $v1->id; ?>"><?=$v1->id?></label></td>
                  <td><label class="form-control" id="stationName_val<?php echo $v1->id; ?>"><?=$v1->stationName?></label></td>
                  <td><label class="form-control" id="isEmpty_val<?php echo $v1->id; ?>"><?=$v1->isEmpty?></label></td>
                  <td><label class="form-control" id="setRoughValveOn_val<?php echo $v1->id; ?>"><?=$v1->setRoughValveOn?></label></td>
                  <td><label class="form-control" id="setHVOn_val<?php echo $v1->id; ?>"><?=$v1->setHVOn?></label></td>
                  <td><label class="form-control" id="setStationON_val<?php echo $v1->id; ?>"><?=$v1->setStationON?></label></td>
                  <td><label class="form-control" id="pumpType_val<?php echo $v1->id; ?>"><?=$v1->pumpType?></label></td>
                  <td><label class="form-control" id="pumpAddr_val<?php echo $v1->id; ?>"><?=$v1->pumpAddr?></label></td>
                  <td><label class="form-control" id="pumpCH_val<?php echo $v1->id; ?>"><?=$v1->pumpCH?></label></td>
                  <td><label class="form-control" id="sdcsAddr_val<?php echo $v1->id; ?>"><?=$v1->sdcsAddr?></label></td>
                  <td><label class="form-control" id="sdcsCH_val<?php echo $v1->id; ?>"><?=$v1->sdcsCH?></label></td>
                  <td><label class="form-control" id="thresholdDownP_val<?php echo $v1->id; ?>"><?php printf("%.2e\n", $v1->thresholdDownP)?></label></td>
                  <td><label class="form-control" id="thresholdUpP_val<?php echo $v1->id; ?>"><?php printf("%.2e\n", $v1->thresholdUpP)?></label></td>
                  <td><label class="form-control" id="thresholdUpI_val<?php echo $v1->id; ?>"><?php printf("%.2e\n", $v1->thresholdUpI)?></label></td>
                  <td><label class="form-control" id="thresholdDownI_val<?php echo $v1->id; ?>"><?php printf("%.2e\n", $v1->thresholdDownI)?></label></td>
                  <td><label class="form-control" id="RFID_val<?php echo $v1->id; ?>"><?=$v1->RFID?></label></td>
                  <td><label class="form-control" id="warehouseName_val<?php echo $v1->id; ?>"><?=$v1->warehouseName?></label></td>
                  <td><label style="width: 200px" class="form-control" id="Time_val<?php echo $v1->id; ?>"><?=$v1->Time?></label></td>
                  <td><label style="width: 140px" class="form-control" id="warehouseMAC_val<?php echo $v1->id; ?>"><?=$v1->warehouseMAC?></label></td>
                  <td><label class="form-control" id="setProtectOn_val<?php echo $v1->id; ?>"><?=$v1->setProtectOn?></label></td>
                  <td><label class="form-control" id="isPhase1_val<?php echo $v1->id; ?>"><?=$v1->isPhase1?></label></td>
                  <td><input type="button" class="btn btn-primary" id ="edit_button<?php echo $v1->id; ?>" value="edit" onclick="edit_row('<?php echo $v1->id; ?>');"></td>
                  <td><input type='button' class="btn btn-primary" id ="save_button<?php echo $v1->id; ?>" name='button' value="save" onclick="save_row('<?php echo $v1->id; ?>');"></td>
                  <td><input type='button' class="btn btn-primary" id="delete_button<?php echo $v1->id; ?>" name='delete' value="delete" onclick="delete_row('<?php echo $v1->id; ?>','<?php echo $v1->warehouseName; ?>');"></td>
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
<script type="text/javascript" src="modify_station.js?"></script>

<script type="text/javascript">

function toggleCheckbox(element)
 {
   // element.checked = !element.checked;
   console.log(element);
 }

 function scanCheckbox()
 {
  console.log("function activated");
 }

$( "#editForm" ).submit(function( event ) {
  event.preventDefault();

  // get the checked boxes
var sList = [];
$('input[type=checkbox]').each(function () {
    var sThisVal = (this.checked ? this.value : "-1");
    // sList += (sList=="" ? sThisVal : "," + sThisVal);
    sList.push(sThisVal);
});

console.log (sList);



var input = $("<input>")
               .attr("type", "hidden")
               .attr("name", "checkboxes").val(sList);

var input1 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "editStation").val("11");
$('#editForm').append($(input));
$('#editForm').append($(input1));

this.submit();


});

</script>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
