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
<?php
if (isset($key) && !empty($key)) {
?>
    <!--    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#termsmodal">
        Agree modal
    </button> -->
    <div class="modal fade _standard-text mobile_loginconditions" id="termsmodal" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                        <div class="col-12">
                            <div class="content_terms">
                                <h5 class="text-center">Create your account</h5>
                                <div class="login_users pt-4">
                                    <h6 class="colorgreen ">Email Address</h6>
                                    <h6 class="fs-5 fw-bold"><?= $model->email ?></h6>
                                </div>
                                <div class="login_users pt-4">
                                    <h6 class="colorgreen ">Full Name</h6>
                                    <h6 class="fs-5 fw-bold"><?= ucwords($model->name) ?></h6>
                                </div>
                                <div class="contenss pt-3">
                                <p>By creating an account, I accept the WalkIntoTheWild <a href="/termsandcondition" target="_blank">Terms of Service</a> and acknowledge the Privacy Policy.</p>
                                </div>
                               
                                <?= $form->field($model, 'rand_key')->hiddenInput()->label(false); ?>
                                <div class="btns-submit">
                                <?= Html::submitButton('Create your account', ['class' => 'btns_submit rounded-1 w-100 fs-5']) ?>
                                </div>
                                <div class="contenss pt-3 ">
                                <p class="text-center"><a href="/site/login">Already have an WalkIntoTheWild account? Log in</a></p>
                                </div>
                                
                            </div>
                        </div>

                        <!-- <div class="col-12 logindesign">
                            <div class="form_design">
                                <div class="h6 text-center pb-2 text-muted">Log in to continue</div>
                                <div class="emailfields mb-3">
                                    <input type="text" class="form-control " style="padding: 12px 10px;" placeholder="Enter your Email">
                                </div>
                                <div class="emailfields">
                                    <input type="text" class="form-control " style="padding: 12px 10px;" placeholder="Enter yoyr password">
                                </div>
                                <div class="btns-submit pt-3">
                                    <?= Html::submitButton('Create your account', ['class' => 'btns_submit rounded-1 w-100 fs-5']) ?>
                                </div>
                            </div>
                            <div class="continue pt-5">
                                <h6 class="fs-5 text-center pb-2 text-muted">Or continue With:</h6>
                            </div>
                            <div class="btnssss-g">
                                <button class="googlelogin w-100 py-2  mb-3 d-flex align-items-center gap-2"> <img src="<?= $this->params['baseurl'] ?>/img/google-logo.5867462c.svg" width="25" alt="banner"> Google</button>
                                <button class="googlelogin w-100 py-2  mb-3 d-flex align-items-center gap-2"> <img src="<?= $this->params['baseurl'] ?>/img/apple-logo.54e0d711.svg" width="25" alt="banner"> Apple</button>
                            </div>

                        </div> -->
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div><?php
            $script = <<< JS
        $('#termsmodal').modal('show');

        $('#termsmodal').on('click', '.modal-backdrop', function(e){
            e.preventDefault();
        });

        $(document).ready(function () {
            $(document).on('keydown', function(e){
                if (e.key === "Escape") {
                    alert('dsfsda');
                    console.log('just try');
                    window.location.href = "/";
                }
            });

            $('#termsmodal').on('show.bs.modal',
                function (event) {
                    $(this).data('bs.modal')._config.backdrop = 'static';
                    $(this).data('bs.modal')._config.keyboard = false;
                }
            );
        });
    JS;
            $this->registerJs($script);
        }
            ?>


<style>
    footer {

        display: none;
    }

    header {
        display: none;
    }
</style>