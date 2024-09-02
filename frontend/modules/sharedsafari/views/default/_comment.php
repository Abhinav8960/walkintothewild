<?php

use common\models\sharesafari\ShareSafariIntrested;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

?>

<div class="<?= isset($colsize) ? $colsize : 'col-lg-9' ?>  mb-4">

    <div class="formbg">
        <button class="discussionTabs " style="background-color: var(--background-primary) !important;cursor:default;" value="">
            Discussion</button>
        <div class="comments_safari bg-white">

            <?php if ($share_safari->host_user_id) { ?>
                <?php if ($share_safari->safari_plan && $share_safari->type == $share_safari::TYPE_SAFARI) { ?>
                    <div class="top_replysafari px-3">
                        <div class="comments-persons">
                            <div class="postcomment d-flex gap-2">
                                <div class="avatar">
                                    <a href="<?= $share_safari->organizedbyprofileurl <> '' ? $share_safari->organizedbyprofileurl : '#' ?>"><img src="<?= $share_safari->user && $share_safari->user->avatar <> '' ? $share_safari->user->avatar : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt=""></a>
                                </div>
                                <div class="text_com">
                                    <a href="<?= $share_safari->organizedbyprofileurl <> '' ? $share_safari->organizedbyprofileurl : '#' ?>">
                                        <h6 class="nameavatr"><?= isset($share_safari->organizedbyname) ? $share_safari->organizedbyname : 'N/A' ?></h6>
                                    </a>

                                    <div class="profile-description">
                                        <div class="text show-more-height">
                                            <?= $share_safari->safari_plan; ?>
                                        </div>
                                        <div class="show-more">See More</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

            <div class="commentsOther  position-relative">
                <?php if ($parent_comments = $share_safari->getComments()->where("parent_id IS NULL")->andWhere(['status' => 1])->all()) {
                    foreach ($parent_comments as $comments) {
                        $replies = $comments->getReplies()->where(['status' => 1])->all();

                ?>
                        <div class="one_box position-relative">
                            <div class="objec-flgs">

                                <?php if ($comments->user) {
                                    if ($login_safarioperator) {
                                        if ($comments->user->id != $login_safarioperator->user_id) { ?>
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/sharedsafari/default/flag', 'slug' => $share_safari->slug, 'park_id' => $share_safari->park_id, 'share_safari_comment_id' => $comments->id]) ?>">
                                        <?php }
                                    } elseif ($comments->user->id != Yii::$app->user->id) { ?>
                                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/sharedsafari/default/flag', 'slug' => $share_safari->slug, 'park_id' => $share_safari->park_id, 'share_safari_comment_id' => $comments->id]) ?>">
                                <?php }
                                } ?>

                            </div>
                            <div class="postcomment d-flex gap-2 pt-3 w-100">
                                <div class="avatar">
                                    <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => isset($comments->user) ? $comments->user->user_handle : '']) ?>">
                                        <!--                                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">-->
                                        <img src="<?= $comments->user->profileimage ?>" alt="" class="rounded-circle" title="<?= $comments->user ? $comments->user->name : '' ?>">
                                    </a>
                                </div>
                                <div class="text_com">
                                    <div class="requestContact d-flex gap-2 align-items-center font-color">
                                        <span class="comment-author"><a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => isset($comments->user) ? $comments->user->user_handle : '']) ?>">
                                                <?= isset($comments->user) ? $comments->user->name : '' ?></a></span> <span class="comment-date"><?= date("F j, Y", $comments->created_at) . ' at ' . date("H:i A", $comments->created_at) ?></span>
                                        </a>
                                        <!-- <?php if (Yii::$app->user->identity) {
                                                    if (Yii::$app->user->identity->id == $share_safari->host_user_id) { ?>
                                                <a class="request_btn" href="/sharedsafari/default/request-contact?slug=<?= $share_safari->slug ?>&park_id=<?= $share_safari->park_id ?>&share_safari_comment_id=<?= $comments->id ?>">Request Contact</a>
                                        <?php }
                                                } ?> -->
                                    </div>
                                    <p><?= $comments->comment ?></p>
                                    <?php if (Yii::$app->user->identity) {
                                        $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                        if ($share_safari_intrested || Yii::$app->user->id ==  $share_safari->host_user_id || ($login_safarioperator && $share_safari->host_user_id == $login_safarioperator->id)) { ?>
                                            <button class="reply_btn" onclick="toggleReplyForm(this)" data-target="reply-form-<?= $comments->id ?>"> <i class="fa-solid fa-reply me-1"></i>Reply </button>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                            <div class="comment-reply px-4">
                                <?php if ($replies) { ?>
                                    <h6 class="card-brown-heading pb-2 ms-lg-4 ms-2 pt-2 toggle-replies" data-target="comment-container-<?= $comments->id ?>">View <?= count($replies) ?> replies</h6>
                                    <div class="blog-comment-container" id="comment-container-<?= $comments->id ?>" style="display: none;">
                                        <!-- <h6 class="card-brown-heading pb-2 ms-lg-4 ms-2 pt-2">Replies</h6> -->
                                        <?php foreach ($replies as $reply) { ?>
                                            <div class="blog-comment-text ms-lg-4 ms-2 position-relative w-100 flags_reply" style="border:none;">
                                                <div class="d-flex gap-2">
                                                    <div class="avatar">
                                                        <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => isset($reply->user) ? $reply->user->user_handle : '']) ?>">
                                                            <img src="<?= $reply->user && $reply->user->profileImage <> '' ? $reply->user->profileImage : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="font-color">
                                                        <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => isset($reply->user) ? $reply->user->user_handle : '']) ?>">
                                                            <span class="comment-author"><?= isset($reply->user) ? $reply->user->name : '' ?></span>
                                                        </a>
                                                        <span class="comment-date"><a href=""><?= date("F j, Y", $reply->created_at) . ' at ' . date("H:i A", $reply->created_at) ?> </a></span>
                                                        <div class="comment-text">
                                                            <p><?= $reply->comment ?></p>
                                                        </div>

                                                        <?php if ($login_safarioperator) {
                                                            if ($login_safarioperator && Yii::$app->user->id != $login_safarioperator->user_id) { ?>
                                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/sharedsafari/default/flag', 'slug' => $share_safari->slug, 'park_id' => $share_safari->park_id, 'share_safari_comment_id' => $reply->id]) ?>">
                                                            <?php }
                                                        } else {
                                                            if (Yii::$app->user->identity && Yii::$app->user->id !=  $share_safari->host_user_id) { ?>
                                                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/sharedsafari/default/flag', 'slug' => $share_safari->slug, 'park_id' => $share_safari->park_id, 'share_safari_comment_id' => $reply->id]) ?>">
                                                        <?php }
                                                        } ?>

                                                    </div>
                                                </div>
                                            </div>


                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <?php if (Yii::$app->user->id) {  ?>
                                    <div class="reply-form ms-lg-4 ms-2" style="display: none;" id="reply-form-<?= $comments->id ?>">
                                        <?php $form = ActiveForm::begin([]); ?>
                                        <div class="mb-3">
                                            <?= $form->field($replymodel, 'parent_id')->hiddenInput(['value' => $comments->id])->label(false) ?>
                                        </div>
                                        <div class="mb-3">
                                            <?= $form->field($replymodel, 'comment')->textarea(['rows' => '5', 'placeholder' => 'Write a reply...', 'class' => 'form-control w-100'])->label(false) ?>
                                        </div>
                                        <div class="btn-wrapper">
                                            <?= Html::submitButton('Submit', ['class' => 'post-comment  ']) ?>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>

                <?php
                    }
                } ?>
            </div>
        </div>
        <?php if ($share_safari->status == 2) {
            echo '<p class="px-3 pt-2">Comment Closed for this Safari...</p>';
        } elseif ($share_safari->status == 3) {
            echo '<p class="px-3 pt-2">Comment Closed</p>';
        } else {
            if (Yii::$app->user->id) {
                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                if ($share_safari_intrested || Yii::$app->user->id == $share_safari->host_user_id || ($login_safarioperator && $share_safari->host_user_id == $login_safarioperator->id)) { ?>
                    <?= $this->render('_comment_form', ['model' => $model]) ?>
        <?php } else {
                    echo '<p class="px-3 pt-2 text-center">Please Join in for start Comment</p>';
                }
            } else {
                echo '<p class="px-3 pt-2 text-center">Please <a href="/site/login?authclient=google&referrer=' . Url::toRoute([
                    '/sharedsafari/default/view',
                    'slug' => $share_safari->slug,
                    'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''
                ]) . '" class="parkrevieBtn">Sign In</a> to Comment</p>';
            }
        } ?>
    </div>




</div>
<script>
    function toggleReplyForm(link) {
        var target = link.getAttribute('data-target');
        var replyForm = document.querySelector('#' + target);
        if (replyForm.style.display === "none" || replyForm.style.display === "") {
            replyForm.style.display = "block";
        } else {
            replyForm.style.display = "none";
        }
    }
</script>

<?php
$script = <<< JS

function writeareviewfunction() {
    $('.flagBtn').on('click', function () {
        $('#modalFlag').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
writeareviewfunction();

$('.toggle-replies').click(function() {
        var target = $(this).data('target');
        var container = $('#' + target);
        var isVisible = container.is(':visible');
        container.slideToggle();
        $(this).text(isVisible ? 'View replies' : 'Hide replies');
    });        
JS;
$this->registerJs($script);
?>