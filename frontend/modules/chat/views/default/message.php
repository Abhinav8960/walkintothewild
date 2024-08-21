<?php

use yii\helpers\Url;
use yii\grid\GridView;
use common\models\chat\Chat;
use yii\widgets\Pjax;

\frontend\assets\EmojiAsset::register($this);
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Message | ' . $individual_user->name;

$emoji_base_url =  $this->assetManager->getBundle('\frontend\assets\EmojiAsset')->baseUrl;
?>

<div class="container mt-5 margin_bottomfooter pt-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <h6 class="fs-3 fw-bold"><?= $this->title ?></h6>
        </div>
        <div class="col-md-12">
            <?= $this->render('@frontend/modules/chat/views/default/_sidebar', ['active' => 'message']); ?>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3 ">
                    <div class="chat-card-sidebar card">
                        <div class="card-body">

                            <?php

                            Pjax::begin([
                                'id' => 'grid-data',
                                'enablePushState' => FALSE,
                                'enableReplaceState' => FALSE,
                                'timeout' => false,
                            ]);
                            ?>
                            <div class="chat-search-user mb-2 position-relative">
                                <?= $this->render('_search', ['searchModel' => $searchModel, 'login_user' => $login_user, 'autofocus' => $searchModel->name ? true : false]) ?>
                                <div class="secrchIcons">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </div>
                            <div class="chat-cardlist">
                                <?php if ($searchModel->name == '' && $active_chat_list) {
                                    foreach ($active_chat_list as $active_chat) {
                                        if ($active_chat->user_id == $login_user->id) {
                                            $user = $active_chat->recipient;
                                        } else {
                                            $user = $active_chat->user;
                                        }
                                ?>
                                        <a href="<?= Url::toRoute(['/chat/default/message', 'user_handle' => $user->user_handle]) ?>" class="chat-link" data-pjax="0">
                                            <div class="chat-sidebar-user-card <?= $individual_user->id == $user->id ? 'selected_chat' : '' ?>">
                                                <div class="d-flex chat-user_message">
                                                    <img src="<?= $user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                                    <div class="chat-user_name">
                                                        <h6><?= $user->name ?></h6>
                                                        <p class="mb-0 lastmassge"><?= $active_chat->last_message ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                <?php }
                                } ?>
                                <?php
                                if ($searchModel->name) {
                                    echo  $this->render('_default_userlist', ['dataProvider' => $dataProvider]);
                                }
                                ?>
                            </div>



                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <?php
                    Pjax::begin([
                        'id' => 'grid-data-chat',
                        'enablePushState' => FALSE,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]);
                    ?>
                    <div class="chat_box  card  h-100">
                        <div class="card-body">
                            <div class="d-flex chat-message-header justify-content-between">
                                <div class="chat-profile">
                                    <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $individual_user->user_handle]) ?>">
                                        <img src="<?= $individual_user->profileimage ? $individual_user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                    </a>
                                    <?= $individual_user->name ?>
                                </div>
                                <!-- <div class="chat-action-in-right">
                                    <i class="fa fa-search"></i>
                                    &nbsp;
                                    <i class="fa fa-ellipsis-v"></i>
                                </div> -->
                            </div>

                            <div class="chat-message-container" id="chat-message-container">
                                <?php
                                $chat = Chat::find()->where(['user_id' => [$login_user->id, $individual_user->id], 'recipient_user_id' => [$login_user->id, $individual_user->id], 'status' => 1])->limit(1)->one();
                                if ($chat && $chat_message_list = $chat->getChatmessages()->where(['status' => 1])->orderby(['created_at' => SORT_ASC])->all()) {
                                    foreach ($chat_message_list as $chat_message) { ?>
                                        <div class="chat-message pt-3">
                                            <?php if ($chat_message->created_by == $login_user->id) { ?>
                                                <div class="reciverchta">
                                                    <div class="text-right text-end message_body_right position-relative">
                                                        <?= $chat_message->message ?>
                                                    </div>

                                                </div>
                                            <?php  } else { ?>
                                                <div class="text-left message_body_left position-relative">
                                                    <?= $chat_message->message ?>
                                                </div>
                                            <?php } ?>
                                        </div>

                                <?php  }
                                }
                                ?>
                            </div>

                            <div class="chat-send-message-form pt-3">
                                <form id="chatmessageform" method="post">
                                    <div class="d-flex align-items-center">
                                        <div class="lead emoji-picker-container w-100 submit_on_enter">
                                            <textarea type="text" rows="1" name="Chat[message]" class="form-control chat-message-input submit_on_enter" placeholder="Type a Message" autofocus id="chat-message" autocomplete="off" data-emojiable="true" value="<?= Yii::$app->request->post('Chat') !== null && isset(Yii::$app->request->post('Chat')['message']) ? Yii::$app->request->post('Chat')['message'] : '' ?>"></textarea>
                                        </div>
                                        <i class="fa fa-paper-plane chat-sendbtn" id="message_sent_btn"></i>
                                    </div>
                                    <input type="hidden" name="Chat[user_handle]" value="<?= $individual_user->user_handle ?>">
                                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
$(document).ready(function() {
    // $(function() {
    //     window.emojiPicker = new EmojiPicker({
    //         emojiable_selector: '[data-emojiable=true]',
    //         assetsPath: '{$emoji_base_url}/lib/img/',
    //         popupButtonClasses: 'fa-solid fa-face-smile'
    //     });
    //     window.emojiPicker.discover();
    // });

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

    function scrollToBottom() {
        const container = document.getElementById('chat-message-container');
        container.scrollTop = container.scrollHeight;
    }
    scrollToBottom();
});
JS;
$this->registerJs($script);
?>