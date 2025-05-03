<?php

use common\models\GeneralModel;
use common\models\partnerregistration\PartnerRegistration;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;

?>


<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'business-details',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'enableClientScript' => true,
        'action' => $model->action_url,
        'validationUrl' => $model->action_validate_url,
        'enctype' => 'multipart/form-data'
    ]
]); ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'park_list')->widget(Select2 :: class,
            [
                'data' => GeneralModel::safariparklist(),
                'options' => ['placeholder' => 'Select Park', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                // 'prompt' => 'Select Park',
                'disabled' => $readOnly,
                'class' => 'form-control',
            ]
        )->label('Operated Park') ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'about_business')->textarea([
            'class' => 'form-control',
            'rows' => 3,
            'placeholder' => 'Enter About Your Business',
            'readonly' => $readOnly,
        ]) ?>
    </div>
    <hr>
    <h5>GST</h5>
    <div class="col-md-4">
        <?= $form->field($gst_model, 'state')->dropDownList(
            GeneralModel::stateoption(),
            [
                'prompt' => 'Select State',
                'class' => 'form-control',
                'disabled' => $readOnly,
            ]
        ) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($gst_model, 'gst_number')->textInput([
            'class' => 'form-control',
            'oninput' => "this.value = this.value.toUpperCase();",
            'placeholder' => 'Enter GST Number',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-3">
        <?php
        if (!empty($gst_model->filepath)) {
        ?>
            <img src="<?=Yii::$app->params['s3_endpoint'] .'/'.$model->partner_model->gstDetail->filepath ?>" alt="GSTfile" style="max-height:50px;max-width:100px;">
            <?= $form->field($gst_model, 'filepath')->hiddenInput(['id' => 'filepath'])->label(false); ?>
        <?php
        }
        ?>
        <?= $form->field($gst_model, 'filepath_upload')->fileInput([
            'class' => 'form-control',
            'disabled' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'billing_phone')->textInput([
            'class' => 'form-control',
            'maxlength'=>10,
            'placeholder' => 'Enter Billing Phone',
            'readonly' => $readOnly,
            'onkeypress' => 'return /[0-9]/i.test(event.key)',
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'billing_mail')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Billing Mail',
            'readonly' => $readOnly,
        ]) ?>
    </div>


</div>

<div class="d-flex justify-content-end mt-3">
    <?= Html::hiddenInput('step', $currentStep) ?>
    <?= $form->field($model, 'form3_status')->hiddenInput(['value' => 1])->label(false) ?>
    <?php if($model->is_sendforapproval != 1 && ($model->form1_status == PartnerRegistration :: FORM_FILLED && $model->form2_status == PartnerRegistration :: FORM_FILLED && $model->form3_status == PartnerRegistration :: FORM_FILLED && $model->form4_status == PartnerRegistration :: FORM_FILLED && $model->form5_status == PartnerRegistration :: FORM_FILLED)){ ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-orange']) ?>
    <?php }elseif($model->form1_status == PartnerRegistration :: FORM_REJECTED || $model->form2_status == PartnerRegistration :: FORM_REJECTED || $model->form3_status == PartnerRegistration :: FORM_REJECTED || $model->form4_status == PartnerRegistration :: FORM_REJECTED || $model->form5_status == PartnerRegistration :: FORM_REJECTED){?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-orange']) ?>
    <?php }else{?>
    <?= Html::submitButton('Save & Next', ['class' => 'btn btn-orange']) ?>
    <?php }?>
</div>

<?php ActiveForm::end();
?>