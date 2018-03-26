<?php 
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}

//$database = "USA";

//    $USA = getWarehouseStatusColor("0 1a b6 3 4 19 ");

//$database = "Israel";

//    $Israel = getWarehouseStatusColor("0 1a b6 2 be b7 ");

//$database = "Amsterdam";

 //   $Amsterdam = getWarehouseStatusColor("fa ff ff ff ff ff");


//$database = "Taiwan_TN";

//    $Taiwan_TN = getWarehouseStatusColor("0 1a b6 3 b c4");


//$database = "Taiwan_HSC";

//    $Taiwan_HSC = getWarehouseStatusColor("0 1a b6 3 b bd");


//$database = "Seoul";

//    $Seoul = getWarehouseStatusColor("0 1a b6 3 5 8a");



//$database = "Tokyo";

//    $Tokyo = getWarehouseStatusColor("0 1a b6 3 4 73");


//$database = "Osaka";

 //   $Osaka = getWarehouseStatusColor("0 1a b6 3 5 62");


//$database = "Fukuoka";

 //   $Fukuoka = getWarehouseStatusColor("0 1a b6 3 4 64");


//$database = "Dublin";

 //   $Dublin = "gray";


//$database = "Singapore";

  //  $Singapore = getWarehouseStatusColor("0 1a b6 3 4 4b ");


//$database = "Shanghai";

 //   $Shanghai = getWarehouseStatusColor("0 1a b6 2 f1 1 ");


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

    <!--
        <nav class="navbar navbar-inverse navbar-fixed-top show visible-xs-block visible-sm-block visible-md-block visible-lg-block visible-xs-inline visible-sm-inline visible-md-inline" data-aos="fade-up" id="navbar2">
            <div class="container">
                <div class="navbar-header"><a class="navbar-brand navbar-link" href="#" data-aos="fade-up"><strong>ESS</strong> </a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1" id="collapse2"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav" id="navBar1">
                        <li class="dropdown" data-aos="fade-up" id="dropMenu"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#" data-aos="fade-up">Settings <span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                <li role="presentation"><a href="#">About </a></li>
                                <li role="presentation"><a href="emails.php">Mail List</a></li>
                                <li role="presentation"><a href="../export">Export Archive Data</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav" id="Nav1">
                        <li role="presentation"><a href="warehouseUSA.php?location=USA">| USA |</a></li>
                        <li role="presentation"><a href="amsterdam.php?location=Amsterdam">| AMS |</a></li>
                        <li role="presentation"><a href="israel.php?location=Israel">| ISR |</a></li>
                        <li role="presentation"><a href="taiwan-tn.php?location=Taiwan_TN">| TW-TN |</a></li>
                        <li role="presentation"><a href="taiwan-hsc.php?location=Taiwan_HSC">| TW-HSC |</a></li>
                        <li role="presentation"><a href="seoul.php?location=Seoul">| SEOUL |</a></li>
                        <li role="presentation"><a href="tokyo.php?location=Tokyo">| TKO |</a></li>
                        <li role="presentation"><a href="osaka.php?location=Osaka">| OSA |</a></li>
                        <li role="presentation"><a href="fukuoka.php?location=Fukuoka">| FUK |</a></li>
                        <li role="presentation"><a href="dublin.php?location=Dublin">| DUB |</a></li>
                        <li role="presentation"><a href="singapore.php?location=Singapore">| SG |</a></li>
                        <li role="presentation"><a href="shanghai.php?location=Shanghai">| SH |</a></li>
                    </ul>
                </div>
            </div>
        </nav>-->
        
            <div class="container">
            <div id="chartdiv1" class="row" style="position: absolute; width: 100%;height: 100%; left: 0%; right:0%; top: auto;"> </div>
            </div>
        </div>
        
    </div>

    
  <script src="JS/ammap/ammap.js"></script>
  <script src="JS/ammap/maps/js/worldLow.js"></script>
  <script src="JS/ammap/plugins/responsive/responsive.min.js" type="text/javascript"></script>
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
    type: "map",
    "theme": "none",
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
  <!--link rel="stylesheet" type="text/css" href="CSS/dotForMap.css"-->

</html>
