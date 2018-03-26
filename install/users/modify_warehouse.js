
function edit_row(id)
{
 //var warehouseName=document.getElementById("warehouseName_val2"+id).innerHTML;
 var warehouseTitle=document.getElementById("warehouseTitle_val"+id).innerHTML;
 var UHV4=document.getElementById("UHV4_val"+id).innerHTML;
 var UHV2=document.getElementById("UHV2_val"+id).innerHTML;
 var SDCS=document.getElementById("SDCS_val"+id).innerHTML;
 //var stationNumber=document.getElementById("stationNumber"+id).innerHTML;
 //var MAC=document.getElementById("MAC"+id).innerHTML;
 document.getElementById("warehouseTitle_val"+id).style.maxWidth = "100px";
 document.getElementById("UHV4_val"+id).style.maxWidth = "70px";
 document.getElementById("UHV2_val"+id).style.maxWidth = "70px";
 document.getElementById("SDCS_val"+id).style.maxWidth = "70px";
 document.getElementById("warehouseTitle_val"+id).innerHTML="<input type='text' style='max-width:80%' id='warehouseTitle_value"+id+"' value='"+warehouseTitle+"'>";
 document.getElementById("UHV4_val"+id).innerHTML="<input type='text' style='max-width:80%' id='UHV4_value"+id+"' value='"+UHV4+"'>";
 document.getElementById("UHV2_val"+id).innerHTML="<input type='text' style='max-width:80%' id='UHV2_value"+id+"' value='"+UHV2+"'>";
 document.getElementById("SDCS_val"+id).innerHTML="<input type='text' style='max-width:80%' id='SDCS_value"+id+"' value='"+SDCS+"'>";
 //document.getElementById("warehouseName_val"+id).innerHTML="<input type='text' id='warehouseName_value"+id+"' value='"+warehouseName+"'>";
	
 document.getElementById("edit_button"+id).style.display="none";
 document.getElementById("save_button"+id).style.display="block";
}
function save_row(id)
{
	var warehouseName=document.getElementById("warehouseName_val2"+id).innerHTML;
  var warehouseTitle=document.getElementById("warehouseTitle_value"+id).value;
  var UHV4=document.getElementById("UHV4_value"+id).value;
  var UHV2=document.getElementById("UHV2_value"+id).value;
  var SDCS=document.getElementById("SDCS_value"+id).value;
  document.getElementById("edit_button"+id).style.display="block";
    document.getElementById("save_button"+id).style.display="block";
    document.getElementById("warehouseTitle_val"+id).innerHTML=warehouseTitle;
    document.getElementById("UHV4_val"+id).innerHTML=UHV4;
    document.getElementById("UHV2_val"+id).innerHTML=UHV2;
    document.getElementById("SDCS_val"+id).innerHTML=SDCS;
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