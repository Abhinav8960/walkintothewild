<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email">
    <p>Dear <?= Html::encode($username) ?>,</p>
    <p>Welcome to Walk Into The Wild!</p>
    <p>We are thrilled to inform that you were recently followed by <?= Html::encode($name) ?>.</p><br>
    <p style="text-align:center">Stay tuned for updates!</p>
    <p style="text-align:center">Team Walk into the Wild</p>
    <p style="text-align:center"><a href="https://www.walkintothewild.in" style="text-align:center !important;color:blue !important;">www.walkintothewild.in</a></p>
    <p><img src="https://staging-manage.walkintothewild.in/img/logo.png"></p>
</div>