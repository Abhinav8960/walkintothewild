<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>

<?php $form = ActiveForm::begin([
    'id' => 'author-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<div class="card">
    <div class="card-body">
        <div class="container-fluid-fluid">
            <div class="row">
                <div class="col-lg-4 col-xl-3 col-xxl-2  mb-lg-0 mb-3">
                    <div class="safri_tour">
                        <div class="topics_listing">
                            <ul id="tabList">
                                <li><a class="tab-items active_safri" data-tab="tab21">
                                        <div class="numparks">Terms Condtition</div><i class="fa-solid fa-chevron-right"></i>
                                    </a></li>
                                <!-- <li><a class="tab-items " data-tab="tab22">
                                        <div class="numparks">Privacy Policy</div><i class="fa-solid fa-chevron-right"></i>
                                    </a></li>
                                <li><a class="tab-items" data-tab="tab23">
                                        <div class="numparks">Change Policy </div><i class="fa-solid fa-chevron-right"></i>
                                    </a></li>
                                <li><a class="tab-items " data-tab="tab24">
                                        <div class="numparks">What You Must Carry </div><i class="fa-solid fa-chevron-right"></i>
                                    </a></li> -->
                                <li><a class="tab-items " data-tab="tab25">
                                        <div class="numparks">Date Change Policy </div><i class="fa-solid fa-chevron-right"></i>
                                    </a></li>
                                <li><a class="tab-items " data-tab="tab26">
                                        <div class="numparks">Refund Policy </div><i class="fa-solid fa-chevron-right"></i>
                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xxl-10 col-xl-9">
                    <div class="tab-content_tour active " id="tab21">
                        <!-- Safari Parks content goes here -->
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'package_terms_condtition')->textarea(['rows' => '2', 'placeholder' => 'Mention Terms & Condtition'])->label('Terms Condtition') ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content_tour" id="tab22">
                        <!-- Safari Parks content goes here -->
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'privacy_policy')->textarea(['rows' => '2', 'placeholder' => 'Mention Privacy Policy'])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content_tour" id="tab23">
                        <!-- Safari Parks content goes here -->
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'change_policy')->textarea(['rows' => '2', 'placeholder' => 'Package Change Policy'])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content_tour " id="tab24">
                    <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'what_you_must_carry')->textarea(['rows' => '2', 'placeholder' => 'Package What You Must Carry'])->label(false) ?>
                                </div>
                            </div>
                    </div>

                    <div class="tab-content_tour" id="tab25">
                        <!-- Shared Safari content goes here -->
                        <div class="row">
                            <div class="col-12">
                            <?= $form->field($model, 'date_change_policy')->textarea(['rows' => '2', 'placeholder' => 'Mention Date Change Policy'])->label('Date Change Policy') ?>
                            </div>
                           
                        </div>
                    </div>

                    <div class="tab-content_tour " id="tab26">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'refund_policy')->textarea(['rows' => '2', 'placeholder' => 'Mention Refund Policy'])->label("Refund Policy") ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="creat-safri float-end w-auto">
                    <?= Html::submitButton('Create ', ['class' => 'safari_create font_set ']) ?>
                </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php ActiveForm::end(); ?>


<style>
    .ck-editor__editable {
        min-height: 350px;
        min-width: 350px;
    }
</style>
<?php
$script = <<< JS
bulleteditor('packageform-package_terms_condtition');
bulleteditor('packageform-privacy_policy');
bulleteditor('packageform-change_policy');
bulleteditor('packageform-what_you_must_carry');
bulleteditor('packageform-date_change_policy');
bulleteditor('packageform-refund_policy');
JS;
$this->registerJs($script);
?>