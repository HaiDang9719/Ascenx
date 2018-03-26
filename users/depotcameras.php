<?php
/*
UserSpice 4
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/navigation.php'; ?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<?php
//PHP Goes Here!
$errors = $successes = [];
$form_valid=TRUE;
$WHName = $_REQUEST['WHName'];
// dnd($permOps);
$queryCamera = $db->query("SELECT * FROM cameraSetting WHERE Location = ?", array($WHName));
$resultCamera = $queryCamera->results();
if(!empty($_POST))
{
 }
?>

<!-- <style type="text/css">
	#camera1{
		width: 500px;
		height: 300px;
	}
	#camera2{
		width: 500px;
		height: 300px;
	}
</style> -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<div id="page-wrapper">
  <div class="container">
<div class="row">
	<div class="col-md-12">
		<h1>Camera in <?php echo $WHName;?> Depot</h1>	
	</div>
	<?php 
	
	foreach ($resultCamera as $key) {
		$url = $key->Link."/cam_pic_new.php?";
	
	?>
	<div class="col-md-6 col-xs-12 " id="camera1">
			<div onclick="window.open('<?=$key->Link?>','mywindow');" style="cursor: pointer;"><img src="<?=$url?>"></div>
		</div>
	<?php }?>
		
		
</div>
  </div>
</div>


	<!-- End of main content section -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

    <!-- Place any per-page javascript here -->
<script src="js/search.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="modify_warehouse.js"></script>
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
