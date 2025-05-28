<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\rest\DeleteAction;

$this->title = 'Create Gallery';
$this->params['title'] = $this->title;
?>

<div class="card mt-2">

    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['id' => 'create-gallery']]); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'title')->textInput(['placeholder' => 'Enter Gallery Title']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'safari_park_id')->dropDownList(GeneralModel::operatorpark($safari_operator_model->id), ['prompt' => 'Select Status']) ?>
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