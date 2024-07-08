<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

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
                    $replies = $comments->getReplies()->where(['status' => 1])->all();

            ?>
                    <div class="one_box">
                        <div class="objec-flgs">
                            <?php if (Yii::$app->user->id) {  ?>
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/sharedsafari/default/flag', 'slug' => $share_safari->slug, 'park_id' => $share_safari->park_id, 'share_safari_comment_id' => $comments->id]) ?>">
                            <?php } ?>

                        </div>
                        <div class="postcomment d-flex gap-2 pt-3 w-100">
                            <div class="avatar">
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                            </div>
                            <div class="text_com">
                                <div class="requestContact d-flex gap-2 align-items-center">
                                    <h6 class="nameavatr"><?= $comments->user->name ?></h6>
                                    <?php if (Yii::$app->user->identity->id == $share_safari->host_user_id) { ?>
                                        <a class="request_btn" href="/sharedsafari/default/request-contact?slug=<?= $share_safari->slug ?>&park_id=<?= $share_safari->park_id ?>&share_safari_comment_id=<?= $comments->id ?>">Request Contact</a>
                                    <?php } ?>
                                </div>
                                <p><?= $comments->comment ?></p>
                                <button class="reply_btn" onclick="toggleReplyForm(this)" data-target="reply-form-<?= $comments->id ?>"> <i class="fa-solid fa-reply me-1"></i>Reply </button>
                            </div>
                        </div>
                        <div class="comment-reply">
                            <?php if ($replies) { ?>
                                <h6 class="card-brown-heading pb-2 ms-lg-4 ms-2 pt-2 toggle-replies" data-target="comment-container-<?= $comments->id ?>">View <?= count($replies) ?> replies</h6>
                                <div class="blog-comment-container" id="comment-container-<?= $comments->id ?>" style="display: none;">
                                    <!-- <h6 class="card-brown-heading pb-2 ms-lg-4 ms-2 pt-2">Replies</h6> -->
                                    <?php foreach ($replies as $reply) { ?>
                                        <div class="blog-comment-text ms-lg-4 ms-2 position-relative w-100 flags_reply" style="border:none;">
                                            <div class="d-flex gap-2">
                                                <div class="avatar">
                                                    <img src="<?= $reply->user && $reply->user->avatar <> '' ? $reply->user->avatar : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
                                                </div>
                                                <div class="font-color">
                                                    <span class="comment-author"><a href=""><?= $reply->user->name ?></a></span>
                                                    <span class="comment-date"><a href=""><?= date("F j, Y", $reply->created_at) . ' at ' . date("H:i A", $reply->created_at) ?> </a></span>
                                                    <div class="comment-text">
                                                        <p><?= $reply->comment ?></p>
                                                    </div>
                                                    <?php if (Yii::$app->user->id) {  ?>
                                                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/sharedsafari/default/flag', 'slug' => $share_safari->slug, 'park_id' => $share_safari->park_id, 'share_safari_comment_id' => $reply->id]) ?>">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>


                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if (Yii::$app->user->id) {  ?>
                                <div class="reply-form ms-lg-4 ms-2" style="display: none;" id="reply-form-<?= $comments->id ?>">
                                    <?php $form = ActiveForm::begin(['id' => 'reply-form']); ?>
                                    <div class="mb-3">
                                        <?= $form->field($replymodel, 'parent_id')->hiddenInput(['value' => $comments->id])->label(false) ?>
                                    </div>
                                    <div class="mb-3">
                                        <?= $form->field($replymodel, 'comment')->textarea(['rows' => '5', 'placeholder' => 'Write a reply...', 'class' => 'form-control w-100'])->label(false) ?>
                                    </div>
                                    <div class="btn-wrapper">
                                        <?= Html::submitButton('Submit', ['class' => 'post-comment']) ?>
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
    <?php if (Yii::$app->user->id) { ?>
        <?= $this->render('_comment_form', ['model' => $model]) ?>
    <?php } else {
        echo 'Please <a href="/site/auth?authclient=google" class="sign_intext">Sign in</a> for start Comment';
    } ?>
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