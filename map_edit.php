<?php 
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}

if (!empty($_POST)) {
    if (!empty($_POST['ChangeColor'])) {

        $TypeSG       = $_POST['TypeSG'];
        $water_color   = Input::get('water_color');
        $land_color  = Input::get('land_color');
        $normal_color = Input::get('normal_color');
        $warning_color = Input::get('warning_color');
        $loss_color = Input::get('loss_color');
        $token        = $_POST['csrf'];
        if (!Token::check($token)) {die('Token doesn\'t match!');}
        $form_valid = false; // assume the worst
        $validation = new Validate();
        $validation->check($_POST, array(

        ));

        if ($validation->passed()) {

            $form_valid = true;
            try {
                
                    $fields = array(
                        'Water'   => Input::get('water_color'),
                        'Land'  => Input::get('land_color'),
                        

                    );
                    $db->UPDATE('mapColor', 0, $fields);
                    $fields1 = array(
                        'Normal'   => Input::get('normal_color'),
                        'Warning'  => Input::get('warning_color'),
                        'Loss' => Input::get('loss_color'),

                    );
                    $db->UPDATE('dotColor', 0, $fields1);
                
                $successes[] = lang("ACCOUNT_USER_ADDED");
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

    }
}
$array = array();
$array_color = array();
$db = DB::getInstance();
$query1 = $db->query("SELECT * FROM warehouses");
$result1 = $query1->results();
foreach ($result1 as $key) {
    if($key->warehouseName == "USA1" or $key->warehouseName == "USA2"){
        $array['zoomLevel']=1;
    $array['scale']=1;
    $array['title'] = "KLA-Tencor Headquarter";
    $array['latitude'] = $key->latitude;
    $array['longitude'] = $key->longitude;
    $array['url'] = "/KTproj/users/warehouseTemplate.php?WHName=USA";
    $data_encode[] = $array;
    $array_color['warehouseName'] = "USA";
    $array_color['color'] = getWarehouseStatusColor($key->MAC);
    $color_encode[] = $array_color;
    }
    
    else{
        $array['zoomLevel']=1;
    $array['scale']=1;
    $array['title'] = $key->warehouseName;
    $array['latitude'] = $key->latitude;
    $array['longitude'] = $key->longitude;
    $array['url'] = "/KTproj/users/warehouseTemplate.php?WHName=$key->warehouseName";
    $data_encode[] = $array;
    $array_color['warehouseName'] = $key->warehouseName;
    $array_color['color'] = getWarehouseStatusColor($key->MAC);
    $color_encode[] = $array_color;
    }
    
}
$data = json_encode($data_encode);

$color = json_encode($color_encode);
$query_c  = $db->query("SELECT * FROM mapColor");
$result_c = $query_c->results();
foreach ($result_c as $key) {
    $initialColor_water = $key->Water;
    $initialColor_land = $key->Land;
    
}
$query_c  = $db->query("SELECT * FROM dotColor");
$result_c = $query_c->results();
foreach ($result_c as $key) {
    $initialColor_normal = $key->Normal;
    $initialColor_warning = $key->Warning;
    $initialColor_loss = $key->Loss;
    
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESS HomePage</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/aos.css">
    <link rel="stylesheet" href="assets/css/styles.css">
   
  
</head>

<body>
                
                <div class="row">
                <div id="chartdiv1"  style="position: absolute; width: 100%;height: 100%; left: 0%; right:0%; top: auto;"> </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-8" style=" top:80%"></div>
                    <div class="col-xs-12 col-md-4">
                        <form class="form-group" action="map_edit.php" method="POST" id="payment-form" style="position: fixed;bottom: 0;background-color: transparent; " >

                                <script src="/KTproj/JS/jscolor.js"></script>
                                <fieldset>
                                <legend><h4>Change Color:</h4></legend>
                                    <div class="col-xs-4 col-md-4">
                                    <fieldset>
                                    <legend><h5>Map Color:</h5></legend>
                                    <div class="form-group">
                                        <div class="col-xs-5 col-md-4">
                                        <label  for="water_color" style="display:block; text-align:center;" >Water:</label>
                                        </div>
                                        <div class="col-xs-4 col-md-8">
                                        <input  name="water_color" id="water_color" value="<?php if (!$form_valid && !empty($_POST)) {echo $water_color;} else { echo $initialColor_water;}?>" class="form-control jscolor {closable:true,closeText:'Close me!'}" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-5 col-md-4">
                                        <label for="land_color">Land:</label>
                                        </div>
                                        <div class="col-xs-4 col-md-8">
                                        <input class="form-control jscolor {closable:true,closeText:'Close me!'}" name="land_color" id="land_color" value="<?php if (!$form_valid && !empty($_POST)) {echo $land_color;} else {echo $initialColor_land;}?>" required >
                                        </div>
                                    </div>
                                    </fieldset>
                                    </div>
                                    
                                    
                                    <div class="col-xs-4 col-md-4">
                                    <fieldset>
                                        <legend><h5>Dot Color:</h5></legend>
                                    <div class="form-group">
                                        <div class="col-xs-5 col-md-4">
                                        <label  for="normal_color" style="display:block; text-align:center;" >Normal:</label>
                                        </div>
                                        <div class="col-xs-4 col-md-8">
                                        <input  name="normal_color" id="normal_color" value="<?php if (!$form_valid && !empty($_POST)) {echo $normal_color;} else { echo $initialColor_normal;}?>" class="form-control jscolor {closable:true,closeText:'Close me!'}" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-5 col-md-4">
                                        <label for="warning_color">Warning:</label>
                                        </div>
                                        <div class="col-xs-4 col-md-8">
                                        <input class="form-control jscolor {closable:true,closeText:'Close me!'}" name="warning_color" id="warning_color" value="<?php if (!$form_valid && !empty($_POST)) {echo $warning_color;} else {echo $initialColor_warning;}?>" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-5 col-md-4">
                                        <label for="loss_color">Loss:</label>
                                        </div>
                                        <div class="col-xs-4 col-md-8">
                                        <input class="form-control jscolor {closable:true,closeText:'Close me!'}" name="loss_color" id="loss_color" value="<?php if (!$form_valid && !empty($_POST)) {echo $loss_color;} else {echo $initialColor_loss;}?>" required >
                                        </div>
                                    </div>
                                     </fieldset>
                                    </div >
                                   
                                    <div class="col-xs-4 col-md-4">
                                    <fieldset>
                                    <legend><h5>Submit:</h5></legend>
                                    <div class="form-group">
                                    <input type="hidden" value="<?=Token::generate();?>" name="csrf">
                                    <input class='btn btn-primary' type='submit' name='ChangeColor' value='Change' />
                                    </div>
                                    </fieldset>
                                    </div>
                                
                                </fieldset>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>     
    </div>

    
  <script src="JS/ammap/ammap.js"></script>
  <script src="JS/ammap/maps/js/worldLow.js"></script>
  <script src="JS/ammap/plugins/responsive/responsive.min.js" type="text/javascript"></script>
  <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="CSS/aos.js"></script>
<style type="text/css">
    body{
        padding-top: 50px;
    }

    #container{
        right: 0%;
    }
        /*
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
*/


/* 
    Created on : Dec 17, 2015, 5:04:06 PM
    Author     : Nguyen Thanh Quang - VGU
*/



body {
    padding-top: 65px;
}

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 50px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s
}

.sidenav a:hover,
.offcanvas a:focus {
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

@media screen and (max-height: 450px) {
    .sidenav {
        padding-top: 15px;
    }
    .sidenav a {
        font-size: 18px;
    }
}

#chartdiv {
    background: #ffffff;
    width: 90%;
    height: 500px;
    position: absolute;
    left: 5em
}

.map-marker {
    /* adjusting for the marker dimensions 
    so that it is centered on coordinates */
    margin-left: 0px;
    margin-top: -8px;
}

.map-marker.map-clickable {
    cursor: pointer;
}

.pulseRed {
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 100px;
    border: 2px solid #ff0000;
    background-color: #ff0000;
    z-index: 1;
}

.map-marker .dotRed {
    border: 10px solid #ff0000;
    background: transparent;
    -webkit-border-radius: 60px;
    -moz-border-radius: 60px;
    border-radius: 60px;
    height: 50px;
    width: 50px;
    -webkit-animation: pulse 1s ease-out;
    -moz-animation: pulse 1s ease-out;
    animation: pulse 1s ease-out;
    -webkit-animation-iteration-count: infinite;
    -moz-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    position: absolute;
    top: -15px;
    left: -15px;
    z-index: 1;
    opacity: 0;
}

.pulseYellow {
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 100px;
    border: 2px solid <?php echo "#".$initialColor_warning?>;
    background-color: <?php echo "#".$initialColor_warning?>;
    z-index: 1;
}

.map-marker .dotYellow {
    border: 10px solid <?php echo "#".$initialColor_warning?>;
    background: transparent;
    -webkit-border-radius: 60px;
    -moz-border-radius: 60px;
    border-radius: 60px;
    height: 50px;
    width: 50px;
    -webkit-animation: pulse 3s ease-out;
    -moz-animation: pulse 3s ease-out;
    animation: pulse 3s ease-out;
    -webkit-animation-iteration-count: infinite;
    -moz-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    position: absolute;
    top: -15px;
    left: -15px;
    z-index: 1;
    opacity: 0;
}

.pulseGreen {
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 100px;
    border: 2px solid <?php echo "#".$initialColor_normal?>;
    background-color: <?php echo "#".$initialColor_normal?>;
    z-index: 1;
}

.map-marker .dotGreen {
    border: 10px solid <?php echo "#".$initialColor_normal?>;
    background: transparent;
    -webkit-border-radius: 60px;
    -moz-border-radius: 60px;
    border-radius: 60px;
    height: 50px;
    width: 50px;
    -webkit-animation: pulse 3s ease-out;
    -moz-animation: pulse 3s ease-out;
    animation: pulse 3s ease-out;
    -webkit-animation-iteration-count: infinite;
    -moz-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    position: absolute;
    z-index: 1;
    opacity: 0;
    top: -15px;
    left: -15px;
}

.pulseGray {
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 100px;
    border: 2px solid <?php echo "#".$initialColor_loss?>;
    background-color: <?php echo "#".$initialColor_loss?>;
    z-index: 1;
}

.map-marker .dotGray {
    border: 10px solid <?php echo "#".$initialColor_loss?>;
    background: transparent;
    -webkit-border-radius: 60px;
    -moz-border-radius: 60px;
    border-radius: 60px;
    height: 50px;
    width: 50px;
    -webkit-animation: pulse 3s ease-out;
    -moz-animation: pulse 3s ease-out;
    animation: pulse 3s ease-out;
    -webkit-animation-iteration-count: infinite;
    -moz-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    position: absolute;
    top: -15px;
    left: -15px;
    z-index: 1;
    opacity: 0;
}

@-moz-keyframes pulse {
    0% {
        -moz-transform: scale(0);
        opacity: 0.0;
    }
    25% {
        -moz-transform: scale(0);
        opacity: 0.1;
    }
    50% {
        -moz-transform: scale(0.1);
        opacity: 0.3;
    }
    75% {
        -moz-transform: scale(0.5);
        opacity: 0.5;
    }
    100% {
        -moz-transform: scale(1);
        opacity: 0.0;
    }
}

@-webkit-keyframes "pulse" {
    0% {
        -webkit-transform: scale(0);
        opacity: 0.0;
    }
    25% {
        -webkit-transform: scale(0);
        opacity: 0.1;
    }
    50% {
        -webkit-transform: scale(0.1);
        opacity: 0.3;
    }
    75% {
        -webkit-transform: scale(0.5);
        opacity: 0.5;
    }
    100% {
        -webkit-transform: scale(1);
        opacity: 0.0;
    }
}

</style>
<script>    
var map = AmCharts.makeChart("chartdiv1", {
    "type": "map",
    "theme": "light",
    "fitMapToContainer" : "true",
    "addClassNames": true,
    "color": "#000000",
    "projection": "winkel3",
    "backgroundAlpha": 1,
    "backgroundColor": "#"+"<?php echo $initialColor_water?>",
    imagesSettings: {
        rollOverColor: "#089282",
        rollOverScale: 3,
        selectedScale: 3,
        selectedColor: "#089282",
        color: "#13564e"
    },
    areasSettings: {
                alpha: 1,
        color: "#3343b0",
        colorSolid: "#ffffff",
        unlistedAreasAlpha: 0.7,

        unlistedAreasColor: "#"+"<?php echo $initialColor_land?>",
    
        outlineAlpha: 1,
        outlineThickness: 0.51,
        rollOverColor: "#3c5bdc",
        rollOverOutlineColor: "#000000",
        selectedOutlineColor: "#000000",
        selectedColor: "#ffae19",
        unlistedAreasOutlineColor: "#000000",
        unlistedAreasOutlineAlpha: 0.5,
                borderAlpha: 1,
                borderColor: "#ffffff"
              
       
    },
    zoomControl:{
        zoomControl: "enable",
        minZoomLevel: 1.0
    },
    "mouseWheelZoomEnabled": true,
    "allowClickOnSelectedObject": true,
    dataProvider: {
        map: "worldLow",
        images: <?php echo $data;?>,
    
    },
    "responsive": {
    "enabled": true
  }

});


// add events to recalculate map position when the map is moved or zoomed
map.addListener("positionChanged", updateCustomMarkers);
map.addListener("rendered",centerMapOnSelectedObject);
//testing
function centerMapOnSelectedObject() {
    map.zoomToLongLat(map.zoomLevel(), 7.000000, 20.046051, true);
}
// this function will take current images on the map and create HTML elements for them
function updateCustomMarkers (event) {
    // get map object
    var map = event.chart;
    
    // go through all of the images
    
        // get MapImage object
        // 
        //KLA-tencor Headquarter
        
        
        var color = <?php echo $color?>;
        console.log(map.dataProvider.images.length);
       for (var i = 0; i < map.dataProvider.images.length; i++) {
           var image = map.dataProvider.images[i];
           var title = map.dataProvider.images[i]['title'];
           var color_warehouse="";

           if(title =="KLA-Tencor Headquarter" )
           {
                for (var j = 0; j < color.length; j++) {
                    if(color[j]['warehouseName'] == "USA"){
                        color_warehouse = color[j]['color'];
                        break;
                    }
                }
           }
           else
           {
                for (var j = 0; j < color.length; j++) {
                    if(color[j]['warehouseName'] == title){
                        color_warehouse = color[j]['color'];
                        break;
                    }
                }
           }
           if ('undefined' == typeof image.externalElement){
            if(color_warehouse == "gray"){
            image.externalElement = createGrayMarker(image);}// check if it has corresponding HTML element
            if(color_warehouse == "green"){
            image.externalElement = createGreenMarker(image);}// check if it has corresponding HTML element
            if(color_warehouse == "yellow"){
            image.externalElement = createYellowMarker(image);}
            
           }
           image.externalElement.style.top = map.latitudeToY(image.latitude) + 'px';
            image.externalElement.style.left = map.longitudeToX(image.longitude) + 'px';
       }

    
        
}

// this function creates and returns a new marker element
function createRedMarker(image) {
    // create holder
    var holder = document.createElement('div');
    holder.className = 'map-marker';
    holder.title = image.title;
    holder.style.position = 'absolute';
    
    // maybe add a link to it?
    if (undefined != image.url) {
        holder.onclick = function() {
            window.location.href = image.url;
        };
        holder.className += ' map-clickable';
    }
    
    // create dot
    var dot = document.createElement('div');
    dot.className = 'dotRed';
    holder.appendChild(dot);
    
    // create pulse
    var pulse = document.createElement('div');
    pulse.className = 'pulseRed';
    holder.appendChild(pulse);
    
    // append the marker to the map container
    image.chart.chartDiv.appendChild(holder);
    return holder;
}
function createGreenMarker(image) {
    // create holder
    var holder = document.createElement('div');
    holder.className = 'map-marker';
    holder.title = image.title;
    holder.style.position = 'absolute';
    
    // maybe add a link to it?
    if (undefined != image.url) {
        holder.onclick = function() {
            window.location.href = image.url;
        };
        holder.className += ' map-clickable';
    }
    
    // create dot
    var dot = document.createElement('div');
    dot.className = 'dotGreen';
    holder.appendChild(dot)
;    
    // create pulse
    var pulse = document.createElement('div');
    pulse.className = 'pulseGreen';
    holder.appendChild(pulse);
    
    // append the marker to the map container
    image.chart.chartDiv.appendChild(holder);
    return holder;
}
function createYellowMarker(image) {
    // create holder
    console.log("yellow");
    var holder = document.createElement('div');
    holder.className = 'map-marker';
    holder.title = image.title;
    holder.style.position = 'absolute';
    
    // maybe add a link to it?
    if (undefined != image.url) {
        holder.onclick = function() {
            window.location.href = image.url;
        };
        holder.className += ' map-clickable';
    }
    
    // create dot
    var dot = document.createElement('div');
    dot.className = 'dotYellow';
    holder.appendChild(dot);
    
    // create pulse
    var pulse = document.createElement('div');
    pulse.className = 'pulseYellow';
    holder.appendChild(pulse);
    
    // append the marker to the map container
    image.chart.chartDiv.appendChild(holder);
    return holder;
}

function createGrayMarker(image) {
    // create holder
    var holder = document.createElement('div');
    holder.className = 'map-marker';
    holder.title = image.title;
    holder.style.position = 'absolute';
    
    // maybe add a link to it?
    if (undefined != image.url) {
        holder.onclick = function() {
            window.location.href = image.url;
        };
        holder.className += ' map-clickable';
    }
    
    // create dot
    var dot = document.createElement('div');
    dot.className = 'dotGray';
    holder.appendChild(dot);
    
    // create pulse
    var pulse = document.createElement('div');
    pulse.className = 'pulseGray';
    holder.appendChild(pulse);
    
    // append the marker to the map container
    image.chart.chartDiv.appendChild(holder);
    return holder;
}
</script>
<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "230px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>
    
<!-- <script src="js/search.js" charset="utf-8"></script> -->
<script type="text/javascript" src="JS/jquery.min.js"></script>
    
</body>
</scipt>

</html>
