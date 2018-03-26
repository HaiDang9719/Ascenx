function editMultiRow(){
  var form = document.getElementById("edit_Multi_Row"),
    inputs = form.getElementsByTagName("input");

for (var i = 0, max = inputs.length; i < max; i += 1) {
   // Take only those inputs which are checkbox
   if (inputs[i].type === "checkbox" && inputs[i].checked) {
      edit_row("12");
   }
}
}

function edit_row_g(id)
{
 
 var sdcsAddr=document.getElementById("sdcsAddr_val_g"+id).innerHTML;
 var thresholdDownP=document.getElementById("thresholdDownP_val_g"+id).innerHTML;
 var thresholdUpP=document.getElementById("thresholdUpP_val_g"+id).innerHTML;



 document.getElementById("sdcsAddr_val_g"+id).style.maxWidth = "70px";
 document.getElementById("thresholdDownP_val_g"+id).style.maxWidth = "100px";
 document.getElementById("thresholdUpP_val_g"+id).style.maxWidth = "120px";

 
 document.getElementById("sdcsAddr_val_g"+id).contentEditable = "true";
 document.getElementById("thresholdDownP_val_g"+id).contentEditable = "true";
 document.getElementById("thresholdUpP_val_g"+id).contentEditable = "true";
 

 document.getElementById("edit_button_g"+id).style.display="none";
 document.getElementById("save_button_g"+id).style.display="block";
}
function save_row_g(id)
{

 document.getElementById("sdcsAddr_val_g"+id).contentEditable = "false";
 document.getElementById("thresholdDownP_val_g"+id).contentEditable = "false";
 document.getElementById("thresholdUpP_val_g"+id).contentEditable = "false";


 var sdcsAddr=document.getElementById("sdcsAddr_val_g"+id).innerHTML;
 var thresholdDownP=document.getElementById("thresholdDownP_val_g"+id).innerHTML;
 var thresholdUpP=document.getElementById("thresholdUpP_val_g"+id).innerHTML;
 
 
 document.getElementById("edit_button_g"+id).style.display="block";
 document.getElementById("save_button_g"+id).style.display="block";
 

 document.getElementById("sdcsAddr_val_g"+id).innerHTML=sdcsAddr;
 document.getElementById("thresholdDownP_val_g"+id).innerHTML=thresholdDownP;
 document.getElementById("thresholdUpP_val_g"+id).innerHTML=thresholdUpP;
 
 

 $.ajax
 ({
  type:'post',
  url:'modify_station.php',
  data:{
   //row_id:id,
   edit_row_g:'edit_row_g',
   id:id,  
   sdcsAddr:sdcsAddr,
   thresholdDownP:thresholdDownP,
   thresholdUpP:thresholdUpP,
  },
  success:function(response) {
  }
 });

}
function delete_row_g(id,warehouseName)
{
  var id=document.getElementById("id_val_g"+id).innerHTML;
 $.ajax
 ({
  type:'post',
  url:'modify_station.php',
  data:{
   delete_row_g:'delete_row_g',
   row_id:id,
   warehouseName:warehouseName
  },
  success:function(response) {
   if(response=="success")
   {

    var row=document.getElementById("row_val_g"+id);
    row.parentNode.removeChild(row);
   }
  }
 });
}
function edit_row(id)
{
 var stationName=document.getElementById("stationName_val"+id).innerHTML;
 
 var pumpType=document.getElementById("pumpType_val"+id).innerHTML;
 var pumpAddr=document.getElementById("pumpAddr_val"+id).innerHTML;
 var pumpCH=document.getElementById("pumpCH_val"+id).innerHTML;
 var sdcsAddr=document.getElementById("sdcsAddr_val"+id).innerHTML;
 var sdcsCH=document.getElementById("sdcsCH_val"+id).innerHTML;
 var thresholdDownP=document.getElementById("thresholdDownP_val"+id).innerHTML;
 var thresholdUpP=document.getElementById("thresholdUpP_val"+id).innerHTML;
 var thresholdUpI=document.getElementById("thresholdUpI_val"+id).innerHTML;
 var thresholdDownI=document.getElementById("thresholdDownI_val"+id).innerHTML;
 
 //var warehouseName=document.getElementById("warehouseName_val"+id).innerHTML;
 var Time=document.getElementById("Time_val"+id).innerHTML;
 //var warehouseMAC=document.getElementById("warehouseMAC_val"+id).innerHTML;

 document.getElementById("stationName_val"+id).style.maxWidth = "100px";
 
 document.getElementById("pumpType_val"+id).style.maxWidth = "70px";
 document.getElementById("pumpAddr_val"+id).style.maxWidth = "70px";
 document.getElementById("pumpCH_val"+id).style.maxWidth = "70px";
 document.getElementById("sdcsAddr_val"+id).style.maxWidth = "70px";
 document.getElementById("sdcsCH_val"+id).style.maxWidth = "70px";
 document.getElementById("thresholdDownP_val"+id).style.maxWidth = "100px";
 document.getElementById("thresholdUpP_val"+id).style.maxWidth = "120px";
 document.getElementById("thresholdUpI_val"+id).style.maxWidth = "120px";
 document.getElementById("thresholdDownI_val"+id).style.maxWidth = "120px";
 document.getElementById("RFID_val"+id).style.maxWidth = "120px";

 document.getElementById("stationName_val"+id).contentEditable = "true";
 
 document.getElementById("pumpType_val"+id).contentEditable = "true";
 document.getElementById("pumpAddr_val"+id).contentEditable = "true";
 document.getElementById("pumpCH_val"+id).contentEditable = "true";
 document.getElementById("sdcsAddr_val"+id).contentEditable = "true";
 document.getElementById("sdcsCH_val"+id).contentEditable = "true";
 document.getElementById("thresholdDownP_val"+id).contentEditable = "true";
 document.getElementById("thresholdUpP_val"+id).contentEditable = "true";
 document.getElementById("thresholdUpI_val"+id).contentEditable = "true";
 document.getElementById("thresholdDownI_val"+id).contentEditable = "true";
 
 //document.getElementById("warehouseName_val"+id).innerHTML="<input type='text' id='warehouseName_value"+id+"' value='"+warehouseName+"'>";
 //document.getElementById("Time_val"+id).innerHTML="<input type='text' id='Time_value"+id+"' value='"+Time+"'>";
 //document.getElementById("warehouseMAC_val"+id).innerHTML="<input type='text' id='warehouseMAC_value"+id+"' value='"+warehouseMAC+"'>";

 document.getElementById("edit_button"+id).style.display="none";
 document.getElementById("save_button"+id).style.display="block";
}
function save_row(id)
{

 document.getElementById("stationName_val"+id).contentEditable = "false";
 document.getElementById("pumpType_val"+id).contentEditable = "false";
 document.getElementById("pumpAddr_val"+id).contentEditable = "false";
 document.getElementById("pumpCH_val"+id).contentEditable = "false";
 document.getElementById("sdcsAddr_val"+id).contentEditable = "false";
 document.getElementById("sdcsCH_val"+id).contentEditable = "false";
 document.getElementById("thresholdDownP_val"+id).contentEditable = "false";
 document.getElementById("thresholdUpP_val"+id).contentEditable = "false";
 document.getElementById("thresholdUpI_val"+id).contentEditable = "false";
 document.getElementById("thresholdDownI_val"+id).contentEditable = "false";

 var stationName=document.getElementById("stationName_val"+id).innerHTML;
 var pumpType=document.getElementById("pumpType_val"+id).innerHTML;
 var pumpAddr=document.getElementById("pumpAddr_val"+id).innerHTML;
 var pumpCH=document.getElementById("pumpCH_val"+id).innerHTML;
 var sdcsAddr=document.getElementById("sdcsAddr_val"+id).innerHTML;
 var sdcsCH=document.getElementById("sdcsCH_val"+id).innerHTML;
 var thresholdDownP=document.getElementById("thresholdDownP_val"+id).innerHTML
 var thresholdUpP=document.getElementById("thresholdUpP_val"+id).innerHTML
 var thresholdUpI=document.getElementById("thresholdUpI_val"+id).innerHTML
 var thresholdDownI=document.getElementById("thresholdDownI_val"+id).innerHTML
 
 //var warehouseName=document.getElementById("warehouseName_val"+id).innerHTML;
 //var Time=document.getElementById("Time_value"+id).value;
 //var warehouseMAC=document.getElementById("warehouseMAC_val"+id).innerHTML;

 document.getElementById("edit_button"+id).style.display="block";
 document.getElementById("save_button"+id).style.display="block";
 
 document.getElementById("stationName_val"+id).innerHTML=stationName;
 document.getElementById("pumpType_val"+id).innerHTML=pumpType;
 document.getElementById("pumpAddr_val"+id).innerHTML=pumpAddr;
 document.getElementById("pumpCH_val"+id).innerHTML=pumpCH;
 document.getElementById("sdcsAddr_val"+id).innerHTML=sdcsAddr;
 document.getElementById("sdcsCH_val"+id).innerHTML=sdcsCH;
 document.getElementById("thresholdDownP_val"+id).innerHTML=thresholdDownP;
 document.getElementById("thresholdUpP_val"+id).innerHTML=thresholdUpP;
 document.getElementById("thresholdUpI_val"+id).innerHTML=thresholdUpI;
 document.getElementById("thresholdDownI_val"+id).innerHTML=thresholdDownI;
 
 //document.getElementById("Time_val"+id).innerHTML=Time;
 $.ajax
 ({
  type:'post',
  url:'modify_station.php',
  data:{
   //row_id:id,
   edit_row:'edit_row',
   id:id,  
   stationName:stationName,
   
   pumpType:pumpType,
   pumpAddr:pumpAddr,
   pumpCH:pumpCH,
   sdcsAddr:sdcsAddr,
   sdcsCH:sdcsCH,
   thresholdDownP:thresholdDownP,
   thresholdUpP:thresholdUpP,
   thresholdUpI:thresholdUpI,
   thresholdDownI:thresholdDownI,
   
   
  },
  success:function(response) {
  
  }
 });

}
function delete_row(id,warehouseName)
{
  var id=document.getElementById("id_val"+id).innerHTML;
 $.ajax
 ({
  type:'post',
  url:'modify_station.php',
  data:{
   delete_row:'delete_row',
   row_id:id,
   warehouseName:warehouseName
  },
  success:function(response) {
   if(response=="success")
   {

    var row=document.getElementById("row_val"+id);
    row.parentNode.removeChild(row);
   }
  }
 });
}
function button_control_HV(RFID)
{

  var change = document.getElementById("button_control_HV");
                if (change.innerHTML == "HV On")
                {
                    change.innerHTML = "HV Off";
                    change.classList.remove('btn-success');
                    change.classList.add('btn-warning');
                    var value = "1";

                    $.ajax
                     ({
                        type:'post',
                        url:'modify_station.php',
                        data:{
                                button_control_HV:'button_control_HV',
                                RFID:RFID,
                                value:value,
                              },
                        success:function(response) { 
                        }
                     });  
                }
                else {
                    change.innerHTML = "HV On";
                    change.classList.remove('btn-warning');
                    change.classList.add('btn-success');
                    var value = "0";

                    $.ajax
                     ({
                        type:'post',
                        url:'modify_station.php',
                        data:{
                                button_control_HV:'button_control_HV',
                                RFID:RFID,
                                value:value,
                              },
                        success:function(response) { 
                        }
                     });  
                    
                }
                
}
function button_control_Pr(RFID)
{
  var change = document.getElementById("button_control_Pr");
                if (change.innerHTML == "Protect On")
                {
                    change.innerHTML = "Protect Off";
                    change.classList.remove('btn-success');
                    change.classList.add('btn-warning');
                    var value = "1";

                    $.ajax
                     ({
                        type:'post',
                        url:'modify_station.php',
                        data:{
                                button_control_Pr:'button_control_Pr',
                                RFID:RFID,
                                value:value,
                              },
                        success:function(response) { 
                        }
                     });  
                }
                else {
                    change.innerHTML = "Protect On";
                    change.classList.remove('btn-warning');
                    change.classList.add('btn-success');
                    var value = "0";

                    $.ajax
                     ({
                        type:'post',
                        url:'modify_station.php',
                        data:{
                                button_control_Pr:'button_control_Pr',
                                RFID:RFID,
                                value:value,
                              },
                        success:function(response) { 
                        }
                     });  
                }
}
function button_control_S(RFID)
{
  var change = document.getElementById("button_control_S");
                if (change.innerHTML == "Station On")
                {
                    change.innerHTML = "Station Off";
                    change.classList.remove('btn-success');
                    change.classList.add('btn-warning');
                    var value = "1";

                    $.ajax
                     ({
                        type:'post',
                        url:'modify_station.php',
                        data:{
                                button_control_S:'button_control_S',
                                RFID:RFID,
                                value:value,
                              },
                        success:function(response) { 
                        }
                     });  
                }
                else {
                    change.innerHTML = "Station On";
                    change.classList.remove('btn-warning');
                    change.classList.add('btn-success');
                    var value = "0";

                    $.ajax
                     ({
                        type:'post',
                        url:'modify_station.php',
                        data:{
                                button_control_S:'button_control_S',
                                RFID:RFID,
                                value:value,
                              },
                        success:function(response) { 
                        }
                     });  
                }
}
function edit_row_station(){
  var PN=document.getElementById("PN_val").innerHTML;
 
 var Serial=document.getElementById("Serial_val").innerHTML;
 var LPN=document.getElementById("LPN_val").innerHTML;
 var TestDate=document.getElementById("TestDate_val").innerHTML;
 var MFGPressure=document.getElementById("MFGPressure_val").innerHTML;
 var PO=document.getElementById("PO_val").innerHTML;
 var DateInStock=document.getElementById("DateInStock_val").innerHTML;
 var DateShipped=document.getElementById("DateShipped_val").innerHTML;
 

 document.getElementById("PN_val").style.maxWidth = "100px";
 document.getElementById("Serial_val").style.maxWidth = "100px";
 document.getElementById("LPN_val").style.maxWidth = "100px";
 document.getElementById("TestDate_val").style.maxWidth = "100px";
 document.getElementById("MFGPressure_val").style.maxWidth = "100px";
 document.getElementById("PO_val").style.maxWidth = "100px";
 document.getElementById("DateInStock_val").style.maxWidth = "100px";
 document.getElementById("DateShipped_val").style.maxWidth = "100px";
 

 document.getElementById("PN_val").innerHTML="<input type='text' style='max-width:95%' id='PN_value' value='"+PN+"'>";
 document.getElementById("Serial_val").innerHTML="<input type='text' style='max-width:95%' id='Serial_value' value='"+Serial+"'>";
 document.getElementById("LPN_val").innerHTML="<input type='text' style='max-width:95%' id='LPN_value' value='"+LPN+"'>";
 document.getElementById("TestDate_val").innerHTML="<input type='text' style='max-width:95%' id='TestDate_value' value='"+TestDate+"'>";
 document.getElementById("MFGPressure_val").innerHTML="<input type='text' style='max-width:95%' id='MFGPressure_value' value='"+MFGPressure+"'>";
 document.getElementById("PO_val").innerHTML="<input type='text' style='max-width:95%' id='PO_value' value='"+PO+"'>";
 document.getElementById("DateInStock_val").innerHTML="<input type='text' style='max-width:95%' id='DateInStock_value' value='"+DateInStock+"'>";
 document.getElementById("DateShipped_val").innerHTML="<input type='text' style='max-width:95%' id='DateShipped_value' value='"+DateShipped+"'>";
 

 document.getElementById("edit_button_station").style.display="none";

}


