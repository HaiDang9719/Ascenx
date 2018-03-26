<?php 
require_once 'init.php'; 
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}

$errors = $successes = [];
$form_valid=TRUE;
if(!empty($_POST))
{
  /*
  if(!empty($_POST['delete']))
  {
      $deletions = $_POST['delete'];
    if ($deletion_count = deleteWarehouses($deletions)){
      $successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
    }
    else {
      $errors[] = lang("SQL_ERROR");
    }
  }*/

  if(!empty($_POST['addWarehouse']))
  {
    //echo("DZOO");
    $warehouseName = Input::get('warehouseName');
    $warehouseTitle = Input::get('warehouseTitle');
    $stationNumber = Input::get('stationNumber');
    $MAC = Input::get('MAC');
    $UHV4 = Input::get('UHV4');
    $UHV2 = Input::get('UHV2');
    $SDCS = Input::get('SDCS');
    $latitude = Input::get('latitude');
    $longitude = Input::get('longitude');
    $timeZone       = $_POST['timeZone'];
    $token = $_POST['csrf'];

    //test
      //echo($warehouseName);
      //echo($warehouseTitle);
      //echo($MAC);
      //echo($UHV4);
      //echo($UHV2);
      //echo($SDCS);
      //echo($token);

     if(!Token::check($token)){ die('Token doesn\'t match!');}
      $form_valid=FALSE; // assume the worst
      $validation = new Validate();
      $validation->check($_POST,array( 
        'warehouseName' => array(
          'display' => 'Warehouse Name',
          'required' => true,
          'min' => 2,
          'max' => 35,
          'unique' => 'warehouses',
        ),
      
      
        'stationNumber' => array(
          'display' => 'The Number of Station',
          'required' => true,
          'min' => 0,
          'max' => 50,
        ),
      
        'MAC' => array(
          'display' => 'MAC address',
          'required' => true,
        ),
        'UHV4' => array(
          'display' => 'UHV4',
          'required' => true,
          'min' => 0,
         'max' => 35,
        ),
        'UHV2' => array(
          'display' => 'UHV2',
          'required' => true,
          'min' => 0,
          'max' => 35,
        ),
        'SDCS' => array(
          'display' => 'SDCS',
          'required' => true,
          'min' => 0,
          'max' => 35,
        ),
    ));
    if($validation->passed()) 
      {
        $form_valid=TRUE;
        echo("Form valid = TRUE");
        try 
        {
          // echo "Trying to create user";
          $fields=array(
            'warehouseName' => Input::get('warehouseName'),
            'warehouseTitle' => Input::get('warehouseTitle'),
             'stationNumber' => Input::get('stationNumber'),
              'MAC' => Input::get('MAC'),
              'UHV4' => Input::get('UHV4'),
              'UHV2' => Input::get('UHV2'),
              'SDCS' => Input::get('SDCS'),
              'latitude' =>Input::get('latitude'),
              'longitude' => Input::get('longitude'),
              'timeZone'  =>Input::get('timeZone'),
          );
          $db->insert('warehouses',$fields);
          $field2 = array(
            'warehouseName' => Input::get('warehouseName'),
            'warehouseMAC'   => Input::get('MAC'),
            );
          for($i=0;$i<$stationNumber;$i++)
          {
              $db->insert('stations',$field2);
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

$warehouseData = fetchAllWarehouses();
$timeZone = "GMT-12:00,GMT-11:00,GMT-10:00,GMT-9:00,GMT-8:00,GMT-7:00,GMT-6:00,GMT-5:00,GMT-4:00,GMT-3:00,GMT-2:00,GMT-1:00,GMT,GMT+1:00,GMT+2:00,GMT+3:00,GMT+3:30,GMT+4:00,GMT+4:30,GMT+5:00,GMT+5:30,GMT+5:45,GMT+6:00,GMT+7:00,GMT+8:00,GMT+9:00,GMT+9:30,GMT+10:00,GMT+11:00,GMT+12:00,";


?>

<!DOCTYPE html>
<html>


<body>

        
   <div id="page-wrapper">
  <div class="container">
    <!-- Page Heading -->
    <div class="row">
         <div class="col-xs-12 col-md-6">
                <h1>Manage Warehouses</h1>
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
        <form class="form-signup" action="admin_warehouses.php" method="POST" id="payment-form">
          <div class="well well-sm">
            <h3 class="form-signin-heading"> Manually add a warehouse</h3>
              <div class="form-group">
                <div class="col-xs-6 col-md-2">
                        <input  class="form-control" type="text" name="warehouseName" id="warehouseName" placeholder="Warehouse Name" value="<?php if (!$form_valid && !empty($_POST)){ echo $warehouseName;} ?>" required autofocus>
                </div>
                <div class="col-xs-6 col-md-2">
                        <input type="text" class="form-control" id="warehouseTitle" name="warehouseTitle" placeholder="Warehouse Title" value="<?php if (!$form_valid && !empty($_POST)){ echo $warehouseTitle;} ?>" >
                </div>
                <div class="col-xs-6 col-md-2">
                        <input type="text" class="form-control" id="stationNumber" name="stationNumber" placeholder="Station Number" value="<?php if (!$form_valid && !empty($_POST)){ echo $stationNumber;} ?>" required>
                </div>
                <div class="col-xs-6 col-md-2">
                        <input  class="form-control" type="text" name="MAC" id="MAC" placeholder="MAC Address" value="<?php if (!$form_valid && !empty($_POST)){ echo $MAC;} ?>" required >
                </div>            
                <div class="col-xs-6 col-md-2">
                  <input class="form-control" type="text" name="UHV4" id="UHV4" placeholder="UHV4" value="<?php if (!$form_valid && !empty($_POST)){ echo $UHV4;} ?>" required >
                </div>
                <div class="col-xs-6 col-md-2">
                  <input class="form-control" type="text" name="UHV2" id="UHV2" placeholder="UHV2" value="<?php if (!$form_valid && !empty($_POST)){ echo $UHV2;} ?>" required >
                </div>
                <div class="col-xs-6 col-md-2">
                  <input class="form-control" type="text" name="SDCS" id="SDCS" placeholder="SDCS" value="<?php if (!$form_valid && !empty($_POST)){ echo $SDCS;} ?>" required >
                </div>
                <div class="col-xs-6 col-md-2">
                  <input class="form-control" type="text" name="latitude" id="latitude" placeholder="Latitude" value="<?php if (!$form_valid && !empty($_POST)){ echo $latitude;} ?>" required >
                </div>
                <div class="col-xs-6 col-md-2">
                  <input class="form-control" type="text" name="longitude" id="longitude" placeholder="Longitude" value="<?php if (!$form_valid && !empty($_POST)){ echo $longitude;} ?>" required >
                </div>
                <div class="col-xs-6 col-md-2">
                  <select class="form-control" name="timeZone" id="timeZone">
                    <?php 
                    $array = explode(",", $timeZone);
                    for($i=0;$i<count($array)-1;$i++) {?>
                    <option class="form-control" value="<?php echo $array[$i]?>"><?=$array[$i]?></option>
                    <?php }?>
                  </select>
                </div><br><br></br></br>
              </div>
              <input type="hidden" value="<?=Token::generate();?>" name="csrf">
                  <input class='btn btn-primary' type='submit' name='addWarehouse' value='Manually Add Warehouse'/>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
                   <div class="alluinfo">&nbsp;</div>
                     <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                          <div class="allutable table-responsive">
                               <table class='table table-hover table-list-search'>
                                 <thead style="display:block ;">
                                   <tr>
                                        <th style="width: 5%">id</th>
                <th style="width: 0.4%">WarehouseName</th>
                <th style="width: 0.1%">WarehouseTitle</th>
                <th style="width: 0.5%">StationNumber</th>
                <th style="width: 10%">MACaddr</th>
                <th style="width: 0.4%">UHV4</th>
                <th style="width: 0.3%">UHV2</th>
                <th style="width: 5%">SDCS</th>
                <th style="width: 8%">Latitude</th>
                <th style="width: 13%">Longitude</th>
                <th style="width: 8.5%">timeZone</th>

                <th>Modify</th>
                                   </tr>
                                 </thead>
                             <tbody style="display:block;height: 500px;overflow-y: auto;overflow-x: hidden;">
              <tr style="visibility: hidden;">
                <th >id</th><th>WarehouseName</th><th>WarehouseTitle</th><th>StationNumber</th><th>MACaddr</th><th>UHV4</th><th>UHV2</th><th>SDCS</th><th>Latitude</th><th>Longitude</th><th>timeZone</th><th>Modify</th>
              </tr>
              <?php
                //Cycle through users
                foreach ($warehouseData as $v1) {
              ?>
              <tr id="row<?php echo $v1->id;?>">
                <!--<td><div class="form-group"><input type="checkbox" name="delete[<?=$v1->warehouseName?>]" value="<?=$v1->warehouseName?>" /></div></td>-->
                <td><label class="form-control"><?=$v1->id?></label></td>
                <td id="warehouseName_val1<?php echo $v1->id;?>"><label class="form-control"><a href='admin_stations.php?warehouseName=<?=$v1->warehouseName?>'><?=$v1->warehouseName?></a></label></td>
                <td ><label class="form-control" id="warehouseTitle_val<?php echo $v1->id;?>"><?=$v1->warehouseTitle?></label></td>
                <td><label class="form-control"><?=$v1->stationNumber?></label></td>
                <td><label style="width: 140px" class="form-control"><?=$v1->MAC?></label></td>
                <td ><label class="form-control" id="UHV4_val<?php echo $v1->id;?>"><?=$v1->UHV4?></label></td>
                <td ><label class="form-control" id="UHV2_val<?php echo $v1->id;?>"><?=$v1->UHV2?></label></td>
                <td ><label class="form-control" id="SDCS_val<?php echo $v1->id;?>"><?=$v1->SDCS?></label></td>
                <td ><label class="form-control" id="latitude_val<?php echo $v1->id;?>"><?=$v1->latitude?></label></td>
                <td ><label class="form-control" id="longitude_val<?php echo $v1->id;?>"><?=$v1->longitude?></label></td>
                 
                 <td id="timeZone_val<?php echo $v1->id;?>" >
                      <select class="form-control" name="timeZone" id="timeZone<?php echo $v1->id;?>" style="width: 140px">
                        <option value="<?php echo $v1->timeZone?>" ><?=$v1->timeZone?></option>
                      </select>
                    </td>
                <td><input type="button" class="btn btn-primary" id ="edit_button<?php echo $v1->id;?>" value="edit" onclick="edit_row('<?php echo $v1->id;?>','<?php echo $timeZone; ?>');"></td>
                <td><input type='button' class="btn btn-primary" id ="save_button<?php echo $v1->id;?>" value="save" onclick="save_row('<?php echo $v1->id;?>','<?php echo $timeZone; ?>');"></td>
                <td><input type='button' class="btn btn-primary" id="delete_button<?php echo $v1->id;?>" value="delete" onclick="delete_row('<?php echo $v1->id;?>');"></td>
                <td id="warehouseName_val2<?php echo $v1->id;?>" style="display: none"><?=$v1->warehouseName?></td>
              <?php } ?>
                             </tbody>
                            </table>
                          </div>
                        </form>
              </div>
            </div>
  </div>
</div>         

    
  

<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

    <!-- Place any per-page javascript here -->
<script src="js/search.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="modify_warehouse.js"></script>
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
    
</body>
  <!--link rel="stylesheet" type="text/css" href="CSS/dotForMap.css"-->

</html>
