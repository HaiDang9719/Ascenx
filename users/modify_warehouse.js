
function edit_row_email(id,password)
{
 var email=document.getElementById("email_val"+id).innerHTML;
 document.getElementById("password_val"+id).innerHTML="";
 document.getElementById("email_val"+id).contentEditable = "true";
 document.getElementById("password_val"+id).contentEditable = "true";
   
 document.getElementById("edit_button_email"+id).style.display="none";
 document.getElementById("save_button_email"+id).style.display="block";
}
function save_row_email(id)
{
  document.getElementById("email_val"+id).contentEditable = "false";
  document.getElementById("password_val"+id).contentEditable = "false";

  var email=document.getElementById("email_val"+id).innerHTML;
  var password=document.getElementById("password_val"+id).innerHTML;

  document.getElementById("edit_button_email"+id).style.display="block";
  document.getElementById("save_button_email"+id).style.display="block";

  document.getElementById("email_val"+id).innerHTML=email;
  document.getElementById("password_val"+id).innerHTML="**************";
  console.log(password);
 $.ajax
 ({
  type:'post',
  url:'modify_warehouse.php',
  data:{
   edit_row_email:'edit_row_email',  
   email:email,
   password:password,
  
   
   
  },
  success:function(response) {
   
  }
 });
}

function edit_row_checkbox(id)
{

 document.getElementById("P1_val"+id).disabled = false;
 document.getElementById("P2_val"+id).disabled = false;
 document.getElementById("P3_val"+id).disabled = false;
 document.getElementById("P4_val"+id).disabled = false;
 document.getElementById("P5_val"+id).disabled = false;
 document.getElementById("P6_val"+id).disabled = false;
   
 document.getElementById("edit_button_checkbox"+id).style.display="none";
 document.getElementById("save_button_checkbox"+id).style.display="block";
}
function save_row_checkbox(id)
{
  document.getElementById("P1_val"+id).disabled = true;
 document.getElementById("P2_val"+id).disabled = true;
 document.getElementById("P3_val"+id).disabled = true;
 document.getElementById("P4_val"+id).disabled = true;
 document.getElementById("P5_val"+id).disabled = true;
  document.getElementById("P6_val"+id).disabled = true;


  var P1=document.getElementById("P1_val"+id).checked;
  var P2=document.getElementById("P2_val"+id).checked;
  var P3=document.getElementById("P3_val"+id).checked;
  var P4=document.getElementById("P4_val"+id).checked;
  var P5=document.getElementById("P5_val"+id).checked;
  var P6=document.getElementById("P6_val"+id).checked;
  if(P1==true) P1="checked";
  else P1="unchecked";
  if(P2==true) P2="checked";
  else P2="unchecked";
  if(P3==true) P3="checked";
  else P3="unchecked";
  if(P4==true) P4="checked";
  else P4="unchecked";
  if(P5==true) P5="checked";
  else P5="unchecked";
  if(P6==true) P6="checked";
  else P6="unchecked";
  document.getElementById("edit_button_checkbox"+id).style.display="block";
  document.getElementById("save_button_checkbox"+id).style.display="block";

 $.ajax
 ({
  type:'post',
  url:'modify_warehouse.php',
  data:{
  edit_row_checkbox:'edit_row_checkbox',  
   P1:P1,
   P2:P2,
   P3:P3,
   P4:P4, 
   P5:P5,
   P6:P6,
  },
  success:function(response) {
   
  }
 });
}

