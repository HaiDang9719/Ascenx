<?php 


require_once 'init.php';
require_once $abs_us_root . $us_url_root . 'users/includes/header.php';
require_once $abs_us_root . $us_url_root . 'users/includes/navigation.php';
if (!securePage($_SERVER['PHP_SELF'])) {die();}

?>
   

 <?php

/** Query Necessary Data here **/

//PHP Goes Here!
$aa     = 0;
$WHName = $_REQUEST['WHName'];

//$WHName = "Shanghai";

$db = DB::getInstance();
// get post(has value 'ChangColor') to change color of station and gauge box
if (!empty($_POST)) {
    if (!empty($_POST['ChangeColor'])) {
        echo ("DZOO");
        $TypeSG       = $_POST['TypeSG'];
        $blue_color   = Input::get('blue_color');
        $green_color  = Input::get('green_color');
        $yellow_color = Input::get('yellow_color');
        $red_color    = Input::get('red_color');
        $token        = $_POST['csrf'];
        if (!Token::check($token)) {die('Token doesn\'t match!');}
        $form_valid = false; // assume the worst
        $validation = new Validate();
        $validation->check($_POST, array(

        ));

        if ($validation->passed()) {

            $form_valid = true;
            echo ("Form valid = TRUE");
            try {
                if ($TypeSG == "1") {
                    $fields = array(
                        'blues'   => Input::get('blue_color'),
                        'greenS'  => Input::get('green_color'),
                        'yellowS' => Input::get('yellow_color'),
                        'redS'    => Input::get('red_color'),

                    );
                    $db->UPDATE('colorStation', 10, $fields);
                } else if ($TypeSG == "2") {
                    $fields = array(
                        'blueG'   => Input::get('blue_color'),
                        'greenG'  => Input::get('green_color'),
                        'yellowG' => Input::get('yellow_color'),
                        'redG'    => Input::get('red_color'),

                    );
                    $db->UPDATE('colorGauge', 10, $fields);
                }
                $successes[] = lang("ACCOUNT_USER_ADDED");
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

    }
}

//query color of station from database
$query_c  = $db->query("SELECT * FROM colorStation");
$result_c = $query_c->results();
foreach ($result_c as $key) {
    $initialColor_B = $key->blueS;
    $initialColor_G = $key->greenS;
    $initialColor_Y = $key->yellowS;
    $initialColor_R = $key->redS;
}

//query color of gauge from database
$query_c  = $db->query("SELECT * FROM colorGauge");
$result_c = $query_c->results();
foreach ($result_c as $key) {
    $initialColor_B_G = $key->blueG;
    $initialColor_G_G = $key->greenG;
    $initialColor_Y_G = $key->yellowG;
    $initialColor_R_G = $key->redG;
}

//get data in USA warehouse
if ($WHName == "USA") {
    $WHName1    = "USA1";
    $WHName2    = "USA2";
    $sql        = $db->query("SELECT count(*) as total  FROM gauges WHERE WHName = ? OR WHName = ?", [$WHName1, $WHName2]);
    $result_g_0 = $sql->results();
    foreach ($result_g_0 as $a) {$num = $a->total;}
    $query1  = $db->query("SELECT stationNumber FROM warehouses WHERE warehouseName = ? ", array($WHName1));
    $results = $query1->results();
    foreach ($results as $a) {$stationNumber1 = $a->stationNumber;}
    $query1  = $db->query("SELECT stationNumber FROM warehouses WHERE warehouseName = ?", array($WHName2));
    $results = $query1->results();
    foreach ($results as $a) {$stationNumber2 = $a->stationNumber;}
    $stationNumber = $stationNumber1 + $stationNumber2 + $num;
    $query2        = $db->query("SELECT * FROM stations WHERE warehouseName = ? OR warehouseName = ?", [$WHName1, $WHName2]);
    $results       = $query2->results();
    $data          = array();
    foreach ($results as $a) {$data[] = $a->id;}
    $query_g_1  = $db->query("SELECT * FROM gauges WHERE WHName = ? OR WHName = ?", [$WHName1, $WHName2]);
    $result_g_1 = $query_g_1->results();
    foreach ($result_g_1 as $key) {$data[] = "G" . $key->id;}
    $id_json = json_encode($data);
}

//get data in other warehouses
else {
    $sql        = $db->query("SELECT count(*) as total  FROM gauges WHERE WHName = ?", array($WHName));
    $result_g_0 = $sql->results();
    foreach ($result_g_0 as $a) {$num = $a->total;}
    $query1  = $db->query("SELECT stationNumber FROM warehouses WHERE warehouseName = ?", array($WHName));
    $results = $query1->results();
    foreach ($results as $a) {$stationNumber = $a->stationNumber;}
    $stationNumber = $stationNumber + $num;
    $query2        = $db->query("SELECT * FROM stations WHERE warehouseName = ?", array($WHName));
    $results       = $query2->results();
    $data          = array();
    foreach ($results as $a) {$data[] = $a->id;}
    $query_g_1  = $db->query("SELECT * FROM gauges WHERE WHName = ?", array($WHName));
    $result_g_1 = $query_g_1->results();
    foreach ($result_g_1 as $key) {$data[] = "G" . $key->id;}
    $id_json = json_encode($data);
}

//save position after drag and drop station and gauge to database
if (isset($_POST['save_position'])) {
    $id   = $_POST['id'];
    $top  = $_POST['top'];
    $left = $_POST['left'];
    //echo $top . "---" . $left . "-----" . $id;
    $db = DB::getInstance();
    if (substr($id, 0, 1) == "G") {
        $gaugesid   = substr($id, 1);
        $query_s_g  = $db->query("UPDATE gauges SET top = ?, left_style = ? WHERE id = ?", [$top, $left, $gaugesid]);
        $result_s_g = $query_s_g->results();
    }
    $query1  = $db->query("UPDATE stations SET top = ?, left_style = ? WHERE id = ?", [$top, $left, $id]);
    $result1 = $query1->results();
    echo "success";
    exit();
}

//update which station is empty in database
$emptyRFID = "R0000";
$isEmpty   = 1;
$query2    = $db->query("SELECT id FROM stations WHERE RFID = ?", array($emptyRFID));
$result2   = $query2->results();
foreach ($result2 as $key) {
    $query2  = $db->query("UPDATE stations SET isEmpty = ? WHERE id = ?", [$isEmpty, $key->id]);
    $result2 = $query2->results();
}

 ?>  
    <link rel="stylesheet" href="/KTproj/users/jquery.multi-draggable.css">
    <script src="js/jquery-1.12.4.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="/KTproj/users/jquery.multi-draggable.js"></script>
    <script src="/KTproj/users/warehouseTemplate_edit_multidrag.js"></script>

<div class="hidden-xs hidden-sm">
<div id="page-wrapper" style="background-color: white">
 

        <div class="container">
            <p id="sitetitle" style="text-align: center; color:  #0e6889"><strong style="font-size: 200%"><a href="warehouseTemplate.php?WHName=<?=$WHName?> ">Warehouse : <?php echo $WHName; ?> </a></strong></p>
    <div class="row row1">



    <!-- display edit mode to drap and drop station and gauge object-->
      <div class="col-xs-6 col-md-4">
        <div class="well well-sm">
          <h3 class="form-signin-heading"> Manually Arrange</h3>
          <br></br><br>
          <input type="button" class="btn btn-primary" id ="edit_button<?php echo $v1->id; ?>" value="Update" onclick="save_warehouse();"></td>
          <br></br>
        </div>
      </div>



<!-- display edit mode to change color of station and gauge object-->
      <div class="col-xs-6 col-md-8">
        <?php
if (!$form_valid && Input::exists()) {
    echo display_errors($validation->errors());
}
?>
          <form class="form-signup" action="warehouseTemplate_edit_multidrag.php?WHName=<?=$WHName?> " method="POST" id="payment-form">
                <div class="well well-sm">
                  <script src="/KTproj/JS/jscolor.js"></script>
                  <h3 class="form-signin-heading"> Manually Change Color</h3>
                  <div class="form-group" >
                    <div id="TypeSelector"  class="col-xs-2 col-md-4">
                      <select class="form-control" onchange="newTypeSelected()" name="TypeSG" id="TypeSG">
                        <option value="1">Station</option>
                        <option value="2">Gauge</option>
                      </select>
                    </div>
                    <div class="col-xs-2 col-md-2">
                      <input  name="blue_color" id="blue_color" value="<?php if (!$form_valid && !empty($_POST)) {echo $blue_color;} else { echo $initialColor_B;}?>" class="form-control jscolor {closable:true,closeText:'Close me!'}" required >
                    </div>
                    <div class="col-xs-2 col-md-2">
                      <input class="form-control jscolor {closable:true,closeText:'Close me!'}" name="green_color" id="green_color" value="<?php if (!$form_valid && !empty($_POST)) {echo $green_color;} else {echo $initialColor_G;}?>" required >
                    </div>
                    <div class="col-xs-2 col-md-2">
                      <input class="form-control jscolor {closable:true,closeText:'Close me!'}" name="yellow_color" id="yellow_color" value="<?php if (!$form_valid && !empty($_POST)) {echo $yellow_color;} else {echo $initialColor_Y;}?>" required >
                    </div>
                    <div class="col-xs-2 col-md-2">
                      <input class="form-control jscolor {closable:true,closeText:'Close me!'}" name="red_color" id="red_color" value="<?php if (!$form_valid && !empty($_POST)) {echo $red_color;} else {echo $initialColor_R;}?>" required >
                    </div>
                    <br /><br>
                    <input type="hidden" value="<?=Token::generate();?>" name="csrf">
                    <br>
                    <input class='btn btn-primary' type='submit' name='ChangeColor' value='Manually Change Color' />
                   
                  </div>
          </form>
      </div>
    </div>
  </div>
        </div>
        <div id="mutilDrag" class="container" style="width: 1000px; height: 800px; background-color: white; position: relative; display: block;">
            <?php 
            $id_count = 1;
for ($i = 0; $i < $stationNumber; $i++) {
    //create station object
    $query1  = $db->query("SELECT RFID FROM stations WHERE id = ?", array($data[$i]));
    $results = $query1->results();
    foreach ($results as $a) {$RFIDs = $a->RFID;}
    $query1  = $db->query("SELECT * FROM $RFIDs ORDER BY Time DESC LIMIT 1");
    $results = $query1->results();

    foreach ($results as $a) {
        $Pressure    = $a->Pressure;
        $Voltage     = "V: " . $a->Voltage;
        $Current     = "I: " . $a->Current;
        $queryLPN = $db->query("SELECT LPN FROM frus WHERE RFID = ?", array($RFIDs));
        $resultLPN = $queryLPN->results();
        foreach ($resultLPN as $key1) {$LPN= "LPN: ". $key1->LPN;}
        $latest_time = $a->Time;
    }
    $updateDate = date('Y-m-d H:i:s');
    $hour       = (strtotime($updateDate) - strtotime($latest_time)) / 3600;
    $query3     = $db->query("SELECT * FROM stations WHERE id = ?", array($data[$i]));
    $result3    = $query3->results();
    foreach ($result3 as $a) {
        $thresholdDownP = $a->thresholdDownP;
        $thresholdUpP   = $a->thresholdUpP;
        $emptyStatus    = $a->isEmpty;
        $stationName_s = $a->stationName;
        if ($emptyStatus == "1" or $hour >= "24") {
            $color_button = "#" . $initialColor_B;
            $href         = "#";
        } else if ($Pressure < $thresholdDownP) {
            $color_button = "#" . $initialColor_G;
            $href         = "station.php?RFID=$RFIDs";
        } else if ($Pressure >= $thresholdDownP && $Pressure <= $thresholdUpP) {
            $color_button = "#" . $initialColor_Y;
            $href         = "station.php?RFID=$RFIDs";
        } else if ($Pressure > $thresholdUpP) {
            $color_button = "#" . $initialColor_R;
            $href         = "station.php?RFID=$RFIDs";
        }
    }

    $query_location  = $db->query("SELECT * FROM stations WHERE id = ?", array($data[$i]));
    $result_location = $query_location->results();
    foreach ($result_location as $key) {
        $top_s  = $key->top;
        $left_s = $key->left_style;
    }
    $sn = $stationName_s;

    //create gauge object
    if (substr($data[$i], 0, 1) == "G") {
        $gauges          = $data[$i];
        $gauges_id       = substr($data[$i], 1);
        $query_location  = $db->query("SELECT * FROM gauges WHERE id = ?", array($gauges_id));
        $result_location = $query_location->results();
        foreach ($result_location as $key) {
            $top_s  = $key->top;
            $left_s = $key->left_style;
        }
        $sn       = $data[$i];
        $queryg1  = $db->query("SELECT * FROM $gauges ORDER BY Time DESC LIMIT 1");
        $resultgs = $queryg1->results();

        foreach ($resultgs as $a) {
            $Pressure    = $a->Pressure;
            $Voltage     = "";
            $Current     = "";
            $LPN         = "";
            $latest_time = $a->Time;
        }
        $updateDate = date('Y-m-d H:i:s');
        $hour       = (strtotime($updateDate) - strtotime($latest_time)) / 3600;
        $query3     = $db->query("SELECT * FROM gauges WHERE id = ?", array($gauges_id));
        $result3    = $query3->results();
        foreach ($result3 as $a) {
            $thresholdDownP = $a->thresholdDownP;
            $thresholdUpP   = $a->thresholdUpP;
            if ($hour >= "24") {
                $color_button = "#" . $initialColor_B_G;
                $href         = "#";
            } else if ($Pressure < $thresholdDownP) {
                $color_button = "#" . $initialColor_G_G;
                $href         = "gauge.php?GID=$gauges_id";
            } else if ($Pressure >= $thresholdDownP && $Pressure <= $thresholdUpP) {
                $color_button = "#" . $initialColor_Y_G;
                $href         = "gauge.php?GID=$gauges_id";
            } else if ($Pressure > $thresholdUpP) {
                $color_button = "#" . $initialColor_R_G;
                $href         = "gauge.php?GID=$gauges_id";
            }
        }

    }
    //$query4  = $db->query("UPDATE stations SET stationName = ? WHERE id = ?", [$sn, $data[$i]]);
    //$result4 = $query4->results();
    ?>
            <div id="<?php echo $WHName.$data[$i]?>" class="drag" style="top: <?php echo $top_s; ?>;left: <?php echo $left_s; ?>;">
        
              <div class="btn-group-vertical">
            <a href='<?=$href?>' style="color: white" ><button style="height:40px;width:59px;background-color: <?=$color_button?>;color: white" type="button" class="btn " id="button_control_HV" ><div class="link"><?=$sn?></div></button></a>
            <div class="dropdown" >
                <button style=" height:20px;width:59px;background-color: gray; margin: 0;" class="btn" type="button" data-toggle="dropdown">
                <span class="caret" style="border-top:5px solid white; top:-10px; position: relative;"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#"><?php echo $LPN; ?></a></li>
                    <li><a href="#">P: <?php printf("%.2e\n", $Pressure);?> Torr</a></li>
                    <li><a href="#"><?php echo $Voltage; ?></a></li>
                    <li><a href="#"><?php echo $Current; ?></a></li>
                </ul>
            </div>
                <button style="height:40px;width:70px;background-color: transparent; left:-5px;top:-14px;" type="button" class="btn " id="button_control_HV" >ID:<?=$data[$i]?></button>
        </div>
            </div>
    <?php }?>
        </div>

</div>
</div>
<script type="text/javascript">
function newTypeSelected()
{
  var anArray = [];
  var RangeValue = $('#TypeSelector').find(":selected").val();
  if(RangeValue=="2"){
    document.getElementById('blue_color').style.backgroundColor ='#'+ "<?php echo $initialColor_B_G?>";
    document.getElementById('blue_color').value = "<?php echo $initialColor_B_G?>";  
    document.getElementById('green_color').style.backgroundColor ='#'+ "<?php echo $initialColor_G_G?>";
    document.getElementById('green_color').value ="<?php echo $initialColor_G_G?>";
    document.getElementById('yellow_color').style.backgroundColor ='#'+ "<?php echo $initialColor_Y_G?>";
    document.getElementById('yellow_color').value = "<?php echo $initialColor_Y_G?>";
    document.getElementById('red_color').style.backgroundColor='#'+ "<?php echo $initialColor_R_G?>";
    document.getElementById('red_color').value="<?php echo $initialColor_R_G?>";
  }
  else if(RangeValue=="1"){
    document.getElementById('blue_color').style.backgroundColor ='#'+ "<?php echo $initialColor_B?>";
    document.getElementById('blue_color').value ="<?php echo $initialColor_B?>";
    document.getElementById('green_color').style.backgroundColor ='#'+ "<?php echo $initialColor_G?>";
    document.getElementById('green_color').value ="<?php echo $initialColor_G?>";
    document.getElementById('yellow_color').style.backgroundColor ='#'+ "<?php echo $initialColor_Y?>";
    document.getElementById('yellow_color').value ="<?php echo $initialColor_Y?>";
    document.getElementById('red_color').style.backgroundColor = '#'+"<?php echo $initialColor_R?>";
    document.getElementById('red_color').value ="<?php echo $initialColor_R?>";
  }
  
}
</script>
<script type="text/javascript">
     //script save position after drag and drop
    function save_warehouse(){
      <?php
for ($i = 0; $i < $stationNumber; $i++) {
    $id_g = $data[$i];
    ?>
            var top = document.getElementById("<?php echo $WHName . $data[$i] ?>").style.top;
            var left = document.getElementById("<?php echo $WHName . $data[$i] ?>").style.left;
            if(!top) { top = '0px';}
            if(!left) { left = '0px';}

            var id = <?php
if (substr($data[$i], 0, 1) == "G") {
        echo substr($data[$i], 1);
    } else {
        echo $data[$i];
    }

    ?>;
            console.log("ID: " + id + " Top:" + top + " Left:" + left);
             $.ajax
              ({
                  type:'post',
                  url:'warehouseTemplate_edit_multidrag.php?WHName=<?=$WHName?>',
                  data:{
                    save_position:'save_position',
                    id:"<?php echo $id_g ?>",
                    top:top,
                    left:left,
                  },

               });
      <?php }?>
    }
</script>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>
 <?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; // currently just the closing /body and /html ?>