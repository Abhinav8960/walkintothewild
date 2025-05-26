<?php

use yii\helpers\Html;

?>
<div class="verify-email">
    <p>Hi <?= Html::encode($username) ?>,</p>
    <p>You have received a new quote request for <?= $parkname ?>,. Please check your inbox to review the details and respond promptly. </p>
    <p>Quote</p>
    <br>
    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
        <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Park</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($parkname) ? $parkname : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Travelers</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($travelers) ? $travelers : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Safaris</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($safaris) ? $safaris : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Start Date</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($start_date) ? $start_date : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">End Date</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($end_date) ? $end_date : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Stay Category</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($staycategory) ? $staycategory : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Additional Notes</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($addional_notes) ? $addional_notes : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Quote Amount</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($amount) ? $amount : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Payment Link</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($payment_url) ?  '<a href=' . $payment_url . '>Pay</a>' : '' ?></td>
            </tr>
            <?php if (isset($qr_code) && $qr_code): ?>
                <tr>
                    <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">QR Code</th>
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        <img src="<?= $qr_code ?>" alt="QR Code" style="max-width: 100px; max-height: 100px;">

                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <p>Best regards,</p>
    <p>Team Walk into the Wild
        <?php if (isset(\Yii::$app->params['environment'])) {
            echo \Yii::$app->params['environment'] != 'production' ?  \Yii::$app->params['environment'] : '';
        } ?>
    </p>
</div>