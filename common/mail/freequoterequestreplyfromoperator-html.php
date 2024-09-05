<?php

use yii\helpers\Html;

?>
<div class="verify-email">
    <p><img src="https://www.walkintothewild.in/img/logo.png"></p>
    <p>Hi [User Name],</p>
    <p> Good news! You’ve received a reply from [Tour Operator Name] regarding your quote request for [Park Name]. Please check your inbox to view the details and continue planning your adventure.</p>
    <a style="background:#128A00;border:0; padding:8px 20px;color:#fff;text-decoration:none;" href="https://www.walkintothewild.in/">Check Inbox</a>
    <p style="margin-top:2% !important;">Best regards,</p>
    <p>Team Walk into the Wild</p>
</div>

<?php if (!(isset($is_email_sending) && $is_email_sending)) { ?>
    <div class="card">
        <div class="card-body">
            <p>Keyword:</p>
            <p>1. username</p>
            <p>1. parkname</p>
        </div>
    </div>
<?php } ?>