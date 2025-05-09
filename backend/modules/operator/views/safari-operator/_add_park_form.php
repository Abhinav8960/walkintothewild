<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Add Park';
$this->params['title'] = $this->title;
?>

<div class="card">

    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'add-park-form']); ?>

        <div class="row">

            <div class="col-md-12">
                <?= $form->field($model, 'parks')->widget(\kartik\select2\Select2::classname(), [
                    'data' => GeneralModel::addparkoption($operator_model->id),
                    'options' => ['placeholder' => 'Select', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Parks') ?>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                </div>
            </div>


        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>