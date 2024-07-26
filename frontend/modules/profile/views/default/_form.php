<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<div class="col-md-12">

    <div class="card">
        <div class="card-body">
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
                    <?= $form->field($model, 'park_id')->dropDownList(
                        GeneralModel::safariparkoption(),
                        [
                            'prompt' => 'Select Park',
                        ]
                    ) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'file')->fileInput()->label('Photo (JPEG /JPG or PNG / 250 KB)') ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'description')->textarea(['rows' => '6', 'placeholder' => 'Description Detail '])->label('Description') ?>

                </div>
            </div>
            <div class="row">
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
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>