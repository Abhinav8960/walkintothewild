<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>


<?php $form = ActiveForm::begin([
    'id' => 'author-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>

<div class="row">
    <div class="col-xxl-3 col-lg-4 col-md-4  mb-lg-0 mb-3">
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
    <div class="col-xxl-9 col-lg-8 col-md-8">
        <div class="tab-content_tour active " id="tab21">
            <!-- Safari Parks content goes here -->
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'share_safari_terms_condtition')->textarea(['rows' => '2', 'placeholder' => 'Mention Terms & Condtition'])->label('Terms Condtition') ?>
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
                    <?= $form->field($model, 'change_policy')->textarea(['rows' => '2', 'placeholder' => 'Share Safari Change Policy'])->label(false) ?>
                </div>
            </div>
        </div>

        <div class="tab-content_tour " id="tab24">
            <div class="searchSafari_parks mb-4">
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'what_you_must_carry')->textarea(['rows' => '2', 'placeholder' => 'Share Safari What You Must Carry'])->label(false) ?>
                    </div>
                </div>
            </div>


        </div>

        <div class="tab-content_tour" id="tab25">
            <!-- Shared Safari content goes here -->
            <div class="row">
                <?= $form->field($model, 'date_change_policy')->textarea(['rows' => '2', 'placeholder' => 'Mention Date Change Policy'])->label('Date Change Policy') ?>
            </div>
        </div>

        <div class="tab-content_tour mb-4" id="tab26">
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'refund_policy')->textarea(['rows' => '2', 'placeholder' => 'Mention Refund Policy'])->label('Refund Policy') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="creat-safri d-flex justify-content-end ">
            <?= Html::submitButton('Update ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
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
bulleteditor('createdepartureform-share_safari_terms_condtition');
bulleteditor('createdepartureform-privacy_policy');
bulleteditor('createdepartureform-change_policy');
bulleteditor('createdepartureform-what_you_must_carry');
bulleteditor('createdepartureform-date_change_policy');
bulleteditor('createdepartureform-refund_policy');
JS;
$this->registerJs($script);
?>