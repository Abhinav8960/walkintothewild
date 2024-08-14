<?php

use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<div class="col-md-12">

    <?php $form = ActiveForm::begin([
        'id' => 'experience-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'enableClientScript' => true,
        'action' => $model->action_url,
        'validationUrl' => $model->action_validate_url,
    ]); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'parks', [
                'labelOptions' => ['class' => 'Modal_label']
            ])->widget(Select2::classname(), [
                'data' => GeneralModel::experiencesafariparkoption($user->id),
                'options' => ['placeholder' => 'Select Park', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>
    </div>
    <div class="row py-2">
        <div class="col-lg-12 ">
            <div class="creat-safri d-flex justify-content-end">
                <button class="cancel_btn" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                <?php if (isset($model->user_experience_model->id)) { ?>
                    <?= Html::submitButton('Update ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
                <?php } else {  ?>
                    <?= Html::submitButton('Create ', ['class' => 'safari_create font_set w-auto ms-2']) ?>
                <?php } ?>

            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>