function save_row_station(RFID){
 var PN=document.getElementById("PN_value").value;
 var Serial=document.getElementById("Serial_value").value;
 var LPN=document.getElementById("LPN_value").value;
 var TestDate=document.getElementById("TestDate_value").value;
 var MFGPressure=document.getElementById("MFGPressure_value").value;
 var PO=document.getElementById("PO_value").value;
 var DateInStock=document.getElementById("DateInStock_value").value;
 var DateShipped=document.getElementById("DateShipped_value").value;
 

 document.getElementById("edit_button_station").style.display="initial";
 document.getElementById("save_button_station").style.display="initial";


 document.getElementById("PN_val").innerHTML=PN;
 document.getElementById("Serial_val").innerHTML=Serial;
 document.getElementById("LPN_val").innerHTML=LPN;
 document.getElementById("TestDate_val").innerHTML=TestDate;
 document.getElementById("MFGPressure_val").innerHTML=MFGPressure;
 document.getElementById("PO_val").innerHTML=PO;
 document.getElementById("DateInStock_val").innerHTML=DateInStock;
 document.getElementById("DateShipped_val").innerHTML=DateShipped;
 

 $.ajax
 ({
  type:'post',
  url:'modify_station.php',
  data:{
   edit_row_station:'edit_row_station',
   RFID:RFID,  
   PN:PN,
   Serial:Serial,
   LPN:LPN,
   TestDate:TestDate,
   MFGPressure:MFGPressure,
   PO:PO,
   DateInStock:DateInStock,
   DateShipped:DateShipped,
   
   
  },
  success:function(response) {
   
  }
 });

}