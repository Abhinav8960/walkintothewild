<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email" style="text-align:center">
    <p style="text-align:center"> "Due to <?= Html::encode($reason) ?> reason, your shared safari was not approved. Please make a new safari..."</p>
    <p style="text-align:center">Team Walk into the Wild</p>
    <p style="text-align:center"><a href="https://www.walkintothewild.in" style="text-align:center !important;color:blue !important;">www.walkintothewild.in</a></p>
    <p><img src="https://www.walkintothewild.in/img/logo.png"></p>
</div>
<?php if (!(isset($is_email_sending) && $is_email_sending)) { ?>
    <div class="card">
        <div class="card-body">
            <p>Sample Array :</p>
            <p>1. reason</p>


            <p>Expected Key :</p>
            <p>1. Spam</p>
        </div>
    </div>
<?php } ?>