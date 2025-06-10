<?php

use common\models\chat\ChatMessage;

?>

<div class="messaging">
    <div class="inbox_msg">
        <div class="mesgs">
            <div class="msg_history">
                <?php

                if ($chats = $chat->getChatmessages()->orderby(['id' => SORT_ASC])->all()) {
                    foreach ($chats as $chat_message) {
                        if (Yii::$app->user->identity && $chat_message->created_by == Yii::$app->user->identity->id) {
                ?>

                            <div class="incoming_msg">
                                <?php if ($chat_message->message != 'Gallery') { ?>
                                    <div class="received_msg">
                                        <div class="received_withd_msg">
                                            <p><?= $chat_message->message ?></p>
                                            <span class="time_date"><?= date('Y-m-d H:i:s', $chat_message->created_at) ?></span>
                                        </div>
                                    </div>
                                    <?php } else {
                                    $gallery_data = json_decode($chat_message->gallery, true);
                                    if ($gallery_data) { ?>
                                        <div class="received_msg">
                                            <div class="received_withd_msg">
                                                <div class="gallery-background">
                                                    <h3 class="gallery-title"><?= isset($gallery_data['title']) ? $gallery_data['title'] : '' ?></h3>
                                                    <div class="gallery-images mt-4">
                                                        <?php if ($gallery_data['images']) {
                                                            foreach ($gallery_data['images'] as $image) {  ?>
                                                                <div class="gallery-image">
                                                                    <img src="<?= isset($image['gallery_image_path']) ? $image['gallery_image_path'] : '' ?>" alt="<?= isset($image['title']) ? $image['title'] : ''  ?>" title="<?= isset($image['caption']) ? $image['caption'] : '' ?>">
                                                                    <div class="image-caption"><?= isset($image['caption']) ? $image['caption'] : '' ?></div>
                                                                </div>
                                                        <?php }
                                                        } ?>
                                                    </div>
                                                </div>
                                                <span class="time_date"><?= date('Y-m-d H:i:s', $chat_message->created_at) ?></span>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                        <?php } else { ?>
                            <div class="outgoing_msg">
                                <div class="sent_msg">
                                    <p><?= $chat_message->message ?></p>
                                    <span class="time_date"><?= date('Y-m-d H:i:s', $chat_message->created_at) ?></span>
                                </div>
                            </div>
                <?php }
                    }
                }

                ?>
            </div>

            <?= $this->render('_send_message', ['chat' => $chat]) ?>

        </div>
    </div>
</div>

<?php
$script = <<< JS
$(document).ready(function() {

    function sendmessage(){
        $.ajax({
            type: 'POST',
            url: '/chat/default/sendmessage',
            data:$("#chatmessageform").serialize(),
            success:function(data){
                $('#chat-message').val('');
                location.reload();
            },
            dataType:'html'
        });   
    }

    $('#message_sent_btn').click(function(){
        sendmessage();
    });

    $('#chat-message').keydown(function(e) {
        if (e.keyCode === 13) { 
            if (e.shiftKey) {
                return ;
            } else {
                e.preventDefault(); 
                sendmessage();
            }
        }
    });
});
JS;
$this->registerJs($script);
?>