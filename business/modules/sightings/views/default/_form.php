<?php

use common\models\GeneralModel;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'id' => 'sighting-form',
    'method' => 'POST',
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],
]); ?>

<div class="row mb-3">
    <div class="col-md-6 col-lg-3">
        <?= $form->field($model, 'file')->fileInput()->label('Sighting') ?>
    </div>

    <?php if ($model->sighting_model->filepath){?>
        <div class="col-md-1 d-flex align-items-center">
            <img src="<?= Yii::$app->params['s3_endpoint'] . '/' . $model->sighting_model->thumbnail ?>" width="75" height="75" alt="Thumbnail">
        </div>
    <?php } ?>
</div>

<div class="row mb-3">
    <div class="col-md-3">
        <?= $form->field($model, 'location')->dropDownList(
            GeneralModel::operatorpark($model->safari_operator_id),
            ['prompt' => 'Select Park Location']
        ) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'master_animal_id')->dropDownList(
            GeneralModel::animalfilteroption(),
            ['prompt' => 'Select Animal']
        ) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'post_datetime')->input('date', [
            'min' => date('Y-m-d'),
            'max' => date('Y-m-d', strtotime('+1 year'))
        ])->label('Post Date') ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'safari_session_id')->dropDownList(
            GeneralModel::safarisession(),
            ['prompt' => 'Select Safari Session']
        ) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'zone_id')->dropDownList(
            GeneralModel::safarizone(),
            ['prompt' => 'Select Zone']
        ) ?>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12">
        <?= $form->field($model, 'description')->textarea()->label('Description') ?>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="creat-safri d-flex gap-2">
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton('Submit', ['class' => 'btn btn-info']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
