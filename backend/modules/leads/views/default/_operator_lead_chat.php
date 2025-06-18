<?php

use common\models\chat\ChatMessage;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?= $this->render('view', ['model' => $model, 'quotations' => $quotations, 'safari_operator_id' => $safari_operator_model->id]) ?>

<div class="messaging">
    <?= Html::button('Send Notification', ['value' => Url::toRoute(['send-notification', 'chat_hash' => $chat->chat_hash]), 'class' => 'btn btn-info pop-up mb-2']) ?>
    <div class="inbox_msg">
        <div class="mesgs">
            <div class="msg_history">
                <?php if ($chat) {
                    if ($chats = $chat->getChatmessages()->orderby(['id' => SORT_ASC])->all()) {
                        foreach ($chats as $chat_message) {
                            if ($chat_message->created_by == $safari_operator_model->user_id) {
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
                } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="notificationAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Form
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
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


<?php
$script = <<< JS
    $('.pop-up').on('click', function () {
        $('#notificationAction').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});


JS;
$this->registerJs($script);

?>