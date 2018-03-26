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
$errors = $successes = [];
$form_valid=TRUE;

// dnd($permOps);

if(!empty($_POST))
{
  //if(!empty($_POST['delete']))
  //{
    //  $deletions = $_POST['delete'];
    //if ($deletion_count = deleteWarehouses($deletions)){
     // $successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
    //}
    //else {
     // $errors[] = lang("SQL_ERROR");
    //}
  //}

  if(!empty($_POST['addStation']))
  {
    echo("DZOO");
    $Time = date('Y-m-d H:i:s');
    $stationName = Input::get('stationName');
    
    $pumpType = $_POST['pumpType'];
    $pumpAddr = Input::get('pumpAddr');
    $pumpCH = Input::get('pumpCH');
    $sdcsAddr = Input::get('sdcsAddr');
    $sdcsCH = Input::get('sdcsCH');
    $thresholdDownP = Input::get('thresholdDownP');
    $thresholdUpP = Input::get('thresholdUpP');
    $thresholdUpI = Input::get('thresholdUpI');
    $thresholdDownI = Input::get('thresholdUpI');
    $RFID = Input::get('RFID');
    $token = $_POST['csrf'];

    echo $stationName;
    echo $token;
    echo $pumpType;
    if(!Token::check($token)){ die('Token doesn\'t match!');}  
    $form_valid=FALSE; // assume the worst
    $validation = new Validate();

    $validation->check($_POST,array(
      
      'stationName' => array(
      'display' => 'stationName',
      'required' => false,
      'min' => 2,
      'max' => 35,
      
      ),
      
      
    ));


    if($validation->passed()) 
      {

      $form_valid=TRUE;
       echo("Form valid = TRUE");
       try {
          // echo "Trying to create user";
          $fields=array(
              'warehouseName' =>$_REQUEST['warehouseName'],
              'stationName' => Input::get('stationName'),
              
              'pumpType' => Input::get('pumpType'),
              'pumpAddr' => Input::get('pumpAddr'),
              'pumpCH' => Input::get('pumpCH'),
              'sdcsAddr' => Input::get('sdcsAddr'),
              'sdcsCH' => Input::get('sdcsCH'),
              'thresholdDownP' => Input::get('thresholdDownP'),
              'thresholdUpP' => Input::get('thresholdUpP'),
              'thresholdUpI' => Input::get('thresholdUpI'),
              'thresholdDownI' => Input::get('thresholdUpI'),
              
              'Time' =>$Time,
          );
          $db->insert('stations',$fields);
          $successes[] = lang("ACCOUNT_USER_ADDED");
            }
        catch (Exception $e) 
          {
          die($e->getMessage());
          }   
        }
    
   
  }


if(!empty($_POST['editStation']))
  {
    if (!empty($_POST['check_list']))
      {
          foreach($_POST['edit_Multi_Row'] as $check) {
            echo $check."--------"; //echoes the value set in the HTML form for each checked checkbox.
                         //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
                         //in your case, it would echo whatever $row['Report ID'] is equivalent to.
            }

      }
    echo("DZOO");
    $Time_r = date('Y-m-d H:i:s');  
    $id_r = "12";
    $thresholdDownP_r = Input::get('thresholdDownP_r');
    $thresholdUpP_r = Input::get('thresholdUpP_r');
    $thresholdUpI_r = Input::get('thresholdUpI_r');
    $thresholdDownI_r = Input::get('thresholdUpI_r');
    $token_r = $_POST['csrf_r'];
    

     if(!Token::check($token_r)){ die('Token doesn\'t match!');}

      
      $form_valid_r=FALSE; // assume the worst
      $validation_r = new Validate();

      $validation_r->check($_POST,array(
      
      'thresholdDownP_r' => array(
      'display' => 'stationName',
      'required' => true,
      'min' => 2,
      'max' => 35,
      
      ),
      
      'thresholdUpP_r' => array(
      'display' => 'isEmpty',
      'required' => true,
      'min' => 2,
      'max' => 35,
      ),
      
      'thresholdUpI_r' => array(
      'display' => 'RFID',
      'required' => true,
      ),
    ));


      if($validation_r->passed()) 
      {

      $form_valid_r=TRUE;
       echo("Form valid = TRUE");
       try {
          // echo "Trying to create user";
          $fields=array(
              'thresholdDownP' => Input::get('thresholdDownP_r'),
              'thresholdUpP' => Input::get('thresholdUpP_r'),
              'thresholdUpI' => Input::get('thresholdUpI_r'),
              'thresholdDownI' => Input::get('thresholdUpI_r'),
              'Time' =>$Time_r,
          );
          if(!empty($_POST['edit_Multi_Row'])) {
            foreach($_POST['edit_Multi_Row'] as $check) {
            echo "aaaaaaaaaaaaaaa".$check.value; //echoes the value set in the HTML form for each checked checkbox.
                         //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
                         //in your case, it would echo whatever $row['Report ID'] is equivalent to.
    }
}
          $db->update('stations',$id_r,$fields);
          $successes[] = lang("ACCOUNT_USER_ADDED");
        }catch (Exception $e) 
          {
          die($e->getMessage());
            }   
      }
   
    }

    
  
}
//echo "-----------------------aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa".$_REQUEST['warehouseName'];
$stationData = fetchAllStations($_REQUEST['warehouseName']);
$nameOfWarehouse = $_REQUEST['warehouseName'];
 //Fetch information for all warehouses
