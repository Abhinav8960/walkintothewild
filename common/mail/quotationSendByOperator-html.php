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
        <p style="font-weight: bold; margin-bottom: 20px;"><?= $partner_user && isset($partner_user) ? $partner_user : '' ?></p>
        <p style="margin-bottom: 20px;">Sent a Quote Request!<br>The user details are given below :</p>

        <div style="background-color: #e6f7e8; padding: 20px; border-radius: 8px; margin-bottom: 30px;">

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Name : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $username && isset($username) ? $username : '' ?> </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Email : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $user_email && isset($user_email) ? $user_email : '' ?></td>
                </tr>

                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 80%; color: #555; white-space: nowrap;">Number of Safaries : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $no_of_safari && isset($no_of_safari) ? $no_of_safari : '' ?></td>
                </tr>

                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;white-space: nowrap;">Number of Travellers : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $no_of_travelers && isset($no_of_travelers) ? $no_of_travelers : '' ?></td>
                </tr>

                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555; white-space: nowrap; ">Accomodation : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $accomodation && isset($accomodation) ? $accomodation : '' ?></td>
                </tr>

                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Park : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $parkname ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Start Date : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $start_date && isset($start_date) ? date('Y-m-d', strtotime($start_date)): '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">End Date : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $end_date && isset($end_date) ? date('Y-m-d', strtotime($end_date)): '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555; white-space: nowrap;">Validity Date : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $validity_date && isset($validity_date) ? date('Y-m-d', strtotime($validity_date)): '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555; white-space: nowrap;">Permit Booking Date : </td>
                    <td style="padding: 8px 0; color: #555;"><?= $permit_booking_date && isset($permit_booking_date) ? date('Y-m-d', strtotime($permit_booking_date)): '' ?></td>
                </tr>

            </table>

            <p style="font-size: 14px; color: #555; line-height: 1.5; margin-bottom: 20px;">
                <span style="padding: 8px 0; font-weight: bold; width: 40%; color: #555; white-space: nowrap;">Additional Notes</span><br>
                <span style="padding: 8px 0; color: #555;"><?= isset($addional_notes) ? $addional_notes : '' ?></span>
            </p>
            <table style="width: 100%; font-size: 18px; font-weight: bold; color: #333; margin-bottom: 20px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding-top: 15px; padding-bottom: 15px;">
                <tr>
                    <td style="text-align: left;">Amount <span style="color: #666666; font-size: 14px;">(inclusive of all taxes)</span></td>
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