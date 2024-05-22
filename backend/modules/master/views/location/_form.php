<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\location\MasterLocation $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'country_id', ['inputOptions' => ['id' => 'country']])->dropDownList(
            GeneralModel::countryoption(),
            [
                'prompt' => 'Select Country',
                'onchange' => '
                 $.get( "' . Yii::$app->urlManager->createUrl('/dropdown/getstate?country_id=') . '"+$(this).val(), function( data ) {
                     $( "select#state" ).html( data );
                     $("select#city").html("<option value>Select City</option>");
                     })'
            ]
        ); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'state_id', ['inputOptions' => ['id' => 'state']])->dropDownList(
            GeneralModel::getAllState($model->country_id),
            [
                'prompt' => 'Select State',
                'onchange' => '
                $.get( "' . Yii::$app->urlManager->createUrl('/dropdown/getcity?master_state_id=') . '"+$(this).val(), function( data ) {
                    $( "select#city" ).html( data );
                    })'
            ]
        ); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'city_id', ['inputOptions' => ['id' => 'city',]])->dropDownList( 
            GeneralModel::getAllCity($model->state_id),
            ['prompt' => 'Select City']
        )->label('City') ?>
    </div>

    <?php if ($model->location_model->id) { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
        </div>
    <?php } ?>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>