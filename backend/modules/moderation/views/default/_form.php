<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['id' => 'moderation']); ?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'type')->dropDownList(
                    [
                        1 => 'Text',
                        2 => 'Video',
                        3 => 'Image'
                    ],
                    ['prompt' => 'Select Option']
                ); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'text')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'Enter Text',
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