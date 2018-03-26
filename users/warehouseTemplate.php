<?php 


require_once 'init.php';
require_once $abs_us_root . $us_url_root.'users/includes/header.php';
require_once $abs_us_root . $us_url_root.'users/includes/navigation.php';
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
        //echo ("DZOO");
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
            //echo ("Form valid = TRUE");
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


//update which station is empty in database
$emptyRFID = "R0000";
$isEmpty   = 1;
$query2    = $db->query("SELECT id FROM stations WHERE RFID = ?", array($emptyRFID));
$result2   = $query2->results();
foreach ($result2 as $key) {
    $query2  = $db->query("UPDATE stations SET isEmpty = ? WHERE id = ?", [$isEmpty, $key->id]);
    $result2 = $query2->results();
}
$nameFlipper = $WHName."FlipperCH1";
$queryFlipper = $db->query("SELECT * FROM flippers WHERE Location = ?",array($WHName));
$resultFlipper = $queryFlipper->results();
$query5 = $db->query("SELECT * FROM $nameFlipper ORDER BY Time DESC LIMIT 1 ");
$result5 = $query5->results();
foreach ($result5 as $q) {
    $temperatureFlipperGDC = $q->Temperature;
    $testTime = $q->Time;
    
}

if($temperatureFlipperGDC < -60 and $temperatureFlipperGDC > -100)
{
    $tempColor = "#008000";
}
else if ($temperatureFlipperGDC < -30 and $temperatureFlipperGDC >= -60)
{

    $tempColor = "#ffff00";
}
else if ($temperatureFlipperGDC < 0 and $temperatureFlipperGDC >= -30)
{
    
    $tempColor = "#ff0000";
}

$percent = ((100 - $temperatureFlipperGDC * -1)/1)."%";
$percentLocation = ((($temperatureFlipperGDC * -1)/100)*590)."px";
$queryCameraSetting = $db->query("SELECT * FROM cameraSetting WHERE Location = ?",array($WHName));
$resultCameraSetting = $queryCameraSetting->results();

 ?>  
    <link rel="stylesheet" href="/KTproj/users/jquery.multi-draggable.css">
    <script src="js/jquery-1.12.4.js"></script>
    <script src="js/jquery-ui.js"></script>
    

    <!-- <script src="/KTproj/users/jquery.multi-draggable.js"></script>
    <script src="/KTproj/users/warehouseTemplate_edit_multidrag.js"></script>
 -->

<style type="text/css">
.container1 {
    position: absolute;
    margin-top: 10px; 
    right :-80px;
}

   .progress-bar-vertical {
  width: 30px;
  min-height: 600px;
  display: flex;
  align-items: flex-end;
  margin-right: 20px;
  float: left;
}

.progress-bar-vertical .progress-bar {
  width: 100%;
  height: 0;
  -webkit-transition: height 0.6s ease;
  -o-transition: height 0.6s ease;
  transition: height 0.6s ease;
  background: <?php echo $tempColor;?>;
  border: 1px;
}
/*
#myProgressBar 
{
width: 100%;
  height: 0;
  -webkit-transition: height 0.6s ease;
  -o-transition: height 0.6s ease;
  transition: height 0.6s ease;
  background: <?php echo $tempColor;?>;
  border: 1px;
}*/



    </style>
<div class="hidden-xs hidden-sm">
<div id="page-wrapper" style="background-color: white">
 

        <div class="container">
            <p id="sitetitle" style="text-align: center; color:  #0e6889"><strong style="font-size: 200%"><a href="warehouseTemplate.php?WHName=<?=$WHName?> ">Warehouse : <?php echo $WHName; ?> </a></strong></p>
            <?php if (count($resultCameraSetting) >0) {?>
            <a href ='depotcameras.php?WHName=<?php echo $WHName;?>'><img src="images/Camera.png" style="width:70px;height:50px;"/></a>
            <?php }?>
    <div class="row row1">

        <div id="mutilDragDisable" class="container" style="width: 1000px; height: 800px; background-color: white; position: relative;">
        <?php foreach ($resultFlipper as $k) {
          ?>
            <div class="container1">
                <div class="progress progress-bar-vertical">
                    <div id="myProgressBar" class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $percent;?>;">
                    </div>
                </div>
            </div>
            <p style="position: absolute;right :-120px;top: 0px">0 &#8451</p>
            <p id="temp" style="position: absolute;right :-130px;top: <?php echo $percentLocation;?>"><?php echo $temperatureFlipperGDC."&#8451";?></p>
            <p style="position: absolute;right :-130px;top: 590px">-100&#8451</p>
            <p style="position: absolute;right :-90px;top: 620px"><a href='flipper.php?WHName=<?=$WHName?>'><?php echo $nameFlipper?></a></p>

<?php }?>

        
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
                <!--button style="height:40px;width:70px;background-color: transparent; left:-5px;" type="button" class="btn " id="button_control_HV" >ID:<?=$data[$i]?></button-->
        </div>
            </div>
    <?php }?>
        </div>

</div>
</div>
</div>
</div>

