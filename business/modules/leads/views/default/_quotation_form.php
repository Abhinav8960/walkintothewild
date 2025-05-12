<?php


use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id' => 'quotation-form',
    'method' => 'POST',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'enableClientScript' => true,
    'action' => $model->action_url,
    'validationUrl' => $model->action_validate_url,
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<div class="row">

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'name')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Travelers name',
        ])->label('Enter Travelers name') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'email')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Email',
        ])->label('Enter Email') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'phone')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter phone',
        ])->label('Enter Phone') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'safari')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Number of Safaris',
        ])->label('Number of Safaris') ?>
    </div>

   

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'travellers')->textInput([
            'maxlength' => true,
            'placeholder' => 'Enter Number of travellers',
        ])->label('Number of Travellers') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'stay_category_id')->dropDownList(GeneralModel::packageoption(), ['prompt' => 'Select'])->label('Accomodation') ?>
    </div>



    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'start_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label('Start date') ?>
    </div>


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'end_date')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label('End date') ?>
    </div>

    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'partner_selling_price')->textInput(['type' => 'date', 'min' => date('Y-m-d')])->label('End date') ?>
    </div>


   


    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'installment')->textInput([
            'maxlength' => true,
            'disabled' => true,
            'placeholder' => 'Enter Number of installment',
        ])->label('Number of Installment') ?>
    </div>




</div>
<div class="row">
    <div class="col-md-12">
        <div class="creat-safri float-start w-auto gap-2">
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-info']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>