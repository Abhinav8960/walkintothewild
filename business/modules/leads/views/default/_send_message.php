<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="type_msg">
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['chat/send-message', 'chat' => $chat]),
        'options' => ['class' => 'input_msg_write d-flex', 'style' => 'margin-top:15px;'],
    ]); ?>

    <?= $form->field($chat, 'message')->textInput([
        'class' => 'write_msg form-control',
        'maxlength' => 1000,
        'placeholder' => 'Type a Message',
    ])->label('Type a Message') ?>

    <?= Html::submitButton('<i class="fa fa-paper-plane" aria-hidden="true"></i>', [
        'class' => 'msg_send_btn btn btn-success'
    ]) ?>

    <?php ActiveForm::end(); ?>
</div>