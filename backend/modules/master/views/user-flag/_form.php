<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\userflag\MasterUserFlag $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(); ?>
<h5>User Flag</h5>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'user_flag')->textInput(['maxlength' => true, 'placeholder' => 'Enter Reason']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Enter Description as Tool tips']) ?>
    </div>

</div>





<?php if ($model->user_flag_model->id) { ?>
    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList($model->status_option, ['prompt' => 'Select Status']) ?>
    </div>
<?php } ?>



<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>