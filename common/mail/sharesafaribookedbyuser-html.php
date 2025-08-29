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
        <p style="font-weight: bold; margin-bottom: 10px;">Booking confirmed!!</p>
        <p style="margin-bottom: 20px;">Details are given below :</p>

        <div style="background-color: #e6f7e8; padding: 20px; border-radius: 8px; margin-bottom: 30px;">

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 20%; color: #555;">Name : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $name && isset($name) ? $name : '' ?> </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 20%; color: #555;">Shared Safari : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $shared_safari_title && isset($shared_safari_title) ? $shared_safari_title : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 20%; color: #555;">Park : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $park && isset($park) ? $park : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 20%; color: #555;">Start Date : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $start_date && isset($start_date) ? date('M d, Y', strtotime($start_date)) : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 20%; color: #555;">End Date : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $end_date && isset($end_date) ? date('M d, Y', strtotime($end_date)) : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 20%; color: #555; white-space: nowrap;">Number of Safaries : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $no_of_safari && isset($no_of_safari) ? $no_of_safari : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 20%; color: #555;white-space: nowrap;">Seats : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $booked_seat && isset($booked_seat) ? $booked_seat : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 20%; color: #555; white-space: nowrap; ">Amount : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $amount && isset($amount) ? $amount : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 20%; color: #555; white-space: nowrap; ">Reference Id : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $referenceId && isset($referenceId) ? $referenceId : '' ?></td>
                </tr>
            </table>

        </div>
        <?php
        if (isset($call_to) && $call_to == 'user') {
        ?>
            <p style="font-weight: bold; margin-bottom: 10px;">For any queries or further discussion, message here or call the user using the call button in chat.</p>

        <?php

        } else {
        ?>
            <p style="font-weight: bold; margin-bottom: 10px;">For any queries or further discussion, message here or call the operator using the call button in chat.</p>

        <?php
        }
        ?>
        <p style="font-weight: bold; margin-bottom: 10px;">Enjoy your upcoming safari!</p>

        <footer style="margin-top: 80px; margin-bottom:0px;font-size: 12px; color: #888;">
            <p>Walk Into the Wild</p>
        </footer>
    </div>
</div>