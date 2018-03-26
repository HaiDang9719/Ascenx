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
/*if(!empty($_POST))
{
  
  if(!empty($_POST['delete']))
  {
      $deletions = $_POST['delete'];
    if ($deletion_count = deleteWarehouses($deletions)){
      $successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
    }
    else {
      $errors[] = lang("SQL_ERROR");
    }
  }

  if(!empty($_POST['addNoti']))
  {
    echo("DZOO");
    $WHName       = $_POST['WHName'];
    $Name       = $_POST['Name'];
    $Priority     = $_POST['Priority'];

    $token = $_POST['csrf'];

     if(!Token::check($token)){ die('Token doesn\'t match!');}

      
      $form_valid=FALSE; // assume the worst
      $validation = new Validate();

      $validation->check($_POST,array(
      
      
    ));


      if($validation->passed()) 
      {

      $form_valid=TRUE;
       echo("Form valid = TRUE");
       try {
          // echo "Trying to create user";
          $fields=array(
            'WHName' => Input::get('WHName'),
            'userGroup' => Input::get('Name'),
            'Priority' => Input::get('Priority'),
              
          );
          $db->insert('notifycationSetting',$fields);
          $successes[] = lang("ACCOUNT_USER_ADDED");
        }catch (Exception $e) 
          {
          die($e->getMessage());
            }   
      }
    
   
    }
  
}*/
$quey3 = $db->query("SELECT * FROM users");
$result3 = $quey3->results();

foreach ($result3 as $key) {
 
  $user_i.= $key->username.",";
  $query_user = $db->query("SELECT count(*) as total FROM notifycationSetting WHERE id = ?", array($key->id));
  $result_user = $query_user->results();
  foreach ($result_user as $key1) {
    $num = $key1->total;
  }
  if($num==0)
  {
    $field_u_e = array('id'=>$key->id,'user'=>$key->username,'email'=>$key->email);
    $db->insert('notifycationSetting',$field_u_e);
  }else
  {
    $query_u_e = $db->query("UPDATE notifycationSetting SET user = ?, email = ? WHERE id = ?",[$key->username,$key->email,$key->id]);
    $result_u_e = $query_u_e->results();
  }
}
$query = $db->query("SELECT * FROM notifycationSetting");
$result_noti = $query->results();
/*foreach ($result_noti as $v1) {
                      $email_string = "";
                      $users_string = explode(",", $v1->user);
                      for($i=0;$i<count($users_string);$i++)
                      {
                        $query_email = $db->query("SELECT * FROM users WHERE username = ?",array($users_string[$i]));
                        $result_email = $query_email->results();
                        foreach ($result_email as $mail) {
                          $email_string .=$mail->email.",";
                        }

                        
                      }
                        $query10 = $db->query("UPDATE notifycationSetting set email = ? WHERE id = ?",[$email_string,$v1->id]);
                        $result10 = $query10->results();}*/
$query = $db->query("SELECT * FROM senderEmailSetting");
$result_email = $query->results();
$quey2 = $db->query("SELECT warehouseName FROM warehouses");
$result2 = $quey2->results();

foreach ($result2 as $key) {

  $data.= $key->warehouseName.",";
}


$priority = "1,2,3,4,5,6";
$dayinweek = "Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday";
 //Fetch information for all warehouses
?>

