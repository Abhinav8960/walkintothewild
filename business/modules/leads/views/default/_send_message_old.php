<?php

use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

?>

<div class="col-lg-12">
    <?php $form = ActiveForm::begin([
        'id' => 'chat-form',
    ]); ?>

    <div class="typeingField w-100 position-relative">
        <?= $form->field($model, 'message')->textInput([
            'placeholder' => 'Type message...',
            'id' => 'chat-message',
            'class' => 'w-100',
            'autocomplete' => 'off',
        ])->label(false) ?>

        <?= Html::submitButton(
            Html::img($this->params['baseurl'] . '/images/chatsent.png', [
                'alt' => 'Send',
            ]),
            [
                'class' => 'sentimg',
            ]
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
