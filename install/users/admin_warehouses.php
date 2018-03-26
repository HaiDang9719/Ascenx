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
    echo("DZOO");
    $warehouseName = Input::get('warehouseName');
    $warehouseTitle = Input::get('warehouseTitle');
    $stationNumber = Input::get('stationNumber');
    $MAC = Input::get('MAC');
    $UHV4 = Input::get('UHV4');
    $UHV2 = Input::get('UHV2');
    $SDCS = Input::get('SDCS');
    $token = $_POST['csrf'];

    echo($warehouseName);
    echo($warehouseTitle);
    echo($MAC);
    echo($UHV4);
    echo($UHV2);
    echo($SDCS);
    echo($token);

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
      
      'warehouseTitle' => array(
      'display' => 'Warehouse Title',
      'required' => true,
      'min' => 2,
      'max' => 35,
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
      'min' => 2,
      'max' => 35,
      ),
      'UHV2' => array(
      'display' => 'UHV2',
      'required' => true,
      'min' => 2,
      'max' => 35,
      ),
      'SDCS' => array(
      'display' => 'SDCS',
      'required' => true,
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
            'warehouseName' => Input::get('warehouseName'),
            'warehouseTitle' => Input::get('warehouseTitle'),
             'stationNumber' => Input::get('stationNumber'),
              'MAC' => Input::get('MAC'),
              'UHV4' => Input::get('UHV4'),
              'UHV2' => Input::get('UHV2'),
              'SDCS' => Input::get('SDCS'),
          );
          $db->insert('warehouses',$fields);
          $successes[] = lang("ACCOUNT_USER_ADDED");
        }catch (Exception $e) 
          {
          die($e->getMessage());
            }   
      }
    
   
    }
  
}

$warehouseData = fetchAllWarehouses();
 //Fetch information for all warehouses
?>

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

               <form class="form-signup" action="admin_warehouses.php" method="POST" id="payment-form">

                <div class="well well-sm">
               	<h3 class="form-signin-heading"> Manually add a warehouse
                  </h3>

               	<div class="form-group">
                  <div class="col-xs-2">
               		<input  class="form-control" type="text" name="warehouseName" id="warehouseName" placeholder="Warehosue Name" value="<?php if (!$form_valid && !empty($_POST)){ echo $warehouseName;} ?>" required autofocus>
</div>
                  <div class="col-xs-2">
               		<input type="text" class="form-control" id="warehouseTitle" name="warehouseTitle" placeholder="Warehouse Title" value="<?php if (!$form_valid && !empty($_POST)){ echo $warehouseTitle;} ?>" required>
</div>
                  <div class="col-xs-2">
               		<input type="text" class="form-control" id="stationNumber" name="stationNumber" placeholder="Station Number" value="<?php if (!$form_valid && !empty($_POST)){ echo $stationNumber;} ?>" required>
</div>
                  <div class="col-xs-2">
               		<input  class="form-control" type="text" name="MAC" id="MAC" placeholder="MAC Address" value="<?php if (!$form_valid && !empty($_POST)){ echo $MAC;} ?>" required >
</div>            
                  <div class="col-xs-2">
                  <input class="form-control" type="text" name="UHV4" id="UHV4" placeholder="UHV4" value="<?php if (!$form_valid && !empty($_POST)){ echo $MAC;} ?>" required >
                  </div>
                  <div class="col-xs-2">
                  <input class="form-control" type="text" name="UHV2" id="UHV2" placeholder="UHV2" value="<?php if (!$form_valid && !empty($_POST)){ echo $MAC;} ?>" required >
                  </div>
                  <div class="col-xs-2">
                  <input class="form-control" type="text" name="SDCS" id="SDCS" placeholder="SDCS" value="<?php if (!$form_valid && !empty($_POST)){ echo $MAC;} ?>" required >
                  </div>

               	</div>

                <br /><br />
               	<input type="hidden" value="<?=Token::generate();?>" name="csrf">
	            <input class='btn btn-primary' type='submit' name='addWarehouse' value='Manually Add Warehouse' />
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
					<thead>
					<tr>
						<!--<th>Delete</th>--><th>id</th><th>WarehouseName</th><th>WarehouseTitle</th><th>StationNumber</th><th>MACaddr</th><th>UHV4</th><th>UHV2</th><th>SDCS</th><th>Modify</th>
					 </tr>
					</thead>
				 <tbody>
        <?php
          //Cycle through users
          foreach ($warehouseData as $v1) {
              ?>
          <tr id="row<?php echo $v1->id;?>">
          <!--<td><div class="form-group"><input type="checkbox" name="delete[<?=$v1->warehouseName?>]" value="<?=$v1->warehouseName?>" /></div></td>-->
          <td><?=$v1->id?></td>
          <td id="warehouseName_val1<?php echo $v1->id;?>"><a href='admin_stations.php?warehouseName=<?=$v1->warehouseName?>'><?=$v1->warehouseName?></a></td>
          <td id="warehouseTitle_val<?php echo $v1->id;?>"><?=$v1->warehouseTitle?></td>
          <td><?=$v1->stationNumber?></td>
          <td><?=$v1->MAC?></td>
          <td id="UHV4_val<?php echo $v1->id;?>"><?=$v1->UHV4?></td>
          <td id="UHV2_val<?php echo $v1->id;?>"><?=$v1->UHV2?></td>
          <td id="SDCS_val<?php echo $v1->id;?>"><?=$v1->SDCS?></td>
          <td><input type="button" class="edit_button" id ="edit_button<?php echo $v1->id;?>" value="edit" onclick="edit_row('<?php echo $v1->id;?>');"></td>
          <td><input type='button' class="save_button" id ="save_button<?php echo $v1->id;?>" value="save" onclick="save_row('<?php echo $v1->id;?>');"></td>
          <td><input type='button' class="delete_button" id="delete_button<?php echo $v1->id;?>" value="delete" onclick="delete_row('<?php echo $v1->id;?>');"></td>
          <td id="warehouseName_val2<?php echo $v1->id;?>" style="display: none"><?=$v1->warehouseName?></td>
              <?php } ?>
				  </tbody>
				</table>
				</div>

				<!--input class='btn btn-primary' type='submit' name='Submit' value='Update' /><br><br-->
				</form>

		  </div>
		</div>


  </div>
</div>


	<!-- End of main content section -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

    <!-- Place any per-page javascript here -->
<script src="js/search.js" charset="utf-8"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="modify_warehouse.js"></script>
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
