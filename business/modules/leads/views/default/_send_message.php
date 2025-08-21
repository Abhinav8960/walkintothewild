<?php

use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

?>

<div class="col-lg-12">
    <?php $form = ActiveForm::begin([
        'id' => 'chat-form',
    ]); ?>

    <div class="typeingField w-100 position-relative">
        <?= $form->field($model, 'message')->textarea([
            'placeholder' => 'Type message...',
            'id' => 'chat-message',
            'class' => 'w-100',
            'autocomplete' => 'off',
            'rows' => 1,
            'style' => 'overflow:hidden;resize:none;'
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

<?php

$this->registerJs(<<<JS
$('#chat-message')
  .on('keydown', function(e) {
      if (e.key === 'Enter' && !e.shiftKey) {
          e.preventDefault();
          $('#chat-form').submit();
      }
  })
  .on('input', function() {
      this.style.height = 'auto';
      let lineHeight = parseInt($(this).css('line-height')) || 20;
      let maxAllowed = lineHeight * 5;

      if (this.scrollHeight > maxAllowed) {
          this.style.height = maxAllowed + 'px';
          this.style.overflowY = 'auto';
      } else {
          this.style.height = this.scrollHeight + 'px';
          this.style.overflowY = 'hidden';
      }
  });
JS);
?>

<style>
    .typeingField textarea {
        padding: 20px;
        outline: none;
        border: none;
        border-radius: 50px;
    }
</style>
