<?php

use yii\helpers\Html;

$remainingMinutes = 0;
$remainingSeconds = 0;
$expiryMessage = 'expired';

if (!empty($exp_datetime)) {
    $now = new \DateTime();
    $expiry = new \DateTime($exp_datetime);

    if ($expiry > $now) {
        $interval = $now->diff($expiry);
        $minutes = $interval->i;
        $seconds = $interval->s;

        // Total duration message
        if ($interval->h > 0) {
            $expiryMessage = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '');
            if ($minutes > 0) {
                $expiryMessage .= ' ' . $minutes . ' minute' . ($minutes > 1 ? 's' : '');
            }
        } elseif ($minutes > 0) {
            $expiryMessage = $minutes . ' minute' . ($minutes > 1 ? 's' : '');
        } else {
            $expiryMessage = $seconds . ' second' . ($seconds > 1 ? 's' : '');
        }
    }
}

?>

<html>

<body style="background-color:#ecedf1;  align-items: center; height: auto; min-height: 500px; margin: 10px; padding:10px;">

<center>

    <div style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  padding: 20px; text-align: center; width: 400px; background-color: white; margin:20px; margin-top:30px;">
        <h2 style="text-align: center; font-size:25px;  font-family: Arial, sans-serif;">One-Time-Password(OTP)</h2>
        <div style="border-radius: 15px; margin-top:20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: 0.3s; text-align: center; padding: 10px; background-color:#ecedf1;">
            <p style="font-family: Arial, sans-serif;"> 
                <?= isset($username) ? Html::encode($username) : '' ?>, 
                your One-Time Password is 
                <strong><?= isset($email_otp) ? Html::encode($email_otp) : '' ?></strong>. 
                It will expire in 
                <strong><?= $expiryMessage ?></strong>.
            </p>
        </div>
        <footer style="margin-top: 80px; margin-bottom:0px;font-size: 12px; color: #888;">
            <p>Walk Into the Wild</p>
        </footer>
    </div>
</center>
</body>

</html>
