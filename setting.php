<?php 
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';

if (!securePage($_SERVER['PHP_SELF'])){die();}

	unset($succMSG);
    unset($errMSG);
    if($_POST['IP'] != "")
    {

        if (filter_var($_POST['IP'], FILTER_VALIDATE_IP) === false)
        {
            $errMSG = "Invalid ip address , Try again...";
        }
        else
        {

        unset($errMSG);
                $path = "/var/www/html/config.csv";

     $output = fopen("$path", "w"); 
     array_push($_POST , '1');
     fputcsv($output, $_POST);
     fclose($output);
     header("Location: setting.php?saved");
        }
    }
    //global Config array
    $config = array();
    // load settings from config.csv
    if (($handle = fopen("../config.csv", "r")) !== FALSE) 
    {
        if(($config  = fgetcsv($handle, 1000, ",")) === FALSE)
        {
            
        }

    }
    if (isset($_GET['saved']))
    {
        $succMSG = "Saved";
    }
    else
    {
        unset($succMSG);
    }

?>


<div id="page-wrapper">
<div class="container">
<div class="page-header">
            <h1>Settings</h1>
            </div>

            <div>
             <?php
                if ( isset($errMSG) ) {
                    
                    ?>
                    <div class="form-group">
                    <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                    </div>
                    </div>
                    <?php
                }
                 if ( isset($succMSG) ) {
                    
                    ?>
                    <div class="form-group">
                    <div class="alert alert-success">
                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $succMSG; ?>
                    </div>
                    </div>
                    <?php
                }
                ?>
            <form action="setting.php" method="post">
            <h4>Warehouse Name</h4>
            Name: <input type="tex" name="WHName" value="<?php echo $config[0]; ?>">
            <h4>Raspberry addressed:</h4>
            Local IP  : <input  type="text" name="localIP" value="<?php echo $config[1]; ?>" style="width: 20%; margin-left: auto; margin-right: auto;"><br><br>
            Public IP: <input  type="text" name="publicIp" value="<?php echo $config[2];?>" style="width: 20%; margin-left: auto; margin-right: auto;"><br><br>
            <h4>Flipper Address</h4>
            IP  : <input type="text" name="IP" value="<?php echo $config[3]; ?>" style="width: 20%; margin-left: auto; margin-right: auto;"><br><br>
            Port: <input type="text" name="Port" value="<?php echo $config[4];?>" style="width: 20%; margin-left: auto; margin-right: auto;"><br><br>
            <h4>Channel Specifications</h4>
            CH1 (Celcius): <input type="text" name="CH1" value="<?php echo $config[5];?>" style="width: 20%; margin-left: auto; margin-right: auto;"><br><br>
            CH2 (Celcius): <input type="text" name="CH2" value="<?php echo $config[6];?>" style="width: 20%; margin-left: auto; margin-right: auto;"><br><br>
            CH3 (Celcius): <input type="text" name="CH3" value="<?php echo $config[7];?>" style="width: 20%; margin-left: auto; margin-right: auto;"><br><br>
            <h4>Send Status Notification</h4>
            E-mail: <input type="hidden" value='0' name="StatusEmail"><input type="checkbox" value='1' <?php echo ($config[8]==1 ? 'checked' : '');?> name="StatusEmail"> <tab>
            Mobile: <input type="hidden" value='0' name="StatusMobile"><input type="checkbox" value='1' <?php echo ($config[9]==1 ? 'checked' : '');?> name="StatusMobile"> <br><br>
            <h4>Send Alert Notification</h4>
            E-mail: <input type="hidden" value='0' name="AlertEmail"><input type="checkbox" value='1' <?php echo ($config[10]==1 ? 'checked' : '');?> name="AlertEmail"><tab>
            Mobile: <input type="hidden" value='0' name="AlertMobile"><input type="checkbox" value='1' <?php echo ($config[11]==1 ? 'checked' : '');?> name="AlertMobile"><br><br>
            <h4>Channel Open </h4>
            CH1: <input type="hidden" value='0' name="EnableCH1"><input type="checkbox" value='1' <?php echo ($config[12]==1 ? 'checked' : '');?> name="EnableCH1"><tab>
            CH2: <input type="hidden" value='0' name="EnableCH2"><input type="checkbox" value='1' <?php echo ($config[13]==1 ? 'checked' : '');?> name="EnableCH2"><tab>
            CH3: <input type="hidden" value='0' name="EnableCH3"><input type="checkbox" value='1' <?php echo ($config[14]==1 ? 'checked' : '');?> name="EnableCH3"><br><br><br>
           
            <h4>Send notification at this time everyday:</h4>
            <h6>(This feature depends on server local time)</h6>
            Hour<input type="number" name="hour" min="0" max="24" value="<?php echo $config[15]; ?>"><tab><tab>
            Min<input type="number" name="minute" min="0" max="60" value="<?php echo $config[16]; ?>"><tab><tab>
            Sec<input type="number" name="second" min="0" max="60" value="<?php echo $config[17]; ?>"><br><br><br>
            <br>
            Decimal Points <input type="number" name="DecimalPoint" min="0" max="100000" value="<?php echo $config[18]; ?>"><br><br><br>
            <input type="submit" style="width: 20%; margin-left: auto; margin-right: auto;">
                <br><br><br>
            </div>
</div>
</div>
<!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->


<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?> 
