<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['id' => 'action-form']); ?>
<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'status')->dropDownList(['3' => 'Ignore', '2' => 'Delete', '20' => 'Blocked User'], ['prompt' => 'Select option']) ?>
    </div>

    <div class="col-md-12">
        <?= $form->field($model, 'reason')->textInput() ?>
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

<?php ActiveForm::end(); ?>