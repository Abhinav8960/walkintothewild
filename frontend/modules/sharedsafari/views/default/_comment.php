<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<div class="col-lg-9">
    <div class="comments_safari">
        <div class="top_replysafari">
            <div class="comments-persons">
                <div class="postcomment d-flex gap-2">
                    <div class="avatar">
                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                    </div>
                    <div class="text_com">
                        <h6 class="nameavatr">Gufran Ahmad</h6>
                        <p>Oh, that sounds amazing! I've always wanted to experience the thrill of
                            seeing
                            wild animals up close.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="commentsOther  position-relative">
            <div class="objec-flgs">
                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" data-bs-toggle="modal" data-bs-target="#modalFlag">
            </div>
            <div class="postcomment d-flex gap-2 pt-3">
                <div class="avatar">
                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                </div>
                <div class="text_com">
                    <div class="requestContact d-flex gap-2 align-items-center">
                        <h6 class="nameavatr">Gufran Ahmad</h6>
                        <button class="request_btn">Request Contact</button>
                    </div>
                    <p>Oh, that sounds amazing! I've always wanted to experience the thrill of seeing
                        wild animals up close.</p>
                </div>
            </div>
        </div>
        <div class="commentsOther position-relative">
            <div class="objec-flgs">
                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
            </div>
            <div class="postcomment d-flex gap-2 pt-3">
                <div class="avatar">
                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                </div>
                <div class="text_com">
                    <div class="requestContact d-flex gap-2 align-items-center">
                        <h6 class="nameavatr">Amit</h6>
                        <button class="request_btn">Request Contact</button>
                    </div>
                    <p>Oh, that sounds amazing! I've always wanted to experience the thrill of seeing
                        wild animals up close.</p>
                </div>
            </div>
        </div>
        <div class="commentsOther position-relative">
            <div class="objec-flgs">
                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
            </div>
            <div class="postcomment d-flex gap-2 pt-3">
                <div class="avatar">
                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                </div>
                <div class="text_com">
                    <div class="requestContact d-flex gap-2 align-items-center">
                        <h6 class="nameavatr">vimal</h6>
                        <button class="request_btn">Request Contact</button>
                    </div>
                    <p>Oh, that sounds amazing! I've always wanted to experience the thrill of seeing
                        wild animals up close.</p>
                </div>
            </div>
        </div>
        <div class="commentsOther position-relative">
            <div class="objec-flgs">
                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
            </div>
            <div class="postcomment d-flex gap-2 pt-3">
                <div class="avatar">
                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                </div>
                <div class="text_com">
                    <div class="requestContact d-flex gap-2 align-items-center">
                        <h6 class="nameavatr">Rakesh</h6>
                        <button class="request_btn">Request Contact</button>
                    </div>
                    <p>Oh, that sounds amazing! I've always wanted to experience the thrill of seeing
                        wild animals up close.</p>
                </div>
            </div>
        </div>

    </div>
    <?php if (Yii::$app->user->id) { ?>
        <?= $this->render('_comment_form', ['model' => $model]) ?>
    <?php } else {
        echo 'Please <a href="/site/auth?authclient=google">Sign in</a> for start Comment';
    } ?>
</div>