function edit_row_time(id,day)
{

 document.getElementById("P2_Time_val"+id).contentEditable = "true";
 document.getElementById("P3_Week_val"+id).contentEditable = "true";
 document.getElementById("P3_Hour_val"+id).contentEditable = "true";
 document.getElementById("P3_Minute_val"+id).contentEditable = "true";
 document.getElementById("P6_Hour_val"+id).contentEditable = "true";
 document.getElementById("P6_Minute_val"+id).contentEditable = "true";
   
 
  var value2 = day.split(",");
  console.log(value2.length);
  for (var i = 0; i < value2.length; i++) {
    document.getElementById("P3_Day_val"+id).options.add(new Option(value2[i], value2[i]));
  } 
  

 document.getElementById("edit_button_time"+id).style.display="none";
 document.getElementById("save_button_time"+id).style.display="block";
}
function save_row_time(id,day)
{
 document.getElementById("P2_Time_val"+id).contentEditable = "false";
 document.getElementById("P3_Week_val"+id).contentEditable = "false";
 document.getElementById("P3_Hour_val"+id).contentEditable = "false";
 document.getElementById("P3_Minute_val"+id).contentEditable = "false";
 document.getElementById("P6_Hour_val"+id).contentEditable = "false";
 document.getElementById("P6_Minute_val"+id).contentEditable = "false";

var value2 = day.split(",");
  var P3_Day,opt2;
    for (var i=0; i<value2.length+1; i++) {
        opt2 = document.getElementById("P3_Day_val"+id).options[i];
        // check if selected
        if ( opt2.selected ) {
            // add to array of option elements to return from this function
            P3_Day= opt2.text;
        }
    }console.log(P3_Day);
    
    for (var i = document.getElementById("P3_Day_val"+id).options.length-1; i>=0; i--) {
    document.getElementById("P3_Day_val"+id).remove(i);
  }
  
  document.getElementById("P3_Day_val"+id).options.add(new Option(P3_Day, P3_Day));

 var P2_Time = document.getElementById("P2_Time_val"+id).innerHTML;
 var P3_Week = document.getElementById("P3_Week_val"+id).innerHTML;
 var P3_Hour = document.getElementById("P3_Hour_val"+id).innerHTML;
 var P3_Minute = document.getElementById("P3_Minute_val"+id).innerHTML;
 var P6_Hour = document.getElementById("P6_Hour_val"+id).innerHTML;
 var P6_Minute = document.getElementById("P6_Minute_val"+id).innerHTML;

 document.getElementById("P2_Time_val"+id).innerHTML = P2_Time;
 document.getElementById("P3_Week_val"+id).innerHTML = P3_Week;
 document.getElementById("P3_Hour_val"+id).innerHTML = P3_Hour;
 document.getElementById("P3_Minute_val"+id).innerHTML = P3_Minute;
 document.getElementById("P6_Hour_val"+id).innerHTML = P6_Hour;
 document.getElementById("P6_Minute_val"+id).innerHTML = P6_Minute;


  document.getElementById("edit_button_time"+id).style.display="block";
  document.getElementById("save_button_time"+id).style.display="block";
  if(P2_Time <= 0) P2_Time = 1;
  if(P3_Week <= 0) P3_Week = 1;
  
 $.ajax
 ({
  type:'post',
  url:'modify_warehouse.php',
  data:{
  edit_row_time:'edit_row_time',  
   P2_Time:P2_Time,
   P3_Week:P3_Week,
   P3_Day:P3_Day,
   P3_Hour:P3_Hour, 
   P3_Minute:P3_Minute,
   P6_Hour:P6_Hour, 
   P6_Minute:P6_Minute,
  },
  success:function(response) {
   
  }
 });
}

