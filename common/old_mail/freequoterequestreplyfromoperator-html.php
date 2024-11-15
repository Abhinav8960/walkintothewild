<?php

use yii\helpers\Html;

?>
<div class="verify-email">
    <p>Hi <?= Html::encode($reply_to) ?>,</p>
    <p>

        <?php if (isset($show_planning_text) && $show_planning_text) { ?>
            Good news! You’ve received a reply from <?= Html::encode($reply_by) ?> regarding your quote request for <?= Html::encode($park_package_name) ?>. Please check your inbox to view the details and continue planning your adventure.

        <?php  } else { ?>
            You’ve received a reply from <?= Html::encode($reply_by) ?> regarding his quote request for <?= Html::encode($park_package_name) ?>. Please check your inbox to view the details .
        <?php  } ?>


    </p>
    <a style="background:#128A00;border:0; padding:8px 20px;color:#fff;text-decoration:none;" href="https://www.walkintothewild.in<?= $chat_url ?>">Check Inbox</a>
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