<div id="page-wrapper">
  <div class="container">
    <!-- Page Heading -->
    <div class="row">
      <div class="col-xs-12 col-md-6">
    <h1>Manage Notification Setting</h1>
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
        <h3><strong>Sender email settings:</strong></h3>
          <div class="alluinfo">&nbsp;</div>
          <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="allutable table-responsive">
              <table class='table table-hover table-list-search'>
                <thead>
                  <tr>
                    <th>id</th><th>Email</th><th>Password</th><th>Modify</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    //Cycle through users
                    foreach ($result_email as $v2) {
                  ?>
                  <tr id="row<?php echo $v2->id;?>">
                    <td ><label class="form-control"><?=$v2->id?></label></td>
                    <td ><label class="form-control" id="email_val<?php echo $v2->id;?>"><?=$v2->email?></label></td>
                    <td ><label class="form-control" id="password_val<?php echo $v2->id;?>">**************</label></td>
                    <td><input  type="button" class="btn btn-primary" id ="edit_button_email<?php echo $v2->id;?>" value="edit" onclick="edit_row_email('<?php echo $v2->id;?>');"></td>
                    <td><input type='button' class="btn btn-primary" id ="save_button_email<?php echo $v2->id;?>" value="save" onclick="save_row_email('<?php echo $v2->id;?>');"></td>
                    
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </form>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <h3><strong>Global Enable:</strong></h3>
          <div class="alluinfo">&nbsp;</div>
          <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="allutable table-responsive">
              <table class='table table-hover table-list-search'>
                <thead>
                  <tr>
                    <th>id</th><th>PriorityP1</th><th>PriorityP2</th><th>PriorityP3</th><th>PriorityP4</th><th>PriorityP5</th><th>PriorityP6</th><th>Modify</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    //Cycle through users
                    foreach ($result_email as $v2) {
                  ?>
                  <tr id="row<?php echo $v2->id;?>">
                    <td ><label class="form-control"><?=$v2->id?></label></td>
                    <td><label ><input style="width: 40px;height:45px; float:left;clear:left;" type="checkbox" name="edit_Multi_Row" id="P1_val<?php echo $v2->id;?>" <?php echo $v2->P1?> disabled/></label></td>
                    <td><label ><input style="width: 40px;height:45px; float:left;clear:left;" type="checkbox" name="edit_Multi_Row" id="P2_val<?php echo $v2->id;?>" <?php echo $v2->P2?> disabled/></label></td>
                    <td><label ><input style="width: 40px;height:45px; float:left;clear:left;" type="checkbox" name="edit_Multi_Row" id="P3_val<?php echo $v2->id;?>" <?php echo $v2->P3?> disabled/></label></td>
                    <td><label ><input style="width: 40px;height:45px; float:left;clear:left;" type="checkbox" name="edit_Multi_Row" id="P4_val<?php echo $v2->id;?>" <?php echo $v2->P4?> disabled/></label></td>
                    <td><label ><input style="width: 40px;height:45px; float:left;clear:left;" type="checkbox" name="edit_Multi_Row" id="P5_val<?php echo $v2->id;?>" <?php echo $v2->P5?> disabled/></label></td>
                    <td><label ><input style="width: 40px;height:45px; float:left;clear:left;" type="checkbox" name="edit_Multi_Row" id="P6_val<?php echo $v2->id;?>" <?php echo $v2->P6?> disabled/></label></td>
                    <td><input  type="button" class="btn btn-primary" id ="edit_button_checkbox<?php echo $v2->id;?>" value="edit" onclick="edit_row_checkbox('<?php echo $v2->id;?>');"></td>
                    <td><input type='button'  class="btn btn-primary" id ="save_button_checkbox<?php echo $v2->id;?>" value="save" onclick="save_row_checkbox('<?php echo $v2->id;?>');"></td>
                    
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </form>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <h3><strong>Times of checking:</strong></h3>
          <div class="alluinfo">&nbsp;</div>
          <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="allutable table-responsive">
              
                  <?php
                    //Cycle through users
                    foreach ($result_email as $v2) {
                  ?>
                  <div class="col-xs-12 col-md-12">
                    <div class="form-group">
                      <div class="col-xs-2 col-md-2">
                        <label  for="water_color" style="display:block;" >P2:</label>
                      </div>
                      <div class="col-xs-6 col-md-2">
                        <label class="form-control" id="P2_Time_val<?php echo $v2->id;?>" min="1" ><?=$v2->P2_Time?></label>
                      </div>
                      <div class="col-xs-4 col-md-6">
                        <label  for="water_color" style="display:block;" >(Times/day)</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-12">
                    <div class="form-group">
                      <div class="col-xs-4 col-md-2">
                        <label  for="water_color" style="display:block;" >P3: Recur every </label>
                      </div>
                      <div class="col-xs-6 col-md-2">
                        <label class="form-control" id="P3_Week_val<?php echo $v2->id;?>"><?=$v2->P3_Week?></label>
                      </div>
                      <div class="hidden-md hidden-lg hidden-xl col-xs-2">
                        <label  for="water_color" style="display:block;text-align: center;">weeks </label>
                      </div>
                      <div class="hidden-md hidden-lg hidden-xl col-xs-4">
                        <label  for="water_color" style="display:block;text-align: center;">on </label>
                      </div>
                      <div class="hidden-xs hidden-sm col-md-1">
                        <label  for="water_color" style="display:block;text-align: center;">weeks, on </label>
                      </div>
                      <div class="col-xs-6 col-md-2">
                        <select class="form-control" name="P3_Day_val" id="P3_Day_val<?php echo $v2->id;?>">
                          <option value="<?php echo $v2->P3_Day?>"><?=$v2->P3_Day?></option>
                        </select>
                      </div>
                      <div class="col-xs-4 col-md-1">
                        <label  for="water_color" style="display:block;text-align: center">at  </label>
                      </div>
                      <div class="col-xs-6 col-md-1  ">
                        <label class="form-control" id="P3_Hour_val<?php echo $v2->id;?>"><?=$v2->P3_Hour?></label>
                      </div>
                      <div class="col-xs-2 col-md-1">
                        <label  for="water_color" style="display:block;text-align: center">hour  </label>
                      </div>
                      <div class="hidden-md hidden-lg hidden-xl col-xs-4">
                        <label  for="water_color" style="display:block;text-align: center"></label>
                      </div>
                      <div class="col-xs-6 col-md-1  ">
                        <label class="form-control" id="P3_Minute_val<?php echo $v2->id;?>"><?=$v2->P3_Minute?></label>
                      </div>
                      <div class="col-xs-2 col-md-1">
                        <label  for="water_color" style="display:block;text-align: center">minute  </label>
                      </div>
                      
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-12">
                    <div class="form-group">
                      <div class="col-xs-4 col-md-2">
                        <label  for="water_color" style="display:block;" >P6: Recur every </label>
                      </div>
                      <div class="col-xs-6 col-md-2">
                        <label class="form-control" id="P6_Week_val<?php echo $v2->id;?>"><?=$v2->P6_Week?></label>
                      </div>
                      <div class="hidden-md hidden-lg hidden-xl col-xs-2">
                        <label  for="water_color" style="display:block;text-align: center;">weeks </label>
                      </div>
                      <div class="hidden-md hidden-lg hidden-xl col-xs-4">
                        <label  for="water_color" style="display:block;text-align: center;">on </label>
                      </div>
                      <div class="hidden-xs hidden-sm col-md-1">
                        <label  for="water_color" style="display:block;text-align: center;">weeks, on </label>
                      </div>
                      <div class="col-xs-6 col-md-2">
                        <label class="form-control" id="P6_Week_val<?php echo $v2->id;?>">every day</label>
                      </div>
                      <div class="col-xs-4 col-md-1">
                        <label  for="water_color" style="display:block;text-align: center">at  </label>
                      </div>
                      <div class="col-xs-6 col-md-1  ">
                        <label class="form-control" id="P6_Hour_val<?php echo $v2->id;?>"><?=$v2->P6_Hour?></label>
                      </div>
                      <div class="col-xs-2 col-md-1">
                        <label  for="water_color" style="display:block;text-align: center">hour  </label>
                      </div>
                      <div class="hidden-md hidden-lg hidden-xl col-xs-4">
                        <label  for="water_color" style="display:block;text-align: center"></label>
                      </div>
                      <div class="col-xs-6 col-md-1  ">
                        <label class="form-control" id="P6_Minute_val<?php echo $v2->id;?>"><?=$v2->P6_Minute?></label>
                      </div>
                      <div class="col-xs-2 col-md-1">
                        <label  for="water_color" style="display:block;text-align: center">minute  </label>
                      </div>
                      
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-12">
                  <div class="col-md-8"></div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="col-xs-6 col-md-6">
                        <input  type="button" class="btn btn-primary" id ="edit_button_time<?php echo $v2->id;?>" value="edit" onclick="edit_row_time('<?php echo $v2->id;?>','<?php echo $dayinweek; ?>');">
                      </div>
                      <div class="col-xs-6 col-md-6">
                        <input type='button' class="btn btn-primary" id ="save_button_time<?php echo $v2->id;?>" value="save" onclick="save_row_time('<?php echo $v2->id;?>','<?php echo $dayinweek; ?>');">
                      </div> 
                    </div>
                  </div>
                  </div>     
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </form>
      </div>
    </div>
    <!--div class="row">
      <div class="col-xs-12">
        <?php
          if (!$form_valid && Input::exists())
          {
            echo display_errors($validation->errors());
          }
        ?>
        <form class="form-signup" action="notificationSetting.php" method="POST" id="payment-form">
          <div class="well well-sm">
            <h3 class="form-signin-heading"> Manually add a Notification Setting</h3>
              <div class="form-group">
                <div class="col-xs-2">
                  <select class="form-control" name="WHName" id="WHName">
                    <?php foreach($result2 as $key) {?>
                    <option class="form-control" value="<?php echo $key->warehouseName?>"><?=$key->warehouseName?></option>
                    <?php }?>
                    </select>
                </div>
                <div class="col-xs-2">
                  <select class="form-control" name="Name" id="Name">
                    <?php foreach($result3 as $key) {?>
                    <option value="<?php echo $key->name?>"><?=$key->username?></option>
                  <?php }?>
                  </select>
                </div>
                <div class="col-xs-2">
                  <select class="form-control" name="Priority" id="Priority">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                  </select>
                </div>
              </div>
              <br></br>
              <input type="hidden" value="<?=Token::generate();?>" name="csrf">
              <input class='btn btn-primary' type='submit' name='addNoti' value='Manually Add Notification Setting' />
          </div>
        </form>
      </div>
    </div-->
    <div class="row">
      <div class="col-xs-12">
      <h3><strong>Notification routes:</strong></h3>
        <div class="alluinfo">&nbsp;</div>
          <form name="adminUsers" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="allutable table-responsive">
              <table class='table table-hover table-list-search'>
                <thead>
                  <tr>
                    <th>id</th><th>userName</th><th>Email</th><th>WarehouseName</th><th>Priority</th><th>Modify</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    //Cycle through users
                    foreach ($result_noti as $v1) {
                      
                  ?>
                  <tr id="row<?php echo $v1->id;?>">
                    <td ><label class="form-control"><?=$v1->id?></label></td>
                    <td id="userGroup_val<?php echo $v1->id;?>"><label class="form-control"><?=$v1->user?></label>
                      <!--select class="form-control" name="selectUG" id="selectUG<?php echo $v1->id;?>">
                        <option value="<?php echo $v1->user?>"><?=$v1->user?></option>
                      </select-->
                    </td>
                    <td id="userGroup_val<?php echo $v1->id;?>"><label class="form-control" style="white-space: nowrap;"><?=$v1->email?></label>
                      <!--select class="form-control"">
                        <option value="<?php echo $v1->email?>"><?=$v1->email?></option>
                      </select-->
                    </td>
                    <td id="WHName_val<?php echo $v1->id;?>">
                      <select class="form-control" name="selectWH" id="selectWH<?php echo $v1->id;?>">
                        <option value="<?php echo $v1->WHName?>" ><?=$v1->WHName?></option>
                      </select>
                    </td>
                    
                    <td id="Priority_val<?php echo $v1->id;?>">
                      <select class="form-control" name="selectPR" id="selectPR<?php echo $v1->id;?>" style="min-width: 100px">
                        <option value="<?php echo $v1->Priority?>" ><?=$v1->Priority?></option>
                      </select>
                    </td>
                    
                    <td><input  type="button" class="btn btn-primary" id ="edit_button_noti<?php echo $v1->id;?>" value="edit" onclick="edit_row_noti('<?php echo $v1->id;?>','<?php echo $data; ?>','<?php echo $user_i; ?>','<?php echo $priority; ?>');"></td>
                    <td><input type='button' class="btn btn-primary" id ="save_button_noti<?php echo $v1->id;?>" value="save" onclick="save_row_noti('<?php echo $v1->id;?>','<?php echo $data; ?>','<?php echo $user_i; ?>','<?php echo $priority; ?>');"></td>
                    
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
