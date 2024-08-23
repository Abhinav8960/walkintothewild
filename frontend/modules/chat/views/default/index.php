<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Message';

?>

<div class="container-lg mt-5 margin_bottomfooter pt-5 ">
    <div class="row mb-5">
        <div class="col-md-12">
            <h6 class="fs-3 fw-bold"><?= $this->title ?></h6>
        </div>
        <div class="col-md-12">
            <?= $this->render('@frontend/modules/chat/views/default/_sidebar', ['active' => 'message']); ?>
        </div>
        <div class="col-md-12">
            <div class="row chat">
                <div class="col-md-3 mb-3">
                    <div class="chat-card-sidebar card">
                        <div class="card-body ">
                            <?php
                            Pjax::begin([
                                'id' => 'grid-data',
                                'enablePushState' => FALSE,
                                'enableReplaceState' => FALSE,
                                'timeout' => false,
                            ]);
                            ?>
                            <div class="chat-search-user mb-2 position-relative">
                                <?= $this->render('_search', ['searchModel' => $searchModel, 'autofocus' => true]) ?>
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
                                            <div class="chat-sidebar-user-card">
                                                <div class="d-flex chat-user_message">
                                                    <img src="<?= $user->avatar <> '' ? $user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle user-icon" onerror="this.src='<?= $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>';">
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
                <div class="col-md-9 ">
                    <div class="chat_box  card text-center h-100">
                        <div class="card-body">
                            Select a User for Chat
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>