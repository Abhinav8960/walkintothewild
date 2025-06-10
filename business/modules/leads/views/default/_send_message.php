<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="chat-send-message-form pt-3">
    <form id="chatmessageform" method="post">
        <div class="lead emoji-picker-container w-100 submit_on_enter">
            <textarea type="text" rows="1" name="Chat[message]" class="form-control chat-message-input submit_on_enter" placeholder="Type a Message" id="chat-message" autocomplete="off" data-emojiable="true" value="<?= Yii::$app->request->post('Chat') !== null && isset(Yii::$app->request->post('Chat')['message']) ? Yii::$app->request->post('Chat')['message'] : '' ?>" maxlength="500"></textarea>
            <div class="sendMassege">
                <div class="chat-sendbtn">
                    <i class="fa fa-paper-plane " id="message_sent_btn"></i>
                </div>

            </div>
        </div>
        <div class="d-flex align-items-center">
        </div>
    </form>
</div>