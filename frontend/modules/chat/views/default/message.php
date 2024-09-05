<?php

use yii\helpers\Url;
use yii\grid\GridView;
use common\models\chat\Chat;
use yii\widgets\Pjax;

\frontend\assets\EmojiAsset::register($this);
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Message | ' . $individual_user->name;

$emoji_base_url =  $this->assetManager->getBundle('\frontend\assets\EmojiAsset')->baseUrl; ?>

<div class="container-lg mt-5 margin_bottomfooter pt-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <h6 class="fs-3 fw-bold"><?= $this->title ?></h6>
        </div>
        <div class="col-md-12">
            <?= $this->render('@frontend/modules/chat/views/default/_sidebar', ['active' => 'message']); ?>
        </div>
        <div class="col-md-12">
            <div class="row  itenary_tabs">
                <div class="col-md-3 mb-3">
                    <div class="chat-card-sidebar card">
                        <div class="card-body">
                            <?php Pjax::begin([
                                'id' => 'grid-data',
                                'enablePushState' => FALSE,
                                'enableReplaceState' => FALSE,
                                'timeout' => false,
                            ]); ?>
                            <div class="tablmassage safartabs">
                                <ul class="nav  nav-tabs " id="pills-tab" role="tablist" style="justify-content:between">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php if (empty($chat_id)) {
                                                                    echo 'active';
                                                                } ?> 
                                                                chatFonts" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Direct Messages</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php if (!empty($chat_id)) {
                                                                    echo 'active';
                                                                } ?>  chatFonts" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Quote Request</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                <!-- direct msg user lists -->
                                <div id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" class="tab-pane fade <?php if (empty($chat_id)) {
                                                                                                                                echo 'show active mt-4';
                                                                                                                            } ?>">
                                    <div class="chat-search-user mb-3 position-relative">
                                        <?= $this->render('_search', ['searchModel' => $searchModel, 'login_user' => $login_user, 'autofocus' => false, 'chat_type' => 1]) ?>
                                        <div class="secrchIcons">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </div>
                                    </div>
                                    <div class="chat-cardlist pt-3">
                                        <?php if ($searchModel->name == '' && $active_chat_list) {
                                            foreach ($active_chat_list as $active_chat) {
                                                if ($active_chat->user_id == $login_user->id) {
                                                    $user = $active_chat->recipient;
                                                } else {
                                                    $user = $active_chat->user;
                                                } ?>

                                                <a href="<?= Url::toRoute(['/chat/default/message', 'user_handle' => $user->user_handle]) ?>" class="chat-link mb-3 d-block" data-pjax="0">
                                                    <div class="chat-sidebar-user-card <?= $individual_user->id == $user->id ? 'selected_chat' : '' ?>">
                                                        <div class="d-flex chat-user_message">
                                                            <img src="<?= $user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                                            <div class="chat-user_name">
                                                                <h6 class="fs-6 mb-0" style="color: #4c4c4c;"><?= $user->name ?></h6>
                                                                <p class="mb-0 lastmassge" style="color:#4c4c4c;"><?= $active_chat->last_message ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                        <?php }
                                        }

                                        if ($searchModel->name) {
                                            echo  $this->render('_default_userlist', ['dataProvider' => $dataProvider]);
                                        }
                                        ?>
                                    </div>
                                </div>

                                <!-- quote msg user lists -->
                                <div id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" class="tab-pane fade 
                                <?php if (!empty($chat_id)) {
                                    echo 'show active mt-4';
                                } ?>">

                                    <!-- start quote user search here -->
                                    <!-- end quote user search here-->
                                    <div class="chat-cardlist pt-3">
                                        <?php if ($searchModel->name == '' && $active_quote_chat_list) {
                                            foreach ($active_quote_chat_list as $active_chat) {
                                                if ($active_chat->user_id == $login_user->id) {
                                                    $user = $active_chat->recipient;
                                                } else {
                                                    $user = $active_chat->user;
                                                } ?>

                                                <a href="<?= Url::toRoute(['/chat/message/' . $user->user_handle . "/" . base64_encode($active_chat->id)]) ?>" class="chat-link mb-3 d-block" data-pjax="0">

                                                    <div class="chat-sidebar-user-card <?= $individual_user->id == $user->id ? 'selected_chat' : '' ?>">
                                                        <div class="d-flex chat-user_message">
                                                            <?php if ($active_chat->recipient_user_id == $user->id) { ?>
                                                                <h6 class="fs-6 mb-0" style="color: #4c4c4c;">
                                                                    <?php
                                                                    if (isset($user->operator)) { ?>
                                                                        <img src="<?= $user->operator->logo ? $user->operator->imagepath : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';" style="background-color:#000;">
                                                                    <?php } else { ?>
                                                                        <img src="<?= $user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';" style="background-color:#000;">
                                                                    <?php }  ?>
                                                                </h6>
                                                            <?php } else { ?>
                                                                <img src="<?= $user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';" style="background-color:#000;">
                                                            <?php } ?>

                                                            <div class="chat-user_name">
                                                                <?php if ($active_chat->recipient_user_id == $user->id) { ?>
                                                                    <h6 class="fs-6 mb-0" style="color: #4c4c4c;">
                                                                        <?php if (isset($user->operator)) {
                                                                            echo $user->operator->business_name;
                                                                        } else {
                                                                            echo $user->name;
                                                                        }  ?>
                                                                    </h6>
                                                                <?php } else { ?>
                                                                    <h6 class="fs-6 mb-0" style="color: #4c4c4c;"><?= $user->name ?></h6>
                                                                <?php } ?>
                                                                <p class="mb-0 lastmassge" style="color:#4c4c4c;"><?= $active_chat->last_message ?></p>
                                                                <p class="mb-0 lastmassge" style="color:#4c4c4c;"><b>Last Msg:</b> <?= date('M j, Y H:i', $active_chat->last_message_at) ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                        <?php }
                                        }

                                        if ($searchModel->name) {
                                            echo $this->render('_default_userlist', ['dataProvider' => $dataProvider]);
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <?php Pjax::begin([
                        'id' => 'grid-data-chat',
                        'enablePushState' => FALSE,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]); ?>
                    <div class="chat_box  card  h-100 p-3">
                        <div class="card-body">
                            <div class="d-flex chat-message-header pb-4 justify-content-between">
                                <div class="chat-profile">
                                    <?php if ($active_chat->recipient_user_id == $individual_user->id) { ?>
                                        <a href="<?= Url::toRoute(["/operator/" . $individual_user->operator->slug . "/sharedsafari"]) ?>">
                                            <?php if (isset($individual_user->operator)) { ?>
                                                <img src="<?= $individual_user->operator->logo ? $individual_user->operator->imagepath : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                                <?= $individual_user->operator->business_name ?>
                                            <?php } else { ?>
                                                <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $individual_user->user_handle]) ?>">
                                                    <img src="<?= $individual_user->profileimage ? $individual_user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                                </a>
                                                <?= $individual_user->name ?>
                                            <?php } ?>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $individual_user->user_handle]) ?>">
                                            <img src="<?= $individual_user->profileimage ? $individual_user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                        </a>
                                        <?= $individual_user->name ?>
                                    <?php } ?>
                                </div>
                                <!-- <div class="chat-action-in-right">
                                    <i class="fa fa-search"></i>
                                    &nbsp;
                                    <i class="fa fa-ellipsis-v"></i>
                                </div> -->
                            </div>

                            <div class="chat-message-container" id="chat-message-container">
                                <?php $quote_chat_id = 0;
                                $chat = Chat::find()->where(['id' => $chat_id])->limit(1)->one();
                                if (empty($chat)) {
                                    $chat = Chat::find()->where(['user_id' => [$login_user->id, $individual_user->id], 'recipient_user_id' => [$login_user->id, $individual_user->id], 'status' => 1])->andWhere(['chat_type' => 1])->limit(1)->one();
                                }
                                if ($chat && $chat_message_list = $chat->getChatmessages()->where(['status' => 1])->orderby(['created_at' => SORT_ASC])->all()) {
                                    foreach ($chat_message_list as $chat_message) { ?>
                                        <div class="chat-message pt-3">
                                            <?php if ($chat_message->created_by == $login_user->id) { ?>
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
                // console.log(data);
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

    const maxLength = 500;
    $('#chat-message').on('input', function() {
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;
        $('#char-count').text(remaining);
        
        if (remaining <= 0) {
            $('.character-count').addClass('warning');
        } else {
            $('.character-count').removeClass('warning');
        }
        
        if (currentLength > maxLength) {
            $(this).val($(this).val().substr(0, maxLength));
        }
    });

    $('#char-count').text(maxLength - $('#chat-message').val().length);
});
JS;
$this->registerJs($script);
?>