<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['id' => 'url_shortner']); ?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'shortner_url')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Url',
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'code')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Code',
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'alias')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Alias',
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'one_time_valid')->dropDownList([
                    1 => 'Yes',
                    0 => 'No'
                ], [
                    'prompt' => 'Select One-Time Expiry'
                ]) ?>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>