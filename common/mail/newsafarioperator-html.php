<?php

use yii\helpers\Html;

?>

<div class="contact-form" style="font-family: Arial, sans-serif; font-size: 14px; color: #333; padding: 20px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <p style="font-weight: bold; margin-bottom: 10px;">Hi Admin,</p>
    <p style="margin-bottom: 20px;"><?= $safari_operator && isset($safari_operator['business_name']) ? $safari_operator['business_name'] : '' ?> registered.</p>
    <br>
    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Bussiness Name</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $safari_operator && isset($safari_operator['business_name']) ? $safari_operator['business_name'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Register Company Name</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $safari_operator && isset($safari_operator['register_comapany_name']) ? $safari_operator['register_comapany_name'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Address</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $safari_operator && isset($safari_operator['address']) ? $safari_operator['address'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Email</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $safari_operator && isset($safari_operator['email']) ? $safari_operator['email'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Link</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $operator_url && isset($operator_url) ? $operator_url : '' ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <p style="margin-top: 2% !important; font-size: 12px; color: #666;">Thank you!</p>
    <p style="font-size: 12px; color: #666;">Best regards,</p>
    <p style="font-size: 12px; color: #666; font-weight: bold;">Team Walk into the Wild</p>
</div>