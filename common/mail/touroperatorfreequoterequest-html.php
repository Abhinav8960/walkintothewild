<?php

use yii\helpers\Html;

?>
<div class="verify-email">
    <p>Hi <?= Html::encode($username) ?>,</p>
    <p> You have received a new quote request for <?= Html::encode($parkname) ?>. Please check your inbox to review the details and respond promptly. </p>
    <a style="background:#128A00;border:0; padding:8px 20px;color:#fff;text-decoration:none;" href="https://www.walkintothewild.in<?= $chat_url ?>">Check Inbox</a>
    <p style="margin-top:2% !important;">Thank you!</p>
    <p>Best regards,</p>
    <p>Team Walk into the Wild
        <?php if (isset(\Yii::$app->params['environment'])) {
            \Yii::$app->params['environment'] != 'production' ?  \Yii::$app->params['environment'] : '';
        } ?>
    </p>
</div>