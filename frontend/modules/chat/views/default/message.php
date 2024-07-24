<?php

use yii\helpers\Url;
use yii\grid\GridView;
use common\models\chat\Chat;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = $individual_user->name . ' | Chat';

?>

<div class="container-fluid mt-2 mb-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <h5><?= $this->title ?></h5>
        </div>
        <div class="col-md-12">
            <?= $this->render('@frontend/modules/chat/views/default/_sidebar', ['active' => 'message']); ?>
        </div>
        <div class="col-md-12">
            <div class="card chat">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 chat-card-sidebar">
                            <div class="chat-search-user">
                                <input type="search" name="search_user" class="form-control" placeholder="Search">
                            </div>
                            <?php if ($active_chat_list) {
                                foreach ($active_chat_list as $active_chat) {
                                    if ($active_chat->user_id == $login_user->id) {
                                        $user = $active_chat->recipient;
                                    } else {
                                        $user = $active_chat->user;
                                    }
                            ?>
                                    <a href="<?= Url::toRoute(['/chat/default/message', 'user_handle' => $user->user_handle]) ?>" class="chat-link">
                                        <div class="chat-sidebar-user-card <?= $individual_user->id == $user->id ? 'selected_chat' : '' ?>">
                                            <div class="d-flex chat-user_message">
                                                <img src="<?= $user->avatar <> '' ? $user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle user-icon">
                                                <div class="chat-user_name">
                                                    <h6><?= $user->name ?></h6>
                                                    <p><?= $active_chat->last_message ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                            <?php }
                            } ?>
                        </div>
                        <div class="col-9">
                            <div class="d-flex chat-message-header justify-content-between">
                                <div class="chat-profile">
                                    <img src="<?= $individual_user->avatar <> '' ? $individual_user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle user-icon">
                                    <?= $individual_user->name ?>
                                </div>
                                <div class="chat-action-in-right">
                                    <i class="fa fa-search"></i>
                                    &nbsp;
                                    <i class="fa fa-ellipsis-v"></i>
                                </div>
                            </div>

                            <div class="chat-message-container">
                                <?php
                                $chat = Chat::find()->where(['user_id' => [$login_user->id, $individual_user->id], 'recipient_user_id' => [$login_user->id, $individual_user->id], 'status' => 1])->limit(1)->one();
                                if ($chat && $chat_message_list = $chat->getChatmessages()->where(['status' => 1])->orderby(['created_at' => SORT_ASC])->all()) {
                                    foreach ($chat_message_list as $chat_message) { ?>
                                        <div class="chat-message">
                                            <?php if ($chat_message->created_by == $login_user->id) { ?>
                                                <div class="text-right text-end message_body_right">
                                                    <?= $chat_message->message ?>
                                                </div>
                                            <?php  } else { ?>
                                                <div class="text-left message_body_left">
                                                    <?= $chat_message->message ?>
                                                </div>
                                            <?php } ?>
                                        </div>

                                <?php  }
                                }
                                ?>
                            </div>

                            <div class="chat-send-message-form">
                                <form id="chatmessageform" method="post">
                                    <div class="d-flex">
                                        <input type="text" name="Chat[message]" class="form-control chat-message-input submit_on_enter" placeholder="Type a Message" autofocus id="chat-message">
                                        <i class="fa fa-paper-plane chat-sendbtn" id="message_sent_btn"></i>
                                    </div>
                                    <input type="hidden" name="Chat[user_handle]" value="<?= $individual_user->user_handle ?>">
                                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$script = <<< JS

function sendmessage(){
    $.ajax({
        type: 'POST',
        url: '/chat/default/sendmessage',
        data:$("#chatmessageform").serialize(),
        success:function(data){
            console.log(data);
            $('#chat-message').val('');
            // window.location.href = data;
            location.reload();
        },
        dataType:'html'
    });
    
}

$('.submit_on_enter').keydown(function(event) {
    if (event.keyCode == 13) {
        sendmessage();
    }
  });

$('#message_sent_btn').click(function(){
    sendmessage();
});

JS;
$this->registerJs($script);
?>