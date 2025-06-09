<?php

use common\models\partnerregistration\PartnerRegistration;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
$webasset = Yii::$app->getUrlManager();
$this->params['baseurl'] = $webasset->baseUrl;
?>

<?php

$form = ActiveForm::begin([
    'id' => 'legal-entity',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'enableClientScript' => true,
    'options' => ['enctype' => 'multipart/form-data'],
    'action' => $model->action_url,
    'validationUrl' => $model->action_validate_url,
]);
?>

<div class="row">

    <div class="col-md-3">
        <?= $form->field($model, 'legal_entity_name')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Legal Entity Name',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'legal_entity_type')->dropDownList(
            PartnerRegistration::entitytypeoption(),
            [
                'prompt' => 'Select Entity Type',
                'class' => 'form-control',
                'disabled' => $readOnly,
            ]
        ) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'brand_name')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Brand Name',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-3">
        <?php
        if (!empty($model->logo)) {
        ?>
            <img src="<?= $model->logo_path ?>" alt="Logo" style="max-height:50px; max-width:100px;">
            <?= $form->field($model, 'logo')->hiddenInput(['id' => 'logo'])->label(false); ?>
        <?php
        }
        ?>
        <?= $form->field($model, 'logo_file_upload')->fileInput([
            'class' => 'form-control',
            'disabled' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'legal_entity_phone')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Legal Entity Phone',
            'readonly' => $readOnly,
            'onkeypress' => 'return /[0-9]/i.test(event.key)',
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'legal_entity_whatsapp')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Legal Entity Whatsapp',
            'readonly' => $readOnly,
            'onkeypress' => 'return /[0-9]/i.test(event.key)',
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'legal_entity_email')->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Legal Entity Email',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'address')->textarea([
            'class' => 'form-control',
            'rows' => 3,
            'placeholder' => 'Enter Address',
            'readonly' => $readOnly,
        ]) ?>
    </div>

</div>

<div class="d-flex justify-content-end mt-3">
    <?= Html::hiddenInput('step', 1) ?>
    <?php if($model->is_sendforapproval != 1 && ($model->form1_status == PartnerRegistration :: FORM_FILLED && $model->form2_status == PartnerRegistration :: FORM_FILLED && $model->form3_status == PartnerRegistration :: FORM_FILLED && $model->form4_status == PartnerRegistration :: FORM_FILLED && $model->form5_status == PartnerRegistration :: FORM_FILLED)){ ?>
         <?= Html::submitButton('Save', ['class' => 'btn btn-orange']) ?>
    <?php }elseif($model->form1_status == PartnerRegistration :: FORM_REJECTED || $model->form2_status == PartnerRegistration :: FORM_REJECTED || $model->form3_status == PartnerRegistration :: FORM_REJECTED || $model->form4_status == PartnerRegistration :: FORM_REJECTED || $model->form5_status == PartnerRegistration :: FORM_REJECTED){?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-orange']) ?>
    <?php }elseif($isLegalEntitySaved && $model->is_phone_no_verified){?>
            <?= Html::submitButton('Next', ['class' => 'btn btn-orange']) ?>
    <?php }else{?>
    <?= Html::submitButton('Save & Next', ['class' => 'btn btn-orange']) ?>
    <?php }?>
</div>

<?php ActiveForm::end();
