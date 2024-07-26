<?php

use yii\widgets\Pjax;

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
                        <div class="col-3 chat-card-sidebar">
                            <?php
                            Pjax::begin([
                                'id' => 'grid-data',
                                'enablePushState' => FALSE,
                                'enableReplaceState' => FALSE,
                                'timeout' => false,
                            ]);
                            ?>
                            <div class="chat-search-user mb-2">
                                <?= $this->render('_search', ['searchModel' => $searchModel, 'autofocus' => true]) ?>
                            </div>
                            <?= $this->render('_default_userlist', ['dataProvider' => $dataProvider]) ?>
                            <?php Pjax::end(); ?>
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