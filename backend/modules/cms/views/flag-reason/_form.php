<?php

use common\models\GeneralModel;

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\cms\flagreason\FlagReason $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['id' => 'flag-reason']); ?>
<h5>Basic Detail</h5>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'reason')->textInput(['maxlength' => true, 'placeholder' => 'Enter Flag Reason']) ?>
    </div>
    <?php if ($model->reason_model->id) { ?>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
        </div>
    <?php } ?>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>