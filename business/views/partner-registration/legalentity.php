<?php

use common\models\partnerregistration\PartnerRegistration;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$readOnly = false;
?>
<?php
if ($model->form1_status == 1 || $model->form1_status == 2) {
    $this->title = 'Legal Entity';
    $this->params['title'] = $this->title;
?>
    <div class="card">
        <?= $this->render('legalentity-view', ['model' => $model]) ?>
    </div>

<?php
} elseif ($model->form1_status == 0 || $model->form1_status == 3) {
    $this->title = 'Legal Entity';
    $this->params['title'] = $this->title;
?>

    <?php

    $form = ActiveForm::begin([
        'id' => 'legal-entity',
        'action' => ['partner-registration/create'],
        'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>

    <div class="row">

        <div class="col-md-3">
            <?= $form->field($model, 'legal_entity_name', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Legal Entity Name',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'legal_entity_type', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->dropDownList(
                PartnerRegistration::entitytypeoption(),
                [
                    'prompt' => 'Select Entity Type',
                    'class' => 'form-control',
                    'disabled' => $readOnly,
                ]
            ) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'brand_name', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Brand Name',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'logo', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->fileInput([
                'class' => 'form-control',
                'disabled' => $readOnly, // can't use 'readonly' on file input
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'legal_entity_phone', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Legal Entity Phone',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'legal_entity_whatsapp', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Legal Entity Whatsapp',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'legal_entity_email', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter Legal Entity Email',
                'readonly' => $readOnly,
            ]) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'address', [
                'template' => '<label class="form-label">{label}</label>{input}{error}',
            ])->textarea([
                'class' => 'form-control',
                'rows' => 3,
                'placeholder' => 'Enter Address',
                'readonly' => $readOnly,
            ]) ?>
        </div>

    </div>

    <div class="d-flex justify-content-end mt-3">
        <?= Html::hiddenInput('step', 1) ?>
        <?= Html::submitButton('Next', ['class' => 'btn btn-info']) ?>
    </div>

<?php ActiveForm::end();
} ?>