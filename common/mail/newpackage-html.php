<?php

use yii\helpers\Html;

?>

<div class="contact-form" style="font-family: Arial, sans-serif; font-size: 14px; color: #333; padding: 20px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <p style="font-weight: bold; margin-bottom: 10px;">Hi Admin,</p>
    <p style="margin-bottom: 20px;"><?= $operator_name && isset($operator_name) ? $operator_name : '' ?> created a new package.</p>
    <br>
    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Package Name</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $package && isset($package['package_name']) ? $package['package_name'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Number of Safari</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $package && isset($package['no_of_safari']) ? $package['no_of_safari'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Start Location</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $package && isset($package['start_location']) ? $package['start_location'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">End Location</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $package && isset($package['end_location']) ? $package['end_location'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Start Date</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $package && isset($package['start_date']) ? $package['start_date'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">End Date</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $package && isset($package['end_date']) ? $package['end_date'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Cost Per Person</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $package && isset($package['cost_per_person']) ? $package['cost_per_person'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Link</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $package_url && isset($package_url) ? $package_url : '' ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <p style="margin-top: 2% !important; font-size: 12px; color: #666;">Thank you!</p>
    <p style="font-size: 12px; color: #666;">Best regards,</p>
    <p style="font-size: 12px; color: #666; font-weight: bold;">Team Walk into the Wild</p>
</div>