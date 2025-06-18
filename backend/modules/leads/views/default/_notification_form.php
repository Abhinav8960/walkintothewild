<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>
<?php $form = ActiveForm::begin(['id' => 'send-notification-form']); ?>
<div class="row">
    <div class="form-group">
        <input type="text" name="message" class="form-control" placeholder="Type your message">
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Send', ['class' => 'btn btn-orange text-white']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>