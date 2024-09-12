<?php

use yii\helpers\Html;

?>
<div class="verify-email">
    <p>Hi <?= Html::encode($username) ?>,</p>
    <p> You have received a new quote request for <?= Html::encode($parkname) ?>. Please check your inbox to review the details and respond promptly. </p>
    <a style="background:#128A00;border:0; padding:8px 20px;color:#fff;text-decoration:none;" href="https://www.walkintothewild.in<?= $chat_url ?>">Check Inbox</a>
    <p style="margin-top:2% !important;">Thank you!</p>
    <p>Best regards,</p>
    <p>Team Walk into the Wild</p>
</div>
<?php if (!(isset($is_email_sending) && $is_email_sending)) { ?>
    <div class="card">
        <div class="card-body">
            <p>Sample Array :</p>
            <p>1. username</p>
            <p>2. parkname</p>


            <p>Expected Key :</p>
            <p>1. Annu Singh</p>
            <p>2. Bandhavgarh</p>
        </div>
    </div>
<?php } ?>