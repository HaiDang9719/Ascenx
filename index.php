<?php 
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}



Redirect::to($us_url_root.'map.php');
?>

       <!-- <p id="sitetitle" style="text-align: center; color:  #0e6889"><strong style="font-size: 200%">Flipper CH1</strong></p> -->
 
         
  </style>



<div id="page-wrapper">
<div class="container">
</div> <!-- /container -->
</div> <!-- /#page-wrapper -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
