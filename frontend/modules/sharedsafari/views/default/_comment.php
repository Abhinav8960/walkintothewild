<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<div class="col-lg-9 order-lg-1 order-2">
    <div class="comments_safari">
        <div class="top_replysafari">
            <?php if ($share_safari->host_user_id) { ?>
                <div class="comments-persons">
                    <div class="postcomment d-flex gap-2">
                        <div class="avatar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                        </div>
                        <div class="text_com">
                            <h6 class="nameavatr"><?= $share_safari->user->name ?></h6>
                            <?php if ($share_safari->safari_plan) { ?>
                                <p><?= $share_safari->safari_plan; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="commentsOther  position-relative">
            <?php if ($parent_comments = $share_safari->getComments()->where("parent_id IS NULL")->andWhere(['status' => 1])->all()) {
                foreach ($parent_comments as $comments) {
            ?>
                    <div class="objec-flgs">
                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" data-bs-toggle="modal" data-bs-target="#modalFlag">
                    </div>
                    <div class="postcomment d-flex gap-2 pt-3">
                        <div class="avatar">
                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                        </div>
                        <div class="text_com">
                            <div class="requestContact d-flex gap-2 align-items-center">
                                <h6 class="nameavatr"><?= $comments->user->name ?></h6>
                                <button class="request_btn">Request Contact</button>
                            </div>
                            <p><?= $comments->comment ?></p>
                        </div>
                    </div>
            <?php
                }
            } ?>
        </div>



    </div>
    <?php if (Yii::$app->user->id) { ?>
        <?= $this->render('_comment_form', ['model' => $model]) ?>
    <?php } else {
        echo 'Please <a href="/site/auth?authclient=google" class="sign_intext">Sign in</a> for start Comment';
    } ?>
</div>