<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="login_form_admin ">
                <div class="topheadinglogin pb-4 text-center">
                    <img src="/theme/img/logo_transparent.png">
                </div>
                <div class="row pt-5">
                    <div class="col-lg-12">
                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <div class="mb-4">
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Username'])->label(false) ?>
                        </div>
                        <div class="mb-4">
                            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false)  ?>
                        </div>
                        <div class="mb-4">
                            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block logIn_btn ', 'name' => 'login-button']) ?>
                        </div>
                        <div class="login-with text-center text-black">
                            <p>Or login with</p>
                            <div class="google-login-box d-inline-flex ">
                                <?= \yii\authclient\widgets\AuthChoice::widget([
                                    'baseAuthUrl' => ['site/auth'],
                                    'popupMode' => false,
                                ]), 'Google' ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<style>
    .container_login {

        background: url('/img/bannerhome.png');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .login_form_admin {

        /* background: #add740; */
        background: #90942287;
        box-shadow: 0px 4px 4px 0px #00000040;
        /* backdrop-filter: blur(8px); */
        /* -webkit-backdrop-filter: blur(8px); */
        padding: 40px 20px;
        border-radius: 10px;
        /* border: 1px solid rgba(255, 255, 255, 0.18); */
        color: #fff;


    }

    .login_form_admin #login-form .form-control {

        background-color: #DCE8FF;
        padding: 8px 10px;

    }

    .login_form_admin #login-form .form-control:focus {

        box-shadow: none;
        border-color: #DCE8FF;
    }

    .logIn_btn {
        padding-top: 20px;
    }

    button.logIn_btn {

        padding: 8px 10px !important;
        width: 100%;
        background-color: #09422D;
        border-color: #09422D;
        color: #fff;
        font-weight: 500;
        font-size: 18px;


    }

    button.logIn_btn:hover {

        background-color: #09422D !important;
        border-color: #09422D;
        color: #fff;
    }

    .google-login-box {

        background: #DCE8FF;
        padding: 6px 24px;
        border-radius: 0.5rem;
        color: #000000;
        align-items: center;
    }

    .auth-clients {

        margin: -8px;
        padding: 0;

    }
</style>