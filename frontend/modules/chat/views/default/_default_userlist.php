<?php

use yii\helpers\Url;
use common\models\chat\Chat;

if ($dataProvider) {
    foreach ($dataProvider->models as $model) { ?>
        <a href="<?= Url::toRoute(['/chat/default/message', 'user_handle' => $model->user_handle]) ?>" class="chat-link" data-pjax="0">
            <div class="chat-sidebar-user-card ">
                <div class="d-flex chat-user_message">
                    <img src="<?= $user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle user-icon">
                    <div class="chat-user_name">
                        <h6><?= $model->name ?></h6>

                        <?php
                        $active_chat = Chat::find()->where(['status' => 1])->andwhere('user_id =' . $model->id . ' OR recipient_user_id=' . $model->id)->orderby(['last_message_at' => SORT_DESC])->one();
                        if ($active_chat) {
                        ?>
                            <p class="mb-0 lastmassge"><?= $active_chat->last_message ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </a>
<?php }
} ?>