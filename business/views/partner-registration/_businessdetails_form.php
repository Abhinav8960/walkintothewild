<?php

use common\models\GeneralModel;
use common\models\partnerregistration\PartnerRegistration;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;

?>


<?php $form = ActiveForm::begin([
    'options' => ['id' => 'business-details','enctype' => 'multipart/form-data']
]); ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'operated_park', [
            'template' => '<label class="form-label">{label}</label>{input}{error}',
        ])->dropDownList(
            GeneralModel::safariparklist(),
            [
                'prompt' => 'Select Park',
                'disabled' => $readOnly,
                'class' => 'form-control',
            ]
        ) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'about_business', [
            'template' => '<label class="form-label">{label}</label>{input}{error}',
        ])->textarea([
            'class' => 'form-control',
            'rows' => 3,
            'placeholder' => 'Enter About Your Business',
            'readonly' => $readOnly,
        ]) ?>
    </div>
    <hr>
    <h5>GST</h5>
    <div class="col-md-4">
        <?= $form->field($gst_model, 'state', [
            'template' => '<label class="form-label">{label}</label>{input}{error}',
        ])->dropDownList(
            GeneralModel::stateoption(),
            [
                'prompt' => 'Select State',
                'class' => 'form-control',
                'disabled' => $readOnly,
            ]
        ) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($gst_model, 'gst_number', [
            'template' => '<label class="form-label">{label}</label>{input}{error}',
        ])->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter GST Number',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($gst_model, 'filepath', [
            'template' => '<label class="form-label">{label}</label>{input}{error}',
        ])->fileInput([
            'class' => 'form-control',
            'disabled' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'billing_phone', [
            'template' => '<label class="form-label">{label}</label>{input}{error}',
        ])->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Billing Phone',
            'readonly' => $readOnly,
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'billing_mail', [
            'template' => '<label class="form-label">{label}</label>{input}{error}',
        ])->textInput([
            'class' => 'form-control',
            'placeholder' => 'Enter Billing Mail',
            'readonly' => $readOnly,
        ]) ?>
    </div>


</div>

<div class="d-flex justify-content-end mt-3">
    <?= Html::hiddenInput('step', $currentStep) ?>
    <?= $form->field($model, 'form3_status')->hiddenInput(['value' => 1])->label(false) ?>
    <?= Html::submitButton('Next', ['class' => 'btn btn-info']) ?>
</div>

<?php ActiveForm::end();
?>