?>

<div id="page-wrapper">

  <div class="container">

    <!-- Page Heading -->
    <div class="row">

      <div class="col-xs-12 col-md-6">
    <h1>Manage Stations at <?=$nameOfWarehouse?> Warehouse</h1> 
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
          <?php echo resultBlock($errors,$successes);
        ?>

               <hr />
               <div class="row">
               <div class="col-xs-12">
               <?php
               if (!$form_valid && Input::exists()){
                echo display_errors($validation->errors());
               }
               ?>

               <form class="form-signup" action="admin_stations.php?warehouseName=<?=$nameOfWarehouse?> " method="POST" id="payment-form">

                <div class="well well-sm">
                <h3 class="form-signin-heading"> Manually add Station 
                  </h3>

                <div class="form-group">
                  <div class="col-xs-2">
                  <input  class="form-control" type="text" name="stationName" id="stationName" placeholder="Station Name" value="<?php if (!$form_valid && !empty($_POST)){ echo $stationName;} ?>" required autofocus>
</div>
                  
                  
                  <div class="col-xs-2">
                  <!--input class="form-control" type="text" name="pumpType" id="pumpType" placeholder="Pump Type" value="<!?php if (!$form_valid && !empty($_POST)){ echo $pumpType;} ?>" required -->
                      <select class="form-control" name="pumpType" id="pumpType">
                        <option value="UHV2">UHV2</option>
                        <option value="UHV4">UHV4</option>
                        
                      </select>
                  </div>
                  
                  <div class="col-xs-2">
                  <input class="form-control" type="text" name="pumpAddr" id="pumpAddr" placeholder="Pump Address" value="<?php if (!$form_valid && !empty($_POST)){ echo $pumpAddr;} ?>" required >
                  </div>
                  
                  <div class="col-xs-2">
                  <input class="form-control" type="text" name="pumpCH" id="pumpCH" placeholder="pump Chanel" value="<?php if (!$form_valid && !empty($_POST)){ echo $pumpCH;} ?>" required >
                  </div>
                
                  <div class="col-xs-2">
                  <input class="form-control" type="text" name="sdcsAddr" id="sdcsAddr" placeholder="sdcs Address" value="<?php if (!$form_valid && !empty($_POST)){ echo $sdcsAddr;} ?>" required >
                  </div>
                  
                  <div class="col-xs-2">
                  <input class="form-control" type="text" name="sdcsCH" id="sdcsCH" placeholder="sdcs Chanel" value="<?php if (!$form_valid && !empty($_POST)){ echo $sdcsCH;} ?>" required >
                  </div>
                  
                  <div class="col-xs-2">
                  <input class="form-control" type="text" name="thresholdDownP" id="thresholdDownP" placeholder="thresholdDownP" value="<?php if (!$form_valid && !empty($_POST)){ echo $thresholdDownP;} ?>" required >
                  </div>
                  
                  <div class="col-xs-2">
                  <input class="form-control" type="text" name="thresholdUpP" id="thresholdUpP" placeholder="thresholdUpP" value="<?php if (!$form_valid && !empty($_POST)){ echo $thresholdUpP;} ?>" required >
                  </div>
                  
                  <div class="col-xs-2">
                  <input class="form-control" type="text" name="thresholdUpI" id="thresholdUpI" placeholder="thresholdUpI" value="<?php if (!$form_valid && !empty($_POST)){ echo $thresholdUpI;} ?>" required >
                  </div>
                  
                  <div class="col-xs-2">
                  <input class="form-control" type="text" name="thresholdDownI" id="thresholdDownI" placeholder="thresholdDownI" value="<?php if (!$form_valid && !empty($_POST)){ echo $thresholdDownI;} ?>" required >
                  </div>
                  
                  

                </div>
                  <br><br>
                <br /><br /><br><br>
                <input type="hidden" value="<?=Token::generate();?>" name="csrf">
                <br>
              <input class='btn btn-primary' type='submit' name='addStation' value='Manually Add Station' />
              <br><br>
              </div>
              </form>
           </form>

              
              




        <div class="row">
        <div class="col-xs-12">
         <div class="alluinfo">&nbsp;</div>
        <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
         <div class="allutable table-responsive">
          <table class='table table-hover table-list-search'>
          <thead>
          <tr>
            <th>Select</th><th>id</th><th>stationName</th><th>isEmpty</th><th>setRoughValveOn</th><th>setHVOn</th><th>setStationON</th><th>pumpType</th><th>pumpAddr</th><th>pumpCH</th><th>sdcsAddr</th><th>sdcsCH</th><th>thresholdDownP</th><th>thresholdUpP</th><th>thresholdUpI</th><th>thresholdDownI</th><th>RFID</th><th>warehouseName</th><th>Time</th><th>warehouseMAC</th>><th>setProtectOn</th><th>isPhase1</th><th>Modify</th>
           </tr>
          </thead>
         <tbody>
        <?php
          //Cycle through users
          foreach ($stationData as $v1) {
              ?>
          <tr id="row_val<?php echo $v1->id;?>">
          <td><div class="form-group"><input type="checkbox" name="edit_Multi_Row[<?=$v1->id?>]" value="<?=$v1->id?>" /></div></td>
          <td id="id_val<?php echo $v1->id;?>"><?=$v1->id?></td>
          <td id="stationName_val<?php echo $v1->id;?>"><?=$v1->stationName?></td>
          <td id="isEmpty_val<?php echo $v1->id;?>"><?=$v1->isEmpty?></td>
          <td id="setRoughValveOn_val<?php echo $v1->id;?>"><?=$v1->setRoughValveOn?></td>
          <td id="setHVOn_val<?php echo $v1->id;?>"><?=$v1->setHVOn?></td>
          <td id="setStationON_val<?php echo $v1->id;?>"><?=$v1->setStationON?></td>
          <td id="pumpType_val<?php echo $v1->id;?>"><?=$v1->pumpType?></td>
          <td id="pumpAddr_val<?php echo $v1->id;?>"><?=$v1->pumpAddr?></td>
          <td id="pumpCH_val<?php echo $v1->id;?>"><?=$v1->pumpCH?></td>
          <td id="sdcsAddr_val<?php echo $v1->id;?>"><?=$v1->sdcsAddr?></td>
          <td id="sdcsCH_val<?php echo $v1->id;?>"><?=$v1->sdcsCH?></td>
          <td id="thresholdDownP_val<?php echo $v1->id;?>"><?=$v1->thresholdDownP?></td>
          <td id="thresholdUpP_val<?php echo $v1->id;?>"><?=$v1->thresholdUpP?></td>
          <td id="thresholdUpI_val<?php echo $v1->id;?>"><?=$v1->thresholdUpI?></td>
          <td id="thresholdDownI_val<?php echo $v1->id;?>"><?=$v1->thresholdDownI?></td>
          <td id="RFID_val<?php echo $v1->id;?>"><?=$v1->RFID?></td>
          <td id="warehouseName_val<?php echo $v1->id;?>"><?=$v1->warehouseName?></td>
          <td id="Time_val<?php echo $v1->id;?>"><?=$v1->Time?></td>
          <td id="warehouseMAC_val<?php echo $v1->id;?>"><?=$v1->warehouseMAC?></td>
          <td id="setProtectOn_val<?php echo $v1->id;?>"><?=$v1->setProtectOn?></td>
          <td id="isPhase1_val<?php echo $v1->id;?>"><?=$v1->isPhase1?></td>
          <td><input type="button" class="edit_button" id ="edit_button<?php echo $v1->id;?>" value="edit" onclick="edit_row('<?php echo $v1->id;?>');"></td>
          <td><input type='button' class="save_button" id ="save_button<?php echo $v1->id;?>" name='button' value="save" onclick="save_row('<?php echo $v1->id;?>');"></td>
          <td><input type='button' class="delete_button" id="delete_button<?php echo $v1->id;?>" name='delete' value="delete" onclick="delete_row('<?php echo $v1->id;?>');"></td>
          
              <?php } ?>
          </tbody>
        </table>
        </div>
          
          

          </form>
        <!--input class='btn btn-primary' type='submit' name='editStation' value='Update' /><br><br-->
        
               </div>
               </div>
      </div>
    </div>


  </div>
</div>


  <!-- End of main content section -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

    <!-- Place any per-page javascript here -->
<script src="js/search.js" charset="utf-8"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="modify_station.js?"></script>

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
