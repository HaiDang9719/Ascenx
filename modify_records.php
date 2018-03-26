<?php
$host="localhost";
$username="klaremote";
$password="klaremote";
$databasename="dbtest";

$connect=mysql_connect($host,$username,$password);
$db=mysql_select_db($databasename);

if(isset($_POST['edit_row']))
{
 $row=$_POST['email_id'];
 $name=$_POST['email_name_val'];
 $address=$_POST['email_address_val'];

 mysql_query("update emailist set email_name='$name',email_address='$address' where email_id='$row'");
 echo "success";
 exit();
}

if(isset($_POST['delete_row']))
{
 $row_no=$_POST['row_id'];
 mysql_query("delete from emailist where email_id='$row_no'");
 echo "success";
 exit();
}

if(isset($_POST['insert_row']))
{
 $name=$_POST['email_name_val'];
 $address=$_POST['email_address_val'];
 mysql_query("insert into emailist (email_name, email_address) values ('$name','$address')");
 echo mysql_insert_id();
 exit();
}
?>