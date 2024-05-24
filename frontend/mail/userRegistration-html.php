<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
<div class="verify-email">
    <p>Dear <?= Html::encode($user->username) ?>,</p>
    <p>Welcome to [Your Company Name]!</p>
    <p>We are thrilled to have you on board and to see you join our community. Your registration was successful, and you are now part of an exciting journey with us.</p>
</div>