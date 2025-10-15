<?php


use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>
<?= $this->render('_userdetail', ['model' => $lead_model]) ?>

<div class="table-wrapper remove-css mb-4">


    <?php $form = ActiveForm::begin([
        'id' => 'quotation-form',
        'method' => 'POST',
        // 'enableAjaxValidation' => true,
        // 'enableClientValidation' => false,
        // 'enableClientScript' => true,
        // 'action' => $model->action_url,
        // 'validationUrl' => $action_validate_url,
        'fieldConfig' => [
            'template' => '<div class="form-group">{label}{input}{hint}{error}</div>',
        ],

    ]); ?>
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <?= $form->field($model, 'support_user_note')->textarea([
                // 'maxlength' => true,
                'row' => 5,
                'placeholder' => 'Enter Additional Notes',
            ])->label('Additional Notes') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="float-start santBtn w-auto gap-2">
                <?= Html::submitButton('Submit') ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .santBtn button {
        border: 1px solid #000;
        padding: 8px 20px;
        background-color: #09422d;
        border-radius: 4px;
        color: #fff;
    }
</style>