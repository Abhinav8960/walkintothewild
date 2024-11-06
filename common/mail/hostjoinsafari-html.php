<?php

use yii\helpers\Html;

?>

<div class="contact-form" style="font-family: Arial, sans-serif; font-size: 14px; color: #333; padding: 20px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    <p style="font-weight: bold; margin-bottom: 10px;">Hi <?= $creator_name ?></p>
    <p style="margin-bottom: 20px;"> Someone has joined your shared safari. Visit the interested member section to review and connect for your trip planning.</p>
    <br>
    <p><a href="<?= $shared_safari_url && isset($shared_safari_url) ? $shared_safari_url :''?>">View Update</a></p>
    <br>

    <br>
    <p style="margin-top: 2% !important; font-size: 12px; color: #666;">Thank you!</p>
    <p style="font-size: 12px; color: #666;">Best regards,</p>
    <p style="font-size: 12px; color: #666; font-weight: bold;">Team Walk into the Wild</p>
</div>