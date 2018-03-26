<?php 
require_once 'users/init.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}

//$database = "USA";

    $usa = getWarehouseStatusColor("01ab63419");

//$database = "Israel";

    $isr = getWarehouseStatusColor("01ab62beb7");

//$database = "Amsterdam";

    $ams = getWarehouseStatusColor("faffffffffff");


//$database = "Taiwan_TN";

    $tn = getWarehouseStatusColor("01ab63bc4");


//$database = "Taiwan_HSC";

    $hsc = getWarehouseStatusColor("01ab63bbd");


//$database = "Seoul";

    $seoul = getWarehouseStatusColor("01ab6358a");



//$database = "Tokyo";

    $tokyo = getWarehouseStatusColor("01ab63473");


//$database = "Osaka";

    $osaka = getWarehouseStatusColor("01ab63562");


//$database = "Fukuoka";

    $fukuoka = getWarehouseStatusColor("01ab63464");


//$database = "Dublin";

    $dublin = "blue";


//$database = "Singapore";

    $singapore = getWarehouseStatusColor("01ab6344b");


//$database = "Shanghai";

    $shanghai = getWarehouseStatusColor("01ab62f11");

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESS HomePage</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="assets/css/styles.css">
  
</head>

<body>
    <div>
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
        </nav>
        <div id="page-wrapper">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
<style type="text/css">
    body{
        padding-top: 50px;
    }

    #container{
        right: 0%;
    }
