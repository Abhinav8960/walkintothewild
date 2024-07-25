<?php

use yii\helpers\Url;
use yii\grid\GridView;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Chat';

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
                        <div class="col-3">
                            <div class="chat-search-user">
                                <?= $this->render('_search', ['searchModel' => $searchModel]) ?>
                            </div>
                            <?php if ($dataProvider) {
                                foreach ($dataProvider->models as $model) { ?>
                                    <a href="<?= Url::toRoute(['/chat/default/message', 'user_handle' => $model->user_handle]) ?>" class="chat-link">
                                        <div class="chat-sidebar-user-card">
                                            <div class="d-flex chat-user_message">
                                                <img src="<?= $model->avatar <> '' ? $model->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle user-icon">
                                                <div class="chat-user_name">
                                                    <h6><?= $model->name ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                            <?php }
                            } ?>
                        </div>
                        <div class="col-9 text-center">
                            Select a User for Chat
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>