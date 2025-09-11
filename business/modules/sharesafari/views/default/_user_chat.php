<?= $this->render('_chat', ['chat' => $chat_model]) ?>
<div class="row">
    <?= $this->render('_send_message', ['model' => $chat_message_model]) ?>
</div>