function edit_row_noti(id,data,user,priority)
{
  document.getElementById("selectWH"+id).multiple = true;
  var value = data.split(",");
  for (var i = 0; i < value.length-1; i++) {
    document.getElementById("selectWH"+id).options.add(new Option(value[i], value[i]));
  }
  
  //document.getElementById("selectUG"+id).multiple = false;
  //var value1 = user.split(",");

  //for (var i = 0; i < value1.length-1; i++) {
  //  document.getElementById("selectUG"+id).options.add(new Option(value1[i], value1[i]));
  //} 
  
  document.getElementById("selectPR"+id).multiple = true;
  var value2 = priority.split(",");
  console.log(value2.length);
  for (var i = 0; i < value2.length; i++) {
    document.getElementById("selectPR"+id).options.add(new Option(value2[i], value2[i]));
  } 
  
  

 
  document.getElementById("edit_button_noti"+id).style.display="none";
  document.getElementById("save_button_noti"+id).style.display="block";
}
function save_row_noti(id,data,user,priority)
{
  
  document.getElementById("selectWH"+id).focus();
  document.getElementById("selectPR"+id).focus();
  //document.getElementById("selectUG"+id).multiple = false;
	//var WHName=document.getElementById("selectWH"+id).value;
  var value = data.split(",");
  var WHName_multi = [],opt;
    for (var i=0; i<value.length; i++) {
        opt = document.getElementById("selectWH"+id);
        var options = opt.options;
        
        // check if selected
        if ( options[i].selected == true ) {
            // add to array of option elements to return from this function
            console.log(options[i].text);
            WHName_multi.push(options[i].text);
        }
    }
    console.log(WHName_multi);
  for (var i = 0; i < value.length; i++) {
    document.getElementById("selectWH"+id).options.remove(value[i]);
  }
  document.getElementById("selectWH"+id).options.add(new Option(WHName_multi, WHName_multi));
 

  
  /*var value1 = user.split(",");
  var user_multi = [],opt1;
    for (var i=0; i<value1.length; i++) {
        opt1 = document.getElementById("selectUG"+id).options[i];
        // check if selected
        if ( opt1.selected ) {
            // add to array of option elements to return from this function
            user_multi.push(opt1.value);
        }
    }
    for (var i = 0; i < value1.length; i++) {
    document.getElementById("selectUG"+id).options.remove(value1[i]);
  }
  
  document.getElementById("selectUG"+id).options.add(new Option(user_multi, user_multi));*/

  
  var value2 = priority.split(",");
  var Priority_multi = [],opt2;
    for (var i=0; i<value2.length+1; i++) {
        opt2 = document.getElementById("selectPR"+id).options[i];
        // check if selected
        if ( opt2.selected ) {
            // add to array of option elements to return from this function
            Priority_multi.push(opt2.value);
        }
    }
    
    for (var i = document.getElementById("selectPR"+id).options.length-1; i>=0; i--) {
    document.getElementById("selectPR"+id).remove(i);
  }
  
  document.getElementById("selectPR"+id).options.add(new Option(Priority_multi, Priority_multi));
document.getElementById("selectWH"+id).multiple = false;
  document.getElementById("selectPR"+id).multiple = false;
  document.getElementById("edit_button_noti"+id).style.display="block";
  document.getElementById("save_button_noti"+id).style.display="block";
  console.log(Priority_multi.toString());
 $.ajax
 ({
  type:'post',
  url:'modify_warehouse.php',
  data:{
   //row_id:id,
   edit_row_noti:'edit_row_noti',  
   WHName_multi:WHName_multi.toString(),
   //user_multi:user_multi.toString(),
   Priority_multi:Priority_multi.toString(),
   id:id,
   
   
  },
  success:function(response) {
   
  }
 });
}
function delete_row_noti(id)
{
  
 $.ajax
 ({
  type:'post',
  url:'modify_warehouse.php',
  data:{
   delete_row_noti:'delete_row_noti',
   id:id,
  },
  success:function(response) {
   if(response=="success")
   {

    var row=document.getElementById("row"+id);
    row.parentNode.removeChild(row);
   }
  }
 });
}



function edit_row_camera(id,data)
{
  var value = data.split(",");
  for (var i = 0; i < value.length-1; i++) {
    document.getElementById("selectWH"+id).options.add(new Option(value[i], value[i]));
  }

  document.getElementById("Link_val"+id).contentEditable = "true";  

  document.getElementById("edit_button_camera"+id).style.display="none";
  document.getElementById("save_button_camera"+id).style.display="block";
}
function save_row_camera(id,data)
{
  document.getElementById("Link_val"+id).contentEditable = "false";  
  
  var value = data.split(",");
  var WHName_multi = [],opt;
    for (var i=0; i<value.length; i++) {
        opt = document.getElementById("selectWH"+id);
        var options = opt.options;
        
        // check if selected
        if ( options[i].selected == true ) {
            // add to array of option elements to return from this function
            console.log(options[i].text);
            WHName_multi.push(options[i].text);
        }
    }
    console.log(WHName_multi);
  for (var i = 0; i < value.length; i++) {
    document.getElementById("selectWH"+id).options.remove(value[i]);
  }
  document.getElementById("selectWH"+id).options.add(new Option(WHName_multi, WHName_multi));
 
  var Link = document.getElementById("Link_val"+id).innerHTML;
  document.getElementById("Link_val"+id).innerHTML = Link;
  
  
  document.getElementById("edit_button_camera"+id).style.display="block";
  document.getElementById("save_button_camera"+id).style.display="block";
  
 $.ajax
 ({
  type:'post',
  url:'modify_warehouse.php',
  data:{
   //row_id:id,
   edit_row_camera:'edit_row_camera',  
   WHName_multi:WHName_multi.toString(),
   Link:Link,
   id:id,
   
   
  },
  success:function(response) {
   
  }
 });
}
function delete_row_camera(id)
{
  
 $.ajax
 ({
  type:'post',
  url:'modify_warehouse.php',
  data:{
   delete_row_camera:'delete_row_camera',
   id:id,
  },
  success:function(response) {
   if(response=="success")
   {

    var row=document.getElementById("row"+id);
    row.parentNode.removeChild(row);
   }
  }
 });
}



