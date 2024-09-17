<?php

use yii\helpers\Html;

?>

<div class="contact-form" style="font-family: Arial, sans-serif; font-size: 14px; color: #333; padding: 20px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <p style="font-weight: bold; margin-bottom: 10px;">Hi Admin,</p>
    <p style="margin-bottom: 20px;">You have received a new contact form.</p>
    <br>
    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Name</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $contact && isset($contact['name']) ? $contact['name'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Phone Number</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $contact && isset($contact['phone']) ? $contact['phone'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Email</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $contact && isset($contact['email']) ? $contact['email'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Message</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $contact && isset($contact['message']) ? $contact['message'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">User Device</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $contact && isset($contact['user_device']) ? $contact['user_device'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">User OS</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $contact && isset($contact['user_platform']) ? $contact['user_platform'] : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">User Browser</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= $contact && isset($contact['user_browser']) ? $contact['user_browser'] : '' ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <p style="margin-top: 2% !important; font-size: 12px; color: #666;">Thank you!</p>
    <p style="font-size: 12px; color: #666;">Best regards,</p>
    <p style="font-size: 12px; color: #666; font-weight: bold;">Team Walk into the Wild</p>
</div>