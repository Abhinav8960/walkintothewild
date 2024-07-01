<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\cms\banner\Banner $model */
/** @var yii\widgets\ActiveForm $form */

?>

<?php $form = ActiveForm::begin(['id' => 'update-form']); ?>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'feature_park_title')->textInput()->label('Title'); ?>
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