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

        </div>
    </div>
</div>



<style>
    .inbox_msg {
        border: 1px solid #c4c4c4;
        clear: both;
        overflow: hidden;
    }

    .incoming_msg {

        margin-top: 10px;
    }

    .incoming_msg_img {
        float: right;
        width: 3%;
        position: relative;
        right: 65px;
        bottom: 10px;
    }

    .received_msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
    }

    .received_withd_msg p {

        background: #ebebeb none repeat scroll 0 0;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }

    .gallery-background {

        background: #ebebeb none repeat scroll 0 0;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }

    .time_date {
        color: #747474;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
    }

    .received_withd_msg {
        float: right;
        width: 57%;
    }

    .mesgs {
        float: left;
        padding: 30px 15px 0 25px;
        width: 100%;
    }

    .sent_msg p {
        background: #237729 !important;
        border-radius: 3px;
        font-size: 14px;
        margin: 0;
        color: #fff;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }

    .outgoing_msg {
        overflow: hidden;
        margin: 26px 0 26px;
    }

    .sent_msg {
        float: left;
        width: 46%;
    }

    .messaging {
        padding: 0 0 50px 0;
    }

    .msg_history {
        height: 516px;
        overflow-y: auto;
    }

    .input_msg_write {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .write_msg {
        border: none;
        padding: 10px;
        font-size: 15px;
        border-radius: 5px;
        width: 85%;
        margin-right: 10px;
        background: #f1f1f1;
    }

    .msg_send_btn {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
    }

    .gallery-images {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
        margin: 10px;
    }

    .gallery-image {
        text-align: center;
        margin: 5px;
    }

    .gallery-image img {
        width: 100%;
        height: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .image-caption {
        /* margin-top: 5px; */
        font-size: 14px;
        color: #666;
    }

    .gallery-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }
</style>