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

 document.getElementById("stationName_val"+id).innerHTML="<input type='text' style='max-width:95%' id='stationName_value"+id+"' value='"+stationName+"'>";
 
 document.getElementById("pumpType_val"+id).innerHTML="<input type='text' style='max-width:80%' id='pumpType_value"+id+"' value='"+pumpType+"'>";
 document.getElementById("pumpAddr_val"+id).innerHTML="<input type='text' style='max-width:80%' id='pumpAddr_value"+id+"' value='"+pumpAddr+"'>";
 document.getElementById("pumpCH_val"+id).innerHTML="<input type='text' style='max-width:80%' id='pumpCH_value"+id+"' value='"+pumpCH+"'>";
 document.getElementById("sdcsAddr_val"+id).innerHTML="<input type='text' style='max-width:80%' id='sdcsAddr_value"+id+"' value='"+sdcsAddr+"'>";
 document.getElementById("sdcsCH_val"+id).innerHTML="<input type='text' style='max-width:80%' id='sdcsCH_value"+id+"' value='"+sdcsCH+"'>";
 document.getElementById("thresholdDownP_val"+id).innerHTML="<input type='text' style='max-width:95%' id='thresholdDownP_value"+id+"' value='"+thresholdDownP+"'>";
 document.getElementById("thresholdUpP_val"+id).innerHTML="<input type='text' style='max-width:95%' id='thresholdUpP_value"+id+"' value='"+thresholdUpP+"'>";
 document.getElementById("thresholdUpI_val"+id).innerHTML="<input type='text' style='max-width:95%' id='thresholdUpI_value"+id+"' value='"+thresholdUpI+"'>";
 document.getElementById("thresholdDownI_val"+id).innerHTML="<input type='text' style='max-width:95%' id='thresholdDownI_value"+id+"' value='"+thresholdDownI+"'>";
 
 //document.getElementById("warehouseName_val"+id).innerHTML="<input type='text' id='warehouseName_value"+id+"' value='"+warehouseName+"'>";
 //document.getElementById("Time_val"+id).innerHTML="<input type='text' id='Time_value"+id+"' value='"+Time+"'>";
 //document.getElementById("warehouseMAC_val"+id).innerHTML="<input type='text' id='warehouseMAC_value"+id+"' value='"+warehouseMAC+"'>";

 document.getElementById("edit_button"+id).style.display="none";
 document.getElementById("save_button"+id).style.display="block";
}
function save_row(id)
{
	//var warehouseName=document.getElementById("warehouseName_val2"+id).innerHTML;
  	//var warehouseTitle=document.getElementById("warehouseTitle_value"+id).value;
    var stationName=document.getElementById("stationName_value"+id).value;
 
 var pumpType=document.getElementById("pumpType_value"+id).value;
 var pumpAddr=document.getElementById("pumpAddr_value"+id).value;
 var pumpCH=document.getElementById("pumpCH_value"+id).value;
 var sdcsAddr=document.getElementById("sdcsAddr_value"+id).value;
 var sdcsCH=document.getElementById("sdcsCH_value"+id).value;
 var thresholdDownP=document.getElementById("thresholdDownP_value"+id).value;
 var thresholdUpP=document.getElementById("thresholdUpP_value"+id).value;
 var thresholdUpI=document.getElementById("thresholdUpI_value"+id).value;
 var thresholdDownI=document.getElementById("thresholdDownI_value"+id).value;
 
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
  var id=document.getElementById("id_val"+id).innerHTML;
 $.ajax
 ({
  type:'post',
  url:'modify_station.php',
  data:{
   delete_row:'delete_row',
   row_id:id,
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