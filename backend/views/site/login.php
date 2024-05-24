<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>
<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

<div class="container">
    <div class="login-box">
        <h1>Walk into the Wild</h1>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>

        <div class="login-with">
            <p>Or login with</p>
            <div class="google-login-box">
                <?= \yii\authclient\widgets\AuthChoice::widget([
                    'baseAuthUrl' => ['site/auth'],
                    'popupMode' => false,
                ]) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<style>
    body,
    html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        background: url('/img/Login.jpg') no-repeat center center/cover;
    }

    .container {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .login-box {
        background-color: rgba(102, 153, 0, 0.8);
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        max-width: 600px;
        width: 100%;
        box-sizing: border-box;
        margin: 0 auto;
        /* Centering the login-box */
    }

    .login-box h1 {
        color: #fff;
        margin-bottom: 20px;
    }

    .login-box .form-group {
        display: flex;
        justify-content: center;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
        width: 80%;
        /* Adjusted to fit within the form */
        padding: 10px;
        margin: 10px 0;
        border: none;
        border-radius: 4px;
        box-sizing: border-box;
        margin: 0 auto;
        /* Centering input fields */
    }

    .login-box button[type="submit"] {
        width: 80%;
        /* 
</style>