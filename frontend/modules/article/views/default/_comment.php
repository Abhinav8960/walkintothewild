<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
?>
<div class="commentCount mb-4">
    <h6> Comments</h6>
</div>
<div class="comment_hightfixed">
    <?php
    if ($article_comments = $article->getArticlecomments()->andWhere(['parent_id' => null, 'is_deleted' => 0])->joinWith('user')->andWhere(['user.status' => 10, 'article_comment.status' => 1])->all()) {
        foreach ($article_comments as $article_comment) {
            $replies = $article_comment->getReplies()->andWhere(['is_deleted' => 0])->joinWith('user')->andWhere(['user.status' => 10, 'article_comment.status' => 1])->all();
    ?>
            <div class="comments-persons eee">
                <div class="postcomment d-flex gap-3">
                    <div class="avatar">
                        <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $article_comment->user && $article_comment->user->user_handle <> '' ? $article_comment->user->user_handle : '']) ?>">
                            <img src="<?= $article_comment->user->profileimage ?>" alt="">
                        </a>
                    </div>
                    <div class="text_com">
                        <div class="requestContact d-flex gap-2 align-items-center font-color">
                            <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $article_comment->user && $article_comment->user->user_handle <> '' ? $article_comment->user->user_handle : '']) ?>">
                                <h6 class="nameavatr"><?= isset($article_comment->user) ? $article_comment->user->name : "" ?></h6>
                            </a>
                            <span class="comment-date"><?= date("F j, Y", $article_comment->created_at) . ' at ' . date("h:i A", $article_comment->created_at) ?></span>
                        </div>
                        <p><?= $article_comment->comment ?></p>
                        <?php
                        if (Yii::$app->user->identity) { ?>
                            <button class="reply_btn" data-id="<?= $article_comment->id ?>" data-target="reply-form-<?= $article_comment->id ?>"> <i class="fa-solid fa-reply me-1"></i>Reply </button>
                        <?php }
                        ?>
                    </div>
                    <div class="objec-flgs pe-md-3 pe-2">
                        <?php if ($article_comment->user) {
                            if (Yii::$app->user->identity && $article_comment->user_id != Yii::$app->user->id) { ?>
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/article/default/flag', 'slug' => $article->slug, 'article_comment_id' => $article_comment->id]) ?>">
                        <?php }
                        } ?>
                    </div>
                </div>
                <div class="comment-reply px-3">
                    <?php if ($replies) { ?>
                        <h6 class="card-brown-heading pb-2 ms-lg-4 ms-2 pt-2 toggle-replies" data-target="comment-container-<?= $article_comment->id ?>">View <?= count($replies) ?> replies</h6>
                        <div class="blog-comment-container" id="comment-container-<?= $article_comment->id ?>" style="display: none;">
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
                                            <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => isset($reply->user) ? $reply->user->user_handle : '']) ?>"> <span class="comment-author"><?= isset($reply->user) ? $reply->user->name : '' ?></span></a>
                                            <span class="comment-date"><a href=""><?= date("F j, Y", $reply->created_at) . ' at ' . date("h:i A", $reply->created_at) ?> </a></span>
                                            <div class="comment-text">
                                                <p><?= $reply->comment ?></p>
                                            </div>

                                            <?php if ($reply->user) {
                                                if (Yii::$app->user->identity && $reply->user_id != Yii::$app->user->id) { ?>
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/article/default/flag', 'slug' => $article->slug, 'article_comment_id' => $reply->id]) ?>">
                                            <?php }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>


                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if (Yii::$app->user->id) {  ?>
                        <div class="reply-form ms-lg-4 ms-2" style="display: none;" id="reply-form-<?= $article_comment->id ?>">

                        </div>

                    <?php } ?>
                </div>

            </div>
    <?php }
    } ?>
</div>

<?php if (Yii::$app->user->id) {
?>
    <?php $form = ActiveForm::begin([
        'id' => 'comment-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'enableClientScript' => true,
        // 'action' => $model->action_url,
        'validationUrl' => $model->action_validate_url,
    ]); ?>
    <div class="comments-persons pe-md-3 pe-2">
        <div class="postcomment d-flex gap-3">
            <div class="avatar">
                <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => Yii::$app->user->identity && Yii::$app->user->identity->user_handle <> '' ? Yii::$app->user->identity->user_handle : '']) ?>">
                    <img src="<?= Yii::$app->user->identity && Yii::$app->user->identity->profileImage <> '' ? Yii::$app->user->identity->profileImage : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
                </a>
            </div>
            <div class="text-area">
                <?= $form->field($model, 'comment')->textarea(['rows' => '5', 'placeholder' => 'Write a comment...', 'class' => 'form-control w-100'])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="row justify-content-end comments-persons pe-md-3 pe-2">
        <div class="col-12 col-sm-8 col-md-6">
            <div class="comment_button float-end ">
                <?= Html::submitButton('Post Comment', ['class' => 'post-comment']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
<?php } else {
    echo '<p class="px-3 pt-2 text-center">Please <a href="/site/login?authclient=google&referrer=/article/' . $article->slug . '" class="sign_intext parkrevieBtn text-center">Sign in</a> to Comment</p>';
} ?>

<?php
$script = <<< JS
    $(document).ready(function(){
        setTimeout(function() {
    $('#info').fadeOut('fast');
}, 3000);
});
JS;
$this->registerJs($script);
?>

<style>
    .alert-success {
        display: none !important;
    }
</style>



<?php

$reply_url = Url::toRoute(['/article/default/reply', 'slug' => $article->slug]);

?>

<?php
$script = <<<JS
function replyFunction() {
    $('.reply_btn').on('click', function () {
        $('.reply-form').html('');
        var link = $(this); // define link variable
        var target = link.data('target');
        var replyForm = $('#' + target);
        
        var parentId = link.data('id');
        var replyUrl = '{$reply_url}&parent_id=' + parentId;
        $.get(replyUrl, function(data) {
            if (replyForm.css('display') === 'none' || replyForm.css('display') === '') {
            replyForm.show();
        } else {
            replyForm.hide();
        }
            $("#"+target).html(data);
        });
        
    });
}
replyFunction();
JS;
$this->registerJs($script);
?>

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