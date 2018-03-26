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

  if(!empty($_POST['addFlipper']))
  {
    //echo("DZOO");
    $Location = Input::get('Location');
    
    $LowerThreshold = Input::get('LowerThreshold');
    $UpperThreshold = Input::get('UpperThreshold');
    $Time = date('Y-m-d H:i:s');
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
        'Location' => array(
          'display' => 'Location',
          'required' => true,
          'min' => 2,
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
            'Location' => Input::get('Location'),
              
              'LowerThreshold' =>Input::get('LowerThreshold'),
              'UpperThreshold' => Input::get('UpperThreshold'),
              'Time' => Input::get('Time'),
              'timeZone'  =>Input::get('timeZone'),
          );
          $db->insert('flippers',$fields);
          $successes[] = lang("ACCOUNT_USER_ADDED");
        }
        catch (Exception $e) 
        {
          die($e->getMessage());
        }   
      } 
  }  
}
$query5 = $db->query("SELECT * FROM flippers");
$flipperData = $query5->results();
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
                <h1>Manage FLippers</h1>
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
        <form class="form-signup" action="admin_flippers.php" method="POST" id="payment-form">
          <div class="well well-sm">
            <h3 class="form-signin-heading"> Manually add a Flipper</h3>
              <div class="form-group">
                <div class="col-xs-6 col-md-2">
                        <input  class="form-control" type="text" name="Location" id="Location" placeholder="Location" value="<?php if (!$form_valid && !empty($_POST)){ echo $Location;} ?>" required autofocus>
                </div> 
                           
                
                <div class="col-xs-6 col-md-2">
                  <input class="form-control" type="text" name="LowerThreshold" id="LowerThreshold" placeholder="Lower Threshold" value="<?php if (!$form_valid && !empty($_POST)){ echo $LowerThreshold;} ?>" required >
                </div>
                <div class="col-xs-6 col-md-2">
                  <input class="form-control" type="text" name="UpperThreshold" id="UpperThreshold" placeholder="Upper Threshold" value="<?php if (!$form_valid && !empty($_POST)){ echo $UpperThreshold;} ?>" required >
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
                  <input class='btn btn-primary' type='submit' name='addFlipper' value='Manually Add Flipper'/>
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
                                        <th style="width: 70px">id</th>
                <th style="width: 130px">Location</th>
                <th style="width: 130px">Lower Threshold</th>
                <th style="width: 130px">Upper Threshold</th>
                <th style="width: 200px">Time</th>
                <th style="width: 150px">timeZone</th>

                <th>Modify</th>
                                   </tr>
                                 </thead>
                             <tbody style="display:block;height: 500px;overflow-y: auto;overflow-x: hidden;">
              <tr style="visibility: hidden;">
                <th >id</th><th>Location</th><th>Lower Threshold</th><th>Upper Threshold</th><th>Time</th><th>timeZone</th><th>Modify</th>
              </tr>
              <?php
                //Cycle through users
                foreach ($flipperData as $v1) {
              ?>
              <tr id="row<?php echo $v1->id;?>">
                <!--<td><div class="form-group"><input type="checkbox" name="delete[<?=$v1->warehouseName?>]" value="<?=$v1->warehouseName?>" /></div></td>-->
                <td><label class="form-control"><?=$v1->id?></label></td>
                <td id="Location_val<?php echo $v1->id;?>"><label style="width: 120px" class="form-control"><a href='flipper.php?WHName=<?=$v1->Location?>'><?=$v1->Location?></a></label></td>                
                <td ><label class="form-control" id="LowerThreshold_val<?php echo $v1->id;?>"><?=$v1->LowerThreshold?></label></td>
                <td ><label class="form-control" id="UpperThreshold_val<?php echo $v1->id;?>"><?=$v1->UpperThreshold?></label></td>
                <td><label style="width: 190px" class="form-control"><?=$v1->Time?></label></td>
                 <td id="timeZone_val<?php echo $v1->id;?>" >
                      <select class="form-control" name="timeZone" id="timeZone<?php echo $v1->id;?>" style="width: 140px">
                        <option value="<?php echo $v1->timeZone?>" ><?=$v1->timeZone?></option>
                      </select>
                    </td>
                <td><input type="button" class="btn btn-primary" id ="edit_button_flipper<?php echo $v1->id;?>" value="edit" onclick="edit_row_flipper('<?php echo $v1->id;?>','<?php echo $timeZone; ?>');"></td>
                <td><input type='button' class="btn btn-primary" id ="save_button_flipper<?php echo $v1->id;?>" value="save" onclick="save_row_flipper('<?php echo $v1->id;?>','<?php echo $timeZone; ?>');"></td>
                <td><input type='button' class="btn btn-primary" id="delete_button_flipper<?php echo $v1->id;?>" value="delete" onclick="delete_row_flipper('<?php echo $v1->id;?>');"></td>
                
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
