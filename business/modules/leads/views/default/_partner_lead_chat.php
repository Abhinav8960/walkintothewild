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
                                <div class="received_msg">
                                    <div class="received_withd_msg">
                                        <p><?= $chat_message->message ?></p>
                                        <span class="time_date"><?= date('Y-m-d H:i:s', $chat_message->created_at) ?></span>
                                    </div>
                                </div>
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
</style>