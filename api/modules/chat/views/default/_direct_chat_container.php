<div class="chat-message-container" id="chat-message-container">
    <?php
    if ($chat && $chat_message_list = $chat->getChatmessages()->where(['status' => 1])->orderby(['created_at' => SORT_ASC])->all()) {
        foreach ($chat_message_list as $chat_message) { ?>
            <div class="chat-message pt-3">
                <?php if ($login_user && $chat_message->created_by == $login_user->id) { ?>
                    <div class="reciverchta">
                        <div class="text-right text-justify message_body_right position-relative">
                            <?= $chat_message->message ?>
                        </div>
                    </div>
                <?php  } else { ?>
                    <div class="text-justify message_body_left position-relative">
                        <?= $chat_message->message ?>
                    </div>
                <?php } ?>
            </div>
    <?php  }
    } ?>
</div>

<div class="chat-send-message-form pt-3">
    <form id="chatmessageform" method="post">
        <div class="lead emoji-picker-container w-100 submit_on_enter">
            <div class="character-count">
                <span id="char-count">500</span> characters remaining
            </div>

            <textarea type="text" rows="1" name="Chat[message]" class="form-control chat-message-input submit_on_enter" placeholder="Type a Message" id="chat-message" autocomplete="off" data-emojiable="true" value="<?= Yii::$app->request->post('Chat') !== null && isset(Yii::$app->request->post('Chat')['message']) ? Yii::$app->request->post('Chat')['message'] : '' ?>" maxlength="500"></textarea>

            <div class="sendMassege">
                <div class="chat-sendbtn">
                    <i class="fa fa-paper-plane " id="message_sent_btn"></i>
                </div>

            </div>
        </div>
        <div class="d-flex align-items-center">
        </div>

        <input type="hidden" name="Chat[user_handle]" value="<?= $individual_user->user_handle ?>">

        <input type="hidden" name="Chat[chat_id]" value="<?= $chat_id ?>">

        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

    </form>

</div>