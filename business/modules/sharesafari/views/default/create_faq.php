<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;


?>
<?php $form = ActiveForm::begin([
    'id' => 'create-faq-form',
    'method' => 'POST',
    'fieldConfig' => [
        'template' => '<div class="form-group">{label}{input}{error}</div>',
    ],

]); ?>
<div class="row p-4">
    <div class="col-md-12">
        <?= $form->field($model, 'question')->textInput(['rows' => '2', 'placeholder' => 'Question'])->label('Question')->label(false) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'answer')->textInput(['rows' => '2', 'placeholder' => 'Answer'])->label('Answer')->label(false) ?>
    </div>
    <?php
    if (!empty($model->share_safari_faq_model->id)) { ?>
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList(GeneralModel::newstatusoption(), ['prompt' => '--Select Status--'])->label(false) ?>
        </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-md-12">
    <div class="creat-safri d-flex justify-content-end ">
                    <?= Html::submitButton('Create ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
                </div>
            </div>
    </div>
</div>

<?php ActiveForm::end(); ?>