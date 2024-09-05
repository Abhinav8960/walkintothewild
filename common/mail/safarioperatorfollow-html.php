<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email">
    <p>Dear <?= Html::encode($username) ?>,</p>
    <p>Welcome to Walk Into The Wild!</p>
    <p>We are thrilled to inform that you were recently followed by <?= Html::encode($name) ?>.</p><br>
    <p>Stay tuned for updates!</p>
    <p>Team Walk into the Wild</p>
    <p><a href="https://www.walkintothewild.in" style="text-align:center !important;color:blue !important;">www.walkintothewild.in</a></p>
    <p><img src="https://www.walkintothewild.in/img/logo.png"></p>
</div>
<?php if (!(isset($is_email_sending) && $is_email_sending)) { ?>
    <div class="card">
        <div class="card-body">
            <p>Keyword:</p>
            <p>1. username</p>
            <p>1. name (followed by name)</p>
        </div>
    </div>
<?php } ?>