</style>
<script>    
var map = AmCharts.makeChart("chartdiv1", {
    type: "map",
    "theme": "none",
    "fitMapToContainer" : "true",
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
        unlistedAreasColor: "#ffa500",
    
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
        images: [{
            zoomLevel: 1,
            scale: 1,
            title: "KLA-Tencor Headquarter",
            latitude:34.0522222, 
            longitude:-118.2427778,
            url:"warehouseUSA.php?location=USA"
        },{
            zoomLevel: 1,
            scale: 1,
            title: "Israel",
            latitude: 31.046051,
            longitude: 34.85161199999993,
            url:"israel.php?location=Israel"
        }
        ,
        {
            zoomLevel: 1,
            scale: 1,
            title: "Amsterdam",
            latitude: 52.3738,
            longitude: 4.8910,
            url:"amsterdam.php?location=Amsterdam"
        },
        {
            zoomLevel: 1,
            scale: 1,
            title: "Taiwan - Tainan",
            latitude: 22.9333,
            longitude: 120.2036,
            url:"taiwan-tn.php?location=Taiwan_TN"
        },
        {
            zoomLevel: 1,
            scale: 1,
            title: "Taiwan - Hsinchu",
            latitude: 24.8047,
            longitude: 120.9714,
            url:"taiwan-hsc.php?location=Taiwan_HSC"
        },
        {
            zoomLevel: 1,
            scale: 1,
            title: "Seoul",
            latitude: 37.5139,
            longitude: 126.9828,
            url:"seoul.php?location=Seoul"
        },
        {
            zoomLevel: 1,
      scale: 1,
      title: "Tokyo",
      latitude: 35.685,
      longitude: 139.7514,
      url:"tokyo.php?location=Tokyo"
        },
        {
            zoomLevel: 1,
      scale: 1,
      title: "Osaka",
      latitude: 33.6667,
      longitude: 135.5,
      url:"osaka.php?location=Osaka"
        },
        {
            zoomLevel: 1,
      scale: 1,
      title: "Fukuoka",
      latitude: 33.5833,
      longitude: 130.4,
      url:"fukuoka.php?location=Fukuoka"
        },
        {
            zoomLevel: 1,
      scale: 1,
      title: "Dublin",
      latitude: 55.3441,
      longitude: -7.4675,
      url:"dublin.php?location=Dublin"
        },
        {
            zoomLevel: 1,
      scale: 1,
      title: "Singapore",
      latitude: 1.2894,
      longitude: 103.8500,
      url:"singapore.php?location=Singapore"
        },
        {
            zoomLevel: 1,
      scale: 1,
      title: "Shanghai",
      latitude: 31.2674,
      longitude: 121.5222,
      url:"shanghai.php?location=Shanghai"
        }
    ]
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
        var image = map.dataProvider.images[0];
        var usa = "<?php echo $usa?>";
        if ('undefined' == typeof image.externalElement){
            if(usa == "gray"){
            image.externalElement = createGrayMarker(image);}// check if it has corresponding HTML element
            if(usa == "green"){
            image.externalElement = createGreenMarker(image);}// check if it has corresponding HTML element
            if(usa == "yellow"){
            image.externalElement = createYellowMarker(image);}
            
           }
           image.externalElement.style.top = map.latitudeToY(image.latitude) + 'px';
        image.externalElement.style.left = map.longitudeToX(image.longitude) + 'px';

        
           
        var image1 = map.dataProvider.images[1];
        var isr = "<?php echo $isr?>";
        if ('undefined' == typeof image1.externalElement){
            if(isr == "gray"){
            image1.externalElement = createGrayMarker(image1);}// check if it has corresponding HTML element
            if(isr == "green"){
            image1.externalElement = createGreenMarker(image1);}// check if it has corresponding HTML element
            if(isr == "yellow"){
            image1.externalElement = createYellowMarker(image1);}
            
           }
           image1.externalElement.style.top = map.latitudeToY(image1.latitude) + 'px';
        image1.externalElement.style.left = map.longitudeToX(image1.longitude) + 'px';

        
            
        //add object 2 to map
        //Amsterdam
        var image2 = map.dataProvider.images[2];
         var ams = "<?php echo $ams?>";
        if ('undefined' == typeof image2.externalElement){
            if(ams == "gray"){
            image2.externalElement = createGrayMarker(image2);}// check if it has corresponding HTML element
            if(ams == "green"){
            image2.externalElement = createGreenMarker(image2);}// check if it has corresponding HTML element
            if(ams == "yellow"){
            image2.externalElement = createYellowMarker(image2);}
            
           }
        image2.externalElement.style.top = map.latitudeToY(image2.latitude) + 'px';
        image2.externalElement.style.left = map.longitudeToX(image2.longitude) + 'px';
        
        //add object 3 to map
        //Taipei
        var image3 = map.dataProvider.images[3];
          var tn = "<?php echo $tn?>";
        if ('undefined' == typeof image3.externalElement){
            if(tn == "gray"){
            image3.externalElement = createGrayMarker(image3);}// check if it has corresponding HTML element
            if(tn == "green"){
            image3.externalElement = createGreenMarker(image3);}// check if it has corresponding HTML element
            if(tn == "yellow"){
            image3.externalElement = createYellowMarker(image3);}
            
           }
           
        image3.externalElement.style.top = map.latitudeToY(image3.latitude) + 'px';
        image3.externalElement.style.left = map.longitudeToX(image3.longitude) + 'px';
        
        //add object 4 to map
        //Seoul
        var image4 = map.dataProvider.images[4];
        var hsc = "<?php echo $hsc?>";
        if ('undefined' == typeof image4.externalElement){
            if(hsc == "gray"){
            image4.externalElement = createGrayMarker(image4);}// check if it has corresponding HTML element
            if(hsc == "green"){
            image4.externalElement = createGreenMarker(image4);}// check if it has corresponding HTML element
            if(hsc == "yellow"){
            image4.externalElement = createYellowMarker(image4);}
            
           }
           
        image4.externalElement.style.top = map.latitudeToY(image4.latitude) + 'px';
        image4.externalElement.style.left = map.longitudeToX(image4.longitude) + 'px';
        
        //add object 5 to map
        //Tokyo
        var image5 = map.dataProvider.images[5];
          var seoul = "<?php echo $seoul?>";
        if ('undefined' == typeof image5.externalElement){
            if(seoul == "gray"){
            image5.externalElement = createGrayMarker(image5);}// check if it has corresponding HTML element
            if(seoul == "green"){
            image5.externalElement = createGreenMarker(image5);}// check if it has corresponding HTML element
            if(seoul == "yellow"){
            image5.externalElement = createYellowMarker(image5);}
            
           }
           
        image5.externalElement.style.top = map.latitudeToY(image5.latitude) + 'px';
        image5.externalElement.style.left = map.longitudeToX(image5.longitude) + 'px';
        
        //add object 6 to map
        //Dublin
        var image6 = map.dataProvider.images[6];
           var tokyo = "<?php echo $tokyo?>";
        if ('undefined' == typeof image6.externalElement){
            if(tokyo == "gray"){
            image6.externalElement = createGrayMarker(image6);}// check if it has corresponding HTML element
            if(tokyo == "green"){
            image6.externalElement = createGreenMarker(image6);}// check if it has corresponding HTML element
            if(tokyo == "yellow"){
            image6.externalElement = createYellowMarker(image6);}
            
           }
           
        image6.externalElement.style.top = map.latitudeToY(image6.latitude) + 'px';
        image6.externalElement.style.left = map.longitudeToX(image6.longitude) + 'px';
        
        //add object 7 to map
        //Singapore
        var image7 = map.dataProvider.images[7];
           var osaka = "<?php echo $osaka?>";
        if ('undefined' == typeof image7.externalElement){
            if(osaka == "gray"){
            image7.externalElement = createGrayMarker(image7);}// check if it has corresponding HTML element
            if(osaka == "green"){
            image7.externalElement = createGreenMarker(image7);}// check if it has corresponding HTML element
            if(osaka == "yellow"){
            image7.externalElement = createYellowMarker(image7);}
            
           }
        
        image7.externalElement.style.top = map.latitudeToY(image7.latitude) + 'px';
        image7.externalElement.style.left = map.longitudeToX(image7.longitude) + 'px';
        
        //add object 8 to map
        //Shanghai
        var image8 = map.dataProvider.images[8];
           var fukuoka = "<?php echo $fukuoka?>";
        if ('undefined' == typeof image8.externalElement){
            if(fukuoka == "gray"){
            image8.externalElement = createGrayMarker(image8);}// check if it has corresponding HTML element
            if(fukuoka == "green"){
            image8.externalElement = createGreenMarker(image8);}// check if it has corresponding HTML element
            if(fukuoka == "yellow"){
            image8.externalElement = createYellowMarker(image8);}
            
           }
        
        image8.externalElement.style.top = map.latitudeToY(image8.latitude) + 'px';
        image8.externalElement.style.left = map.longitudeToX(image8.longitude) + 'px';
        
        var image9 = map.dataProvider.images[9];
           var dublin = "<?php echo $dublin?>";
        if ('undefined' == typeof image9.externalElement){
            if(dublin == "gray"){
            image9.externalElement = createGrayMarker(image9);}// check if it has corresponding HTML element
            if(dublin == "green"){
            image9.externalElement = createGreenMarker(image9);}// check if it has corresponding HTML element
            if(dublin == "yellow"){
            image9.externalElement = createYellowMarker(image9);}
            
           }
        
        image9.externalElement.style.top = map.latitudeToY(image9.latitude) + 'px';
        image9.externalElement.style.left = map.longitudeToX(image9.longitude) + 'px';
        
        var image10 = map.dataProvider.images[10];
           var singapore = "<?php echo $singapore?>";
        if ('undefined' == typeof image10.externalElement){
            if(singapore == "gray"){
            image10.externalElement = createGrayMarker(image10);}// check if it has corresponding HTML element
            if(singapore == "green"){
            image10.externalElement = createGreenMarker(image10);}// check if it has corresponding HTML element
            if(singapore == "yellow"){
            image10.externalElement = createYellowMarker(image10);}
                       }
        
        image10.externalElement.style.top = map.latitudeToY(image10.latitude) + 'px';
        image10.externalElement.style.left = map.longitudeToX(image10.longitude) + 'px';
        
         var image11 = map.dataProvider.images[11];
           var shanghai = "<?php echo $shanghai?>";
        if ('undefined' == typeof image11.externalElement){
            if(shanghai == "gray"){
            image11.externalElement = createGrayMarker(image11);}// check if it has corresponding HTML element
            if(shanghai == "green"){
            image11.externalElement = createGreenMarker(image11);}// check if it has corresponding HTML element
            if(shanghai == "yellow"){
            image11.externalElement = createYellowMarker(image11);}
            
           }
        
        image11.externalElement.style.top = map.latitudeToY(image11.latitude) + 'px';
        image11.externalElement.style.left = map.longitudeToX(image11.longitude) + 'px';
        
        
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
    

    
</body>
  <link rel="stylesheet" type="text/css" href="CSS/dotForMap.css">
</html>
