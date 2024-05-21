<?php

use common\models\User;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */
$username = Yii::$app->request->post('LoginForm')['username'];
$user = User::find()->where(['username' => $username])->limit(1)->one();
?>
<div class="verify-email">
    <p>Dear <?= Html::encode($user->name) ?>,</p>

    <p> You are successfully login to Walk into wild </p>
</div>