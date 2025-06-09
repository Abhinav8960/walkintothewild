<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;


?>
<?php $form = ActiveForm::begin(['id' => 'add-form']); ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 select_width">
                <?= $form->field($model, 'park_stay_categories')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::staycategoryoption(),
                    'options' => ['placeholder' => 'Select Categories', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Accomodation') ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>