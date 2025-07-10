<?php

use common\models\GeneralModel;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'park_id')->dropDownList(GeneralModel::operatorsafariparkoption($safari_operator->id), ['prompt' => 'Select Park'])->label('Park') ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'question')->textarea(['rows' => '4', 'placeholder' => 'Question'])->label('Question') ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'answer')->textarea(['rows' => '4', 'placeholder' => 'Answer'])->label('Answer') ?>
            </div>
            <?php
            if (!empty($model->faqs_model->id)) { ?>
                <div class="col-md-3">
                    <?= $form->field($model, 'status')->dropDownList(GeneralModel::newstatusoption(), ['prompt' => '--Select Status--']) ?>
                </div>
            <?php } ?>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'button-created create']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>