<?php

use yii\helpers\Html;

?>
<html>

<body style="background-color:#ecedf1;  align-items: center; height: auto; min-height: 500px; margin: 10px; padding:10px;">

    <center>
        <div style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  padding: 20px; text-align: center; width: 400px; background-color: white; margin:20px; margin-top:30px;">
            <h2 style="text-align: center; font-size:25px;  font-family: Arial, sans-serif;">New Request For Approval </h2>
            <div style="border-radius: 15px; margin-top:20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: 0.3s; text-align: center; padding: 10px; background-color:#ecedf1;">
                <p style="font-family: Arial, sans-serif;"> You recieved a new request to approve  <h4><?= $title && isset($title) ? $title : ''  ?></h4> from </p>
                <h4><p style="margin-bottom: 20px;"><?= $operator_name && isset($operator_name) ? $operator_name : '' ?></p></h4>
                <br>
                Please check your inbox to review the details and respond promptly. </p>
            </div>
            <footer style="margin-top: 80px; margin-bottom:0px;font-size: 12px; color: #888;">
                <p>Walk Into the Wild</p>
            </footer>
        </div>
    </center>
</body>

</html>