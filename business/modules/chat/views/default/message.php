<?php

use yii\helpers\Url;
use yii\grid\GridView;
use common\models\chat\Chat;
use yii\widgets\Pjax;

\business\assets\EmojiAsset::register($this);
$webasset = $this->assetManager->getBundle('\business\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Message | ' . $individual_user->getName();


$emoji_base_url =  $this->assetManager->getBundle('\business\assets\EmojiAsset')->baseUrl; 
?>

<div class="container-lg mt-5 margin_bottomfooter pt-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <h6 class="fs-3 fw-bold"><?= $this->title ?></h6>
        </div>
        <div class="col-md-12">
            <?= $this->render('@frontend/modules/chat/views/default/_sidebar', ['active' => 'message']); ?>
        </div>
        <div class="col-md-12">
            <div class="row  itenary_tabs position-relative">
                <div class="col-md-4 col-xl-4 col-xxl-3 mb-3">
                    <div class="chat-card-sidebar card">
                        <div class="card-body">
                            <?php Pjax::begin([
                                'id' => 'grid-data',
                                'enablePushState' => FALSE,
                                'enableReplaceState' => FALSE,
                                'timeout' => false,
                            ]); ?>
                            <div class="tablmassage safartabs">
                                <ul class="nav  nav-tabs slider_profilemobilechat " id="pills-tab" role="tablist" style="justify-content:between">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php if (empty($chat_id)) {
                                                                    echo 'active';
                                                                } ?> 
                                                                chatFonts" id="direct-message-tab" data-bs-toggle="pill" data-bs-target="#direct-message" type="button" role="tab" aria-controls="direct-message" aria-selected="true">Chat</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php if (!empty($chat_id)) {
                                                                    echo 'active';
                                                                } ?>  chatFonts" id="quote-request-tab" data-bs-toggle="pill" data-bs-target="#quote-request" type="button" role="tab" aria-controls="quote-request" aria-selected="false">Quotaion  (<?= $unseen_quote_chat_count ?>)</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content pt-3" id="pills-tabContent">
                                <!-- direct msg user lists -->
                                <div id="direct-message" role="tabpanel" aria-labelledby="direct-message-tab" class="tab-pane fade <?php if (empty($chat_id) || $searchModel->name <> '') {
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

                                                <a href="<?= Url::toRoute(['/chat/default/message', 'user_handle' => $user->user_handle]) ?>" class="chat-link  mb-3 d-block" data-pjax="0">
                                                    <div class="chat-sidebar-user-card click_mobile <?= empty($chat_id) && $individual_user->id == $user->id ? 'selected_chat' : '' ?>">
                                                        <div class="d-flex chat-user_message">
                                                            <img src="<?= $user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                                            <div class="chat-user_name">
                                                                <h6 class="fs-6 mb-0" style="color: #4c4c4c;"><?= $user->getName() ?></h6>
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

                                <!-- Quote Request List -->
                                <div id="quote-request" role="tabpanel" aria-labelledby="quote-request-tab" class="tab-pane fade <?php if (!empty($chat_id) && $searchModel->name == '') {
                                                                                                                                        echo 'show active mt-4';
                                                                                                                                    } ?>">
                                    <div class="chat-cardlist pt-3">
                                        <div class="chatboxslid">
                                            <?php if ($searchModel->name == '' && $active_quote_chat_list) {
                                                foreach ($active_quote_chat_list as $active_chat) {
                                                    if ($login_user && $active_chat->user_id == $login_user->id) {
                                                        $user = $active_chat->recipient;
                                                    } else {
                                                        $user = $active_chat->user;
                                                    } ?>

                                                    <a href="<?= Url::toRoute(['/chat/message/' . $user->user_handle . "/" . base64_encode($active_chat->id)]) ?>" class="chat-link mb-3 d-block" data-pjax="0">


                                                        <div class="chat-sidebar-user-card  click_mobile <?= $active_chat->id == $chat_id ? 'selected_chat' : '' ?> <?= $active_chat->is_seen == 0 && $active_chat->updated_by <> Yii::$app->user->id ? 'unseen_chat' : '' ?>">
                                                            <div class="d-flex chat-user_message">
                                                                <div class="chat-user_name">
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
                                                                        <?php if ($active_chat->is_quote_accept == 1) { ?>
                                                                            <img src="<?= $user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';" style="background-color:#000;">
                                                                        <?php } else { ?>
                                                                            <img src="<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';" style="background-color:#000;">
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </div>

                                                                <div class="chat-user_name">
                                                                    <?php if ($active_chat->recipient_user_id == $user->id) { ?>
                                                                        <h6 class="fs-6 mb-0" style="color: #4c4c4c;">
                                                                            <?php if (isset($user->operator)) {
                                                                                echo $user->operator->business_name;
                                                                            } else {
                                                                                if ($active_chat->is_quote_accept == 1) {
                                                                                    echo $user->getName();
                                                                                } else {
                                                                                    echo substr($user->getName(), 0, 5);
                                                                                }
                                                                            }  ?>
                                                                        </h6>
                                                                    <?php } else { ?>
                                                                        <h6 class="fs-6 mb-0" style="color: #4c4c4c;"><?php
                                                                                                                        if ($active_chat->is_quote_accept == 1) {
                                                                                                                            echo $user->getName();
                                                                                                                        } else {
                                                                                                                            echo substr($user->getName(), 0, 5);
                                                                                                                        }
                                                                                                                        ?></h6>
                                                                    <?php } ?>
                                                                    <p class="mb-0 lastmassge" style="color:#4c4c4c;"><?= $active_chat->last_message ?></p>
                                                                    <p class="mb-0 lastmassge" style="color:#4c4c4c;"><b>Last Msg:</b> <?= date('M j, Y H:i', $active_chat->last_message_at) ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                            <?php }
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-xl-8 col-xxl-9 chatbox-wrap">
                    <?php Pjax::begin([
                        'id' => 'grid-data-chat',
                        'enablePushState' => FALSE,
                        'enableReplaceState' => FALSE,
                        'timeout' => false,
                    ]); ?>
                    <div class="chat_box  card  h-100 p-3">
                        <div class="card-body">
                            <div class="d-flex chat-message-header pb-4 justify-content-between">
                                <div class="chat-profile d-flex align-items-center gap-3">
                                    <div class="icons-show back-btn">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </div>
                                    <?php

                                    $chat = Chat::find()->where(['id' => $chat_id])->limit(1)->one();
                                    if (empty($chat) && $login_user) {
                                        $chat = Chat::find()->where(['user_id' => [$login_user->id, $individual_user->id], 'recipient_user_id' => [$login_user->id, $individual_user->id], 'status' => 1])->andWhere(['chat_type' => 1])->limit(1)->one();
                                    }
                                    $chat_person_name = '';
                                    if (isset($chat)) {
                                        if ($chat->recipient_user_id == $individual_user->id) { ?>
                                            <?php if (isset($individual_user->operator)) { ?>
                                                <a href="<?= Url::toRoute(['/operator/default/view', 'slug' => $individual_user->operator->slug]) ?>" style="color:inherit;">
                                                    <img src="<?= $individual_user->operator->logo ? $individual_user->operator->imagepath : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                                    <?= $chat_person_name = $individual_user->operator->business_name ?>
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $individual_user->user_handle]) ?>">
                                                    <img src="<?= $individual_user->profileimage ? $individual_user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                                    <?= $chat_person_name = $individual_user->getName() ?>
                                                </a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php
                                            if ($chat->is_quote_accept == 1) { ?>
                                                <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $individual_user->user_handle]) ?>" style="color:inherit;">
                                                    <img src="<?= $individual_user->profileimage ? $individual_user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                                    <?= $chat_person_name = $individual_user->getName() ?>
                                                </a>
                                            <?php } else { ?>
                                                <img src="<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                                <?= $chat_person_name = substr($individual_user->getName(), 0, 5) ?>
                                            <?php }  ?>
                                        <?php }
                                    } else { ?>
                                        <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $individual_user->user_handle]) ?>" style="color:inherit;">
                                            <img src="<?= $individual_user->profileimage ? $individual_user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
                                            <?= $chat_person_name = $individual_user->getName() ?>
                                        </a>
                                    <?php } ?>
                                </div>
                                <!-- <div class="chat-action-in-right">
                                    <i class="fa fa-search"></i>
                                    &nbsp;
                                    <i class="fa fa-ellipsis-v"></i>
                                </div> -->
                            </div>

                            <?php
                            if ($chat) {
                                if ($chat->chat_type == 1) {
                                    echo $this->render('_direct_chat_container', ['chat' => $chat, 'login_user' => $login_user, 'individual_user' => $individual_user, 'chat_id' => $chat_id, 'chat_person_name' => $chat_person_name]);
                                } else {
                                    echo $this->render('_quote_chat_container', ['chat' => $chat, 'login_user' => $login_user, 'individual_user' => $individual_user, 'chat_id' => $chat_id, 'chat_person_name' => $chat_person_name]);
                                }
                            } else {
                                echo $this->render('_direct_chat_container', ['chat' => $chat, 'login_user' => $login_user, 'individual_user' => $individual_user, 'chat_id' => $chat_id, 'chat_person_name' => $chat_person_name]);
                            }
                            ?>
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