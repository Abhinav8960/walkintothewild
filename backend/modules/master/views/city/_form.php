<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */

if (!isset($model->country_id)) {
    $model->country_id = 1;
}

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'country_id', ['inputOptions' => ['id' => 'country']])->dropDownList(
            GeneralModel::countryoption(),
            [
                'prompt' => 'Select Country',
                'onchange' => '
                $.get( "' . Yii::$app->urlManager->createUrl('/dropdown/getstate?country_id=') . '"+$(this).val(), function( data ) {
                    $( "select#state" ).html( data );
                    })'

            ]
        ); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'state_id', ['inputOptions' => ['id' => 'state',]])->dropDownList(
            GeneralModel::getAllState($model->country_id),
            [
                'prompt' => 'Select State'
            ]
        ); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'city_name')->textInput(['maxlength' => true, 'placeholder' => 'Enter Name']) ?>
    </div>


    <?php if ($model->city_model->id) { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
        </div>
    <?php } ?>




    <hr>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>