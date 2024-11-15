<?php

use yii\helpers\Html;

?>


<html>

<body style="background-color:#ecedf1;  align-items: center; height: auto; min-height: 500px; margin: 10px; padding:10px;">

<center>

    <div style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  padding: 20px; text-align: center; width: 400px; background-color: white; margin:20px; margin-top:30px;">
        <h2 style="text-align: center; font-size:25px;  font-family: Arial, sans-serif;">New Reply</h2>
        <div style="border-radius: 15px; margin-top:20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: 0.3s; text-align: center; padding: 10px; background-color:#ecedf1;">
            <p style="font-family: Arial, sans-serif;"> 
            There's a new reply on your package <?= $package && isset($package['package_name']) ? $package['package_name'] : '' ?> . Check the latest reply to respond and finalize your package plans.
           </p>
        </div>
        <a href="<?= $package_url && isset($package_url) ? $package_url : '' ?>"
            style="display: inline-block; background-color: #09422d; color: white; font-weight: 500; font-size: 16px; padding: 8px 25px; border-radius: 20px; text-decoration: none; margin-top: 80px;">
            View Reply
        </a>
        <footer style="margin-top: 80px; margin-bottom:0px;font-size: 12px; color: #888;">
            <p>Walk Into the Wild</p>
        </footer>
    </div>
</center>
</body>

</html>