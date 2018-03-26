function edit_row(id)
{
 var email_name=document.getElementById("email_name_val"+id).innerHTML;
 var email_address=document.getElementById("email_address_val"+id).innerHTML;

 document.getElementById("email_name_val"+id).innerHTML="<input type='text' id='emailName"+id+"' value='"+email_name+"'>";
 document.getElementById("email_address_val"+id).innerHTML="<input type='text' id='emailAddress"+id+"' value='"+email_address+"'>";
	
 document.getElementById("edit_button"+id).style.display="none";
 document.getElementById("save_button"+id).style.display="block";
}

function save_row(id)
{
 var emailName=document.getElementById("emailName"+id).value;
 var emailAddress=document.getElementById("emailAddress"+id).value;
	
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   edit_row:'edit_row',
   email_id:id,
   email_name_val:emailName,
   email_address_val:emailAddress
  },
  success:function(response) {
   if(response=="success")
   {
    document.getElementById("email_name_val"+id).innerHTML=emailName;
    document.getElementById("email_address_val"+id).innerHTML=emailAddress;
    document.getElementById("edit_button"+id).style.display="block";
    document.getElementById("save_button"+id).style.display="none";
   }
  }
 });
}

function delete_row(id)
{
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   delete_row:'delete_row',
   row_id:id,
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

function insert_row()
{
 var emailname=document.getElementById("new_email_name").value;
 var emailaddress=document.getElementById("new_email_address").value;

 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   insert_row:'insert_row',
   email_name_val:emailname,
   email_address_val:emailaddress
  },
  success:function(response) {
   if(response!="")
   {
    var id=response;
    var table=document.getElementById("user_table");
    var table_len=(table.rows.length)-1;
    var row = table.insertRow(table_len).outerHTML="<tr id='row"+id+"'><td id='email_name_val"+id+"'>"+emailname+"</td><td id='email_address_val"+id+"'>"+emailaddress+"</td><td><input type='button' class='edit_button' id='edit_button"+id+"' value='edit' onclick='edit_row("+id+");'/><input type='button' class='save_button' id='save_button"+id+"' value='save' onclick='save_row("+id+");'/><input type='button' class='delete_button' id='delete_button"+id+"' value='delete' onclick='delete_row("+id+");'/></td></tr>";

    document.getElementById("new_email_name").value="";
    document.getElementById("new_email_address").value="";
   }
  }
 });
}