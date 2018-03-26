<?php 
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

	require_once '../dbconnect.php';
	$db = mysql_select_db("flipper");

    // select loggedin users detail
    $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
    $userRow=mysql_fetch_array($res);

    $host="localhost";
$username="klaremote";
$password="klaremote";
$databasename="dbtest";
$connect=mysql_connect($host,$username,$password);
$db=mysql_select_db($databasename);

$select =mysql_query("SELECT * FROM emailist");

?>
       <!-- <p id="sitetitle" style="text-align: center; color:  #0e6889"><strong style="font-size: 200%">Flipper CH1</strong></p> -->
<style type='text/css'>
table {
    table-layout: auto;
    border-collapse: collapse;
    width: 100%;
}
table td {
    border: 1px solid #ccc;
}
table .absorbing-column {
    width: 100%;
}
input {
  width:100px;
  right: 2%;
  }
  </style>
}
<div id="page-wrapper">
<div class="container">

        <div class="row">
       
            <table align="center" cellpadding="10" border="5" id="user_table">
            <tr>
            <th>NAME</th>
            <th>ADDRESS</th>
            <th></th>
            </tr>
            <?php
            while ($row=mysql_fetch_array($select)) 
            {
             ?>
             <tr id="row<?php echo $row['email_id'];?>">
              <td id="email_name_val<?php echo $row['email_id'];?>"><?php echo $row['email_name'];?></td>
              <td id="email_address_val<?php echo $row['email_id'];?>"><?php echo $row['email_address'];?></td>
              <td>
               <input type='button' class="edit_button" id="edit_button<?php echo $row['email_id'];?>" value="edit" onclick="edit_row('<?php echo $row['email_id'];?>');">
               <input type='button' class="save_button" id="save_button<?php echo $row['email_id'];?>" value="save" onclick="save_row('<?php echo $row['email_id'];?>');">
               <input type='button' class="delete_button" id="delete_button<?php echo $row['email_id'];?>" value="delete" onclick="delete_row('<?php echo $row['email_id'];?>');">
              </td>
             </tr>
             <?php
            }
            ?>

            <tr id="new_row">
             <td><input type="text" id="new_email_name"></td>
             <td><input type="text" id="new_email_address"></td>
             <td><input type="button" value="Insert Row" onclick="insert_row();"></td>
            </tr>
            </table>
            <br><br><br>
        
        </div>	
</div> <!-- /container -->

</div> <!-- /#page-wrapper -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="modify_records.js"></script>
<!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->


<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