function edit_row(id,timeZone)
{
 //var warehouseName=document.getElementById("warehouseName_val2"+id).innerHTML;
 var warehouseTitle=document.getElementById("warehouseTitle_val"+id).innerHTML;
 var UHV4=document.getElementById("UHV4_val"+id).innerHTML;
 var UHV2=document.getElementById("UHV2_val"+id).innerHTML;
 var SDCS=document.getElementById("SDCS_val"+id).innerHTML;
 //var stationNumber=document.getElementById("stationNumber"+id).innerHTML;
 //var MAC=document.getElementById("MAC"+id).innerHTML;
 document.getElementById("warehouseTitle_val"+id).style.maxWidth = "120px";
 document.getElementById("UHV4_val"+id).style.maxWidth = "70px";
 document.getElementById("UHV2_val"+id).style.maxWidth = "70px";
 document.getElementById("SDCS_val"+id).style.maxWidth = "70px";
 //document.getElementById("warehouseTitle_val"+id).innerHTML="<input type='text' style='max-width:80%' id='warehouseTitle_value"+id+"' value='"+warehouseTitle+"'>";
 document.getElementById("warehouseTitle_val"+id).contentEditable = "true";
 document.getElementById("UHV4_val"+id).contentEditable = "true";
 document.getElementById("UHV2_val"+id).contentEditable = "true";
 document.getElementById("SDCS_val"+id).contentEditable = "true";
 document.getElementById("latitude_val"+id).contentEditable = "true";
 document.getElementById("longitude_val"+id).contentEditable = "true";
 
  var value = timeZone.split(",");
  for (var i = 0; i < value.length-1; i++) {
    document.getElementById("timeZone"+id).options.add(new Option(value[i], value[i]));
  }

 //document.getElementById("warehouseName_val"+id).innerHTML="<input type='text' id='warehouseName_value"+id+"' value='"+warehouseName+"'>";
  
 document.getElementById("edit_button"+id).style.display="none";
 document.getElementById("save_button"+id).style.display="block";
}
function save_row(id,timeZone)
{
  document.getElementById("warehouseTitle_val"+id).contentEditable = "false";
  document.getElementById("UHV4_val"+id).contentEditable = "false";
  document.getElementById("UHV2_val"+id).contentEditable = "false";
  document.getElementById("SDCS_val"+id).contentEditable = "false";
  document.getElementById("latitude_val"+id).contentEditable = "false";
  document.getElementById("longitude_val"+id).contentEditable = "false";

  var warehouseName=document.getElementById("warehouseName_val2"+id).innerHTML;
  var warehouseTitle=document.getElementById("warehouseTitle_val"+id).innerHTML;
  var UHV4=document.getElementById("UHV4_val"+id).innerHTML;
  var UHV2=document.getElementById("UHV2_val"+id).innerHTML;
  var SDCS=document.getElementById("SDCS_val"+id).innerHTML;
  var latitude=document.getElementById("latitude_val"+id).innerHTML;
  var longitude=document.getElementById("longitude_val"+id).innerHTML;

  document.getElementById("edit_button"+id).style.display="block";
  document.getElementById("save_button"+id).style.display="block";

  document.getElementById("warehouseTitle_val"+id).innerHTML=warehouseTitle;
  document.getElementById("UHV4_val"+id).innerHTML=UHV4;
  document.getElementById("UHV2_val"+id).innerHTML=UHV2;
  document.getElementById("SDCS_val"+id).innerHTML=SDCS;
  document.getElementById("latitude_val"+id).innerHTML=latitude;
  document.getElementById("longitude_val"+id).innerHTML=longitude;
  var value = timeZone.split(",");
  var timeZ = [],opt;
    for (var i=0; i<value.length; i++) {
        opt = document.getElementById("timeZone"+id);
        var options = opt.options;
        
        // check if selected
        if ( options[i].selected == true ) {
            // add to array of option elements to return from this function
            console.log(options[i].text);
            timeZ.push(options[i].text);
        }
    }
    
  for (var i = 0; i < value.length; i++) {
    document.getElementById("timeZone"+id).options.remove(value[i]);
  }
  document.getElementById("timeZone"+id).options.add(new Option(timeZ, timeZ));
 $.ajax
 ({
  type:'post',
  url:'modify_warehouse.php',
  data:{
   //row_id:id,
   edit_row:'edit_row',  
   warehouseName:warehouseName,
   warehouseTitle:warehouseTitle,
   UHV4:UHV4,
   UHV2:UHV2,
   SDCS:SDCS,
   latitude:latitude,
   longitude:longitude,
   timeZ:timeZ.toString(),
   
  },
  success:function(response) {
   if(response=="success")
   {
    document.getElementById("warehouseName_val"+id).innerHTML=warehouseName;
    document.getElementById("warehouseTitle_val"+id).innerHTML=warehouseTitle;
    
   }
  }
 });
}
function delete_row(id)
{
  var warehouseName=document.getElementById("warehouseName_val2"+id).innerHTML;
 $.ajax
 ({
  type:'post',
  url:'modify_warehouse.php',
  data:{
   delete_row:'delete_row',
   row_id:id,
   warehouseName:warehouseName,
  },
  success:function(response) {
   if(response=="success")
   {

    var row=document.getElementById("row"+id);
    row.parentNode.removeChild(row);
   }
  }
 });
}





