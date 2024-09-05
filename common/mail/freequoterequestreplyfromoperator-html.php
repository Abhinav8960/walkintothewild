<?php

use yii\helpers\Html;

?>
<div class="verify-email">
    <p><img src="https://www.walkintothewild.in/img/logo.png"></p>
    <p>Hi <?= Html::encode($reply_to) ?>,</p>
    <p> Good news! You’ve received a reply from [<?= Html::encode($reply_by) ?>] regarding your quote request for <?= Html::encode($park_package_name) ?>. Please check your inbox to view the details and continue planning your adventure.</p>
    <a style="background:#128A00;border:0; padding:8px 20px;color:#fff;text-decoration:none;" href="https://www.walkintothewild.in/<?= Html::encode($chat_url) ?>">Check Inbox</a>
    <p>Best regards,</p>
    <p>Team Walk into the Wild</p>
</div>