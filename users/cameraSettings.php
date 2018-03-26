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
if(!empty($_POST))
{
  

  if(!empty($_POST['addCamera']))
  {
    echo("DZOO");
    $Location = Input::get('Location');
    $Link = Input::get('Link');
    
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
        
      
        
    ));
    if($validation->passed()) 
      {
        $form_valid=TRUE;
        echo("Form valid = TRUE");
        try 
        {
          // echo "Trying to create user";
          $sql = $db->query("SELECT count(*) as total  FROM cameraSetting WHERE Link = ? ",array($Link));
          $result1 = $sql->results();
         foreach($result1 as $a){$num = $a->total;}
         echo $num;
        if ($num ==0){
          $fields=array(
            'Location' => Input::get('Location'),
            'Link' => Input::get('Link'),
             
          );
          $db->insert('cameraSetting',$fields);}
          else{
            $message = "You have to set different Link";
            echo "<script type='text/javascript'>alert('$message');</script>";
          }
          
          //$successes[] = lang("ACCOUNT_USER_ADDED");
        }
        catch (Exception $e) 
        {
          die($e->getMessage());
        }   
      } 
  }  
}

$queryCamera = $db->query("SELECT * FROM cameraSetting");
$resultCamera = $queryCamera->results();
$quey2 = $db->query("SELECT warehouseName FROM warehouses");
$result2 = $quey2->results();

foreach ($result2 as $key) {

  $data.= $key->warehouseName.",";
}
 //Fetch information for all warehouses
?>


<div id="page-wrapper">
  <div class="container">
    <!-- Page Heading -->
    <div class="row">
	   <div class="col-xs-12 col-md-6">
		    <h1>Manage Camera Setting</h1>
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
        <form class="form-signup" action="cameraSettings.php" method="POST" id="payment-form">
          <div class="well well-sm">
            <h3 class="form-signin-heading"> Manually add a camera</h3>
              <div class="form-group">
                <div class="col-xs-6 col-md-2">
               		<select class="form-control" name="Location" id="Location">
                    <?php foreach($result2 as $key) {?>
                    <option class="form-control" value="<?php echo $key->warehouseName?>"><?=$key->warehouseName?></option>
                    <?php }?>
                    </select>
                </div>
                <div class="col-xs-6 col-md-6">
               		<input type="text" class="form-control" id="Link" name="Link" placeholder="Link" value="<?php if (!$form_valid && !empty($_POST)){ echo $Link;} ?>" required>
                </div>
                
                
                </br></br>
              </div>
              <input type="hidden" value="<?=Token::generate();?>" name="csrf">
	            <input class='btn btn-primary' type='submit' name='addCamera' value='Manually Add Camera'/>
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
					   <thead >
					     <tr>
						    <th>id</th>
                <th>Location</th>
                <th>Link</th>
                <th>Modify</th>
					     </tr>
					   </thead>
				     <tbody >
              <?php
                //Cycle through users
                foreach ($resultCamera as $v1) {
              ?>
              <tr id="row<?php echo $v1->id;?>">
                <!--<td><div class="form-group"><input type="checkbox" name="delete[<?=$v1->warehouseName?>]" value="<?=$v1->warehouseName?>" /></div></td>-->
                <td><label class="form-control"><?=$v1->id?></label></td>
                <td id="WHName_val<?php echo $v1->id;?>">
                      <select class="form-control" name="selectWH" id="selectWH<?php echo $v1->id;?>">
                        <option value="<?php echo $v1->Location?>" ><?=$v1->Location?></option>
                      </select>
                    </td>
                <td ><label class="form-control" id="Link_val<?php echo $v1->id;?>"><a href='<?=$v1->Link?>' target="_blank"><?php echo $v1->Link;?></a></label></td>
                
                <td><input type="button" class="btn btn-primary" id ="edit_button_camera<?php echo $v1->id;?>" value="edit" onclick="edit_row_camera('<?php echo $v1->id;?>','<?php echo $data; ?>');"></td>
                <td><input type='button' class="btn btn-primary" id ="save_button_camera<?php echo $v1->id;?>" value="save" onclick="save_row_camera('<?php echo $v1->id;?>','<?php echo $data; ?>');"></td>
                <td><input type='button' class="btn btn-primary" id="delete_button_camera<?php echo $v1->id;?>" value="delete" onclick="delete_row_camera('<?php echo $v1->id;?>');"></td>
                
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
