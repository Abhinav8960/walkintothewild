<?php

use business\assets\AppAsset;
use business\assets\NovaAppAsset;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

NovaAppAsset::register($this);
AppAsset::register($this);
$webasset = $this->assetManager->getBundle('business\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Bussiness Sign in | Walk Into the Wild';
$this->params['title'] = $this->title;
?>
<div class="modal fade _standard-text mobile_loginconditions show" id="termsmodal" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5">
                    <img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="logo" width="180px" class="logo">
                </h1>
            </div>
            <div class="modal-body px-5">
                <div class="row py-4">
                    <div class="col-12 logindesign">
                        <div class="content_terms">
                            <h5 class="text-center">Partner Login</h5>
                            <div style="border:none;">
                                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                                <?= $form->field($model, 'google_source_id')->textInput(['placeholder' => 'Enter Google Source Id']) ?>


                                <div class="form-group logIn_btn">
                                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    footer {

        display: none;
    }

    header {
        display: none;
    }
</style>