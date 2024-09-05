<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin([
    'id' => 'reply-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'enableClientScript' => true,
    // 'action' => $model->action_url,
    'validationUrl' => $replymodel->action_validate_url,
]); ?>
<div class="mb-3">
    <?= $form->field($replymodel, 'parent_id')->hiddenInput()->label(false) ?>
</div>
<div class="mb-3">
    <?= $form->field($replymodel, 'comment')->textarea(['rows' => '5', 'placeholder' => 'Write a reply...', 'class' => 'form-control w-100'])->label(false) ?>
</div>
<div class="btn-wrapper">
    <?= Html::submitButton('Submit', ['class' => 'post-comment']) ?>
</div>
<?php ActiveForm::end(); ?>