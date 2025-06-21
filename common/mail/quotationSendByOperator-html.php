<?php

use yii\helpers\Html;

?>
<div style="font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <table style="width: 100%; margin-bottom: 30px;">
            <tr>
                <td style="text-align: left; vertical-align: middle;">
                    <img src="<?= \Yii::$app->params['s3_endpoint'] . '/img/default_witw.png' ?>" alt="walkintothewild" style="height: 40px;">
                </td>
                <td style="text-align: right; vertical-align: middle; font-size: 14px; color: #555;">
                    <b><?= date('d M, Y') ?></b>
                </td>
            </tr>
        </table>
        <hr>
        <p style="font-weight: bold; margin-bottom: 10px;">Hi Admin,</p>
        <p style="font-weight: bold; margin-bottom: 20px;"><?= $partner_user && isset($partner_user) ? $partner_user : '' ?> </p> Sent a Quote Request For <p style="font-weight: bold; margin-bottom: 20px;"><?= $username && isset($username) ? $username : '' ?> </p>
        <p style="margin-bottom: 20px;">With the below amount.</p>

        <div style="background-color: #e6f7e8; padding: 20px; border-radius: 8px; margin-bottom: 30px;">

            <table style="width: 100%; font-size: 18px; font-weight: bold; color: #333; margin-bottom: 20px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding-top: 15px; padding-bottom: 15px;">
                <tr>
                    <td style="text-align: left;">Amount <span style="color: #666666; font-size: 14px;"></span></td>
                    <td style="text-align: right;"><?= isset($amount) ? '₹' . $amount : '' ?></td>
                </tr>
            </table>
        </div>

        <p style="font-weight: bold; margin-bottom: 10px;">Please Check on your portal!</p>

        <footer style="margin-top: 80px; margin-bottom:0px;font-size: 12px; color: #888;">
            <p>Walk Into the Wild</p>
        </footer>
    </div>
</div>