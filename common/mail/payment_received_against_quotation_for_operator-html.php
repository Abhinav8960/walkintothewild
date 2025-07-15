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
        <p style="font-size: 18px; color: #333; margin-bottom: 20px; font-style: italic;">Hi <?= Html::encode($username) ?>, Payment received! You can initiate the arrangements. Please find the traveler’s contact information below.</p>

        <p style="font-size: 22px; font-weight: bold; color: #333; margin-bottom: 20px;"><?= $parkname ?> <?= isset($night_stay_count) ? ' + ' . $night_stay_count . ' Nights Stay' : '' ?> <?= isset($safaris) ? ' + ' . $safaris . ' Jungle Safaris' : '' ?></p>

        <div style="background-color: #e6f7e8; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
            <div style="font-size: 18px; font-weight: bold; color: #333; text-align: center; margin-bottom: 15px;">Quotation</div>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Park</td>
                    <td style="padding: 8px 0; color: #555;"><?= $parkname ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Travelers</td>
                    <td style="padding: 8px 0; color: #555;"><?= isset($travelers) ? $travelers : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Safaris</td>
                    <td style="padding: 8px 0; color: #555;"><?= isset($safaris) ? $safaris : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Stay Category</td>
                    <td style="padding: 8px 0; color: #555;"><?= isset($staycategory) ? $staycategory : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Start Date</td>
                    <td style="padding: 8px 0; color: #555;"><?= isset($start_date) ? $start_date : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">End Date</td>
                    <td style="padding: 8px 0; color: #555;"><?= isset($end_date) ? $end_date : '' ?></td>
                </tr>

            </table>

            <p style="font-size: 14px; color: #555; line-height: 1.5; margin-bottom: 20px;">
                <span style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Additional Notes</span><br>
                <span style="padding: 8px 0; color: #555;"><?= isset($addional_notes) ? $addional_notes : '' ?></span>
            </p>

            <table style="width: 100%; font-size: 18px; font-weight: bold; color: #333; margin-bottom: 20px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding-top: 15px; padding-bottom: 15px;">
                <tr>
                    <td style="text-align: left;">Amount <span style="color: #666666; font-size: 14px;">(inclusive of all taxes)</span></td>
                    <td style="text-align: right;"><?= isset($amount) ? '₹' . $amount : '' ?></td>
                </tr>
            </table>


            <div style="text-align: center; margin-bottom: 30px;">
                <table style="width: 100%; font-size: 20px; font-weight: 600; margin-bottom: 10px;">
                    <tr>
                        <td style="text-align: left;">Payment Recieved.</td>
                        <td style="text-align: left;">Reference No: <?= $reference_no ?? '' ?></td>
                    </tr>
                </table>

            </div>
        </div>

        
    </div>
</div>