<div class="hidden-md hidden-lg">
<div id="page-wrapper" style="background-color: white">
  <div class="container" style="background-color: white">
  <div class="">
    <div class="row row1">  
      <div class="col-xs-12 col-sm-12">
      <p id="sitetitle" style="text-align: center; color:  #0e6889"><strong style="font-size: 200%">Warehouse : <?php echo $WHName; ?> </strong></p>
<?php
$id_count = 1;
for ($i=0;$i<$stationNumber;$i++) {
    //create station object
    $query1  = $db->query("SELECT RFID FROM stations WHERE id = ?", array($data[$i]));
    $results = $query1->results();
    foreach ($results as $a) {$RFIDs = $a->RFID;}
    $query1  = $db->query("SELECT * FROM $RFIDs ORDER BY Time DESC LIMIT 1");
    $results = $query1->results();

    foreach ($results as $a) {
        $Pressure = $a->Pressure;
        $Voltage  = "V: ".$a->Voltage;
        $Current  = "I: ".$a->Current;
        $queryLPN = $db->query("SELECT LPN FROM frus WHERE RFID = ?", array($RFIDs));
        $resultLPN = $queryLPN->results();
        foreach ($resultLPN as $key1) {$LPN= "LPN: ". $key1->LPN;}
        $latest_time = $a->Time;
    }
    $updateDate = date('Y-m-d H:i:s');
    $hour = (strtotime($updateDate)-strtotime($latest_time))/3600;
    $query3  = $db->query("SELECT * FROM stations WHERE id = ?", array($data[$i]));
    $result3 = $query3->results();
    foreach ($result3 as $a) {
        $thresholdDownP = $a->thresholdDownP;
        $thresholdUpP   = $a->thresholdUpP;
        $emptyStatus    = $a->isEmpty;
        $stationName_s = $a->stationName;
        if ($emptyStatus == "1" or $hour>="24") {
            $color_button = "#".$initialColor_B;
            $href="#";
        } else if ($Pressure < $thresholdDownP) {
            $color_button = "#".$initialColor_G;
            $href="station.php?RFID=$RFIDs";
        } else if ($Pressure >= $thresholdDownP && $Pressure <= $thresholdUpP) {
            $color_button = "#".$initialColor_Y;
            $href="station.php?RFID=$RFIDs";
        } else if ($Pressure > $thresholdUpP) {
            $color_button = "#".$initialColor_R;
            $href="station.php?RFID=$RFIDs";
        }

    }
    $sn = $stationName_s;



    //create gauge object
    if(substr($data[$i], 0,1) == "G"){
      $gauges = $data[$i];
      $gauges_id = substr($data[$i], 1);  
      $sn = $data[$i];
      $queryg1  = $db->query("SELECT * FROM $gauges ORDER BY Time DESC LIMIT 1");
      $resultgs = $queryg1->results();

      foreach ($resultgs as $a) {
        $Pressure = $a->Pressure;
        $Voltage  = "";
        $Current  = "";
        $LPN = "";
        $latest_time = $a->Time;
      }
      $updateDate = date('Y-m-d H:i:s');
      $hour = (strtotime($updateDate)-strtotime($latest_time))/3600;
      $query3  = $db->query("SELECT * FROM gauges WHERE id = ?", array($gauges_id));
      $result3 = $query3->results();
      foreach ($result3 as $a) {
        $thresholdDownP = $a->thresholdDownP;
        $thresholdUpP   = $a->thresholdUpP;
        if($hour>="24"){
          $color_button = "#".$initialColor_B_G;
            $href="#";
        }
        else if ($Pressure < $thresholdDownP) {
            $color_button = "#".$initialColor_G_G;
            $href="gauge.php?GID=$gauges_id";
        } else if ($Pressure >= $thresholdDownP && $Pressure <= $thresholdUpP) {
            $color_button = "#".$initialColor_Y_G;
            $href="gauge.php?GID=$gauges_id";
        } else if ($Pressure > $thresholdUpP) {
            $color_button = "#".$initialColor_R_G;
            $href="gauge.php?GID=$gauges_id";
        }
      }
    }
    ?>
    <div class="col-xs-4">
     <div id="drag"  >
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
                <button style="height:40px;width:70px;background-color: transparent; left:-5px;" type="button" class="btn " id="button_control_HV" ></button>
        </div>
      </div>
      </div>
<?php }?>

</p>
</div>
</div>
</div>
</div>
</div>
</div>


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
                  url:'warehouseTemplate.php?WHName=<?=$WHName?>',
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
<script type="text/javascript">

     setInterval(function(){
        
            $.getJSON({
            type: "POST",
            url: 'flipperDataService.php',
            data:

            {
                WHName:"<?php echo $WHName;?>",
            },
            success: function(data) {
          
              console.log("success");
               console.log(data);
                var jsonData= data;

    console.log(jsonData['0']['temperature']+'&#8451');
    console.log(jsonData['0']['color']);
    document.getElementById('temp').innerHTML = jsonData['0']['temperature']+'&#8451';
    document.getElementById('temp').style.top = jsonData['0']['percentLocation'];
    $('.progress-bar').css('background-color',jsonData['0']['color']);
    $('.progress-bar').css('height',jsonData['0']['percent']);


            }
            });

       
  
}, 5000);

</script>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>
 <?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; // currently just the closing /body and /html ?>