function edit_row_flipper(id,timeZone)
{

 document.getElementById("LowerThreshold_val"+id).contentEditable = "true";
 document.getElementById("UpperThreshold_val"+id).contentEditable = "true";
 
  var value = timeZone.split(",");
  for (var i = 0; i < value.length-1; i++) {
    document.getElementById("timeZone"+id).options.add(new Option(value[i], value[i]));
  }

 //document.getElementById("warehouseName_val"+id).innerHTML="<input type='text' id='warehouseName_value"+id+"' value='"+warehouseName+"'>";
  
 document.getElementById("edit_button_flipper"+id).style.display="none";
 document.getElementById("save_button_flipper"+id).style.display="block";
}
function save_row_flipper(id,timeZone)
{
  document.getElementById("LowerThreshold_val"+id).contentEditable = "false";
  document.getElementById("UpperThreshold_val"+id).contentEditable = "false";

  var LowerThreshold=document.getElementById("LowerThreshold_val"+id).innerHTML;
  var UpperThreshold=document.getElementById("UpperThreshold_val"+id).innerHTML;

  document.getElementById("edit_button_flipper"+id).style.display="block";
  document.getElementById("save_button_flipper"+id).style.display="block";

  
  document.getElementById("LowerThreshold_val"+id).innerHTML=LowerThreshold;
  document.getElementById("UpperThreshold_val"+id).innerHTML=UpperThreshold;
  var value = timeZone.split(",");
  var timeZ = [],opt;
    for (var i=0; i<value.length; i++) {
        opt = document.getElementById("timeZone"+id);
        var options = opt.options;
        
        // check if selected
        if ( options[i].selected == true ) {
            // add to array of option elements to return from this function
            console.log(options[i].text);
            timeZ.push(options[i].text);
        }
    }
    
  for (var i = 0; i < value.length; i++) {
    document.getElementById("timeZone"+id).options.remove(value[i]);
  }
  document.getElementById("timeZone"+id).options.add(new Option(timeZ, timeZ));
 $.ajax
 ({
  type:'post',
  url:'modify_warehouse.php',
  data:{
  
   edit_row_flipper:'edit_row_flipper',  
  id:id,
   LowerThreshold:LowerThreshold,
   UpperThreshold:UpperThreshold,
   timeZ:timeZ.toString(),
   
  },
  success:function(response) {
   if(response=="success")
   {
    
    
   }
  }
 });
}
function delete_row_flipper(id)
{
 
 $.ajax
 ({
  type:'post',
  url:'modify_warehouse.php',
  data:{
   delete_row_flipper:'delete_row_flipper',
   row_id:id,
   id:id,
  },
  success:function(response) {
   if(response=="success")
   {

    var row=document.getElementById("row"+id);
    row.parentNode.removeChild(row);
   }
  }
 });
}