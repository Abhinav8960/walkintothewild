<?php

use common\models\cms\contentmanagement\ContentManagement;
use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Safari Tour Operator Registration';
$this->params['title'] = $this->title;
?>

<div class="terms-contionsSplasescreen">
  <!-- <picture>
        <source media="(max-width: 991px)" srcset="<?= $this->params['baseurl'] ?>/img/spalsemobile.png" class="d-block w-100">
        <source media="(min-width: 992px)" srcset="<?= $this->params['baseurl'] ?>/img/spalshscreendesktop.png" class="d-block w-100">
        <img src="<?= $this->params['baseurl'] ?>/img/spalsemobile.png" class="d-block w-100 " alt="banner">
    </picture> -->

</div>
<!--    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#termsmodal">
        Agree modal
    </button> -->
<div class="modal fade _standard-text mobile_loginconditions show" id="termsmodal" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: block;">
  <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
    <div class="modal-content">
      <?php $form = ActiveForm::begin([
        'id' => 'tag-form',
        'method' => 'POST',
        'fieldConfig' => [
          'template' => '<div class="form-group">{label}{input}{error}</div>',
        ],
      ]); ?>
      <div class="modal-header justify-content-center">
        <h1 class="modal-title fs-5">
          <img src="<?= $this->params['baseurl'] ?>/img/logo.png" alt="logo" width="180px" class="logo">
        </h1>
        <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
      </div>
      <div class="modal-body px-5">
        <div class="row py-4">
          <div class="col-12 logindesign">
            <?php /* $form = ActiveForm::begin([
              'id' => 'login-form',
              'enableAjaxValidation' => true,
              'enableClientValidation' => false,
              'enableClientScript' => true,
              'action' => $model->action_url,
              'validationUrl' => $model->action_validate_url,
            ]); ?>
            <div class="form_design">
              <div class="h6 text-center pb-2 text-muted">Log in to continue</div>
              <div class="emailfields mb-3">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'form-control' => 'form-control', 'style' => 'padding: 12px 10px;', 'placeholder' => 'Enter your Username'])->label(false) ?>
              </div>
              <div class="emailfields">
                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'form-control' => 'form-control', 'style' => 'padding: 12px 10px;', 'placeholder' => 'Enter your Password'])->label(false) ?>
              </div>
              <div class="emailfields">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
              </div>
              <div class="btns-submit pt-3">
                <?= Html::submitButton('Continue', ['class' => 'btns_submit rounded-1 w-100 fs-5', 'name' => 'login-button']) ?>
              </div>
            </div>
            <div class="continue pt-5">
              <h6 class="fs-5 text-center pb-2 text-muted">Or continue with:</h6>
            </div>
            <?php ActiveForm::end(); */ ?>
            <div class="btnssss-g">
              <?= \yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['site/auth'],
                'popupMode' => false,
              ]), 'Google' ?>
            </div>
            <!-- <div class="btnssss-g">
              <a href="/site/auth?authclient=google">
                <button class="googlelogin w-100 py-2  mb-3 d-flex align-items-center gap-2"> <img src="<?= $this->params['baseurl'] ?>/img/google-logo.5867462c.svg" width="25" alt="banner"> Google</button>
              </a>
              <a href="/site/auth?authclient=google">
                <button class="googlelogin w-100 py-2  mb-3 d-flex align-items-center gap-2"> <img src="<?= $this->params['baseurl'] ?>/img/apple-logo.54e0d711.svg" width="25" alt="banner"> Apple</button>
              </a>
            </div> -->
          </div>
        </div>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div><?php
      //   $script = <<< JS
      //     $('#termsmodal').modal('show');

      //     $('#termsmodal').on('click', '.modal-backdrop', function(e){
      //         e.preventDefault();
      //     });

      //     $(document).ready(function () {
      //         $(document).on('keydown', function(e){
      //             if (e.key === "Escape") {
      //                 alert('dsfsda');
      //                 console.log('just try');
      //                 window.location.href = "/";
      //             }
      //         });

      //         $('#termsmodal').on('show.bs.modal',
      //             function (event) {
      //                 $(this).data('bs.modal')._config.backdrop = 'static';
      //                 $(this).data('bs.modal')._config.keyboard = false;
      //             }
      //         );
      //     });
      // JS;
      //   $this->registerJs($script);
      ?>


<style>
  footer {

    display: none;
  }

  header {
    display: none;
  }
</style>