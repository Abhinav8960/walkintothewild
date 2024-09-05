<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

?>
<button class="discussionTabs " style="background-color: var(--background-primary) !important;cursor:default;" value="">
    Discussion</button>
<div class="bg-white pb-3 px-3 rounded-3 mb-4">
    <div class="comments_safari border-0 ">
        <div class="commentsOther comment_hightfixed position-relative ps-3 ">
            <?php if ($parent_comments = $package->getComments()->where(['parent_id' => null, 'is_deleted' => 0])->joinWith('user')->andWhere(['user.status' => 10, 'package_comment.status' => 1])->all()) {
                foreach ($parent_comments as $comments) {
                    $replies = $comments->getReplies()->andWhere(['is_deleted' => 0])->joinWith('user')->andWhere(['user.status' => 10, 'package_comment.status' => 1])->all(); ?>
                    <div class="one_box position-relative">
                        <div class="objec-flgs">

                            <?php if ($comments->user) {
                                if (Yii::$app->user->identity && $comments->user_id != Yii::$app->user->id) { ?>
                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/package/default/flag', 'slug' => $package->package_slug, 'package_comment_id' => $comments->id]) ?>">
                            <?php }
                            }
                            ?>
                        </div>
                        <div class="postcomment d-flex gap-2 pt-3 w-100">
                            <div class="avatar">
                                <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => isset($comments->user) ? $comments->user->user_handle : '']) ?>">
                                    <img src="<?= $comments->user->profileimage ?>" alt="">
                                </a>
                            </div>
                            <div class="text_com">
                                <div class="requestContact d-flex gap-2 align-items-center font-color">
                                    <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => isset($comments->user) ? $comments->user->user_handle : '']) ?>">
                                        <span class="comment-author"><?= isset($comments->user) ? $comments->user->name : '' ?></a></span>
                                    </a>
                                    <span class="comment-date"><?= date("F j, Y", $comments->created_at) . ' at ' . date("H:i A", $comments->created_at) ?></span>
                                </div>
                                <p><?= $comments->comment ?>
                                    <?php if ($login_safarioperator) {
                                        if (Yii::$app->user->id == $login_safarioperator->user_id) { ?>
                                            <button class="reply_btn" data-id="<?= $comments->id ?>" data-target="reply-form-<?= $comments->id ?>"> <i class="fa-solid fa-reply me-1"></i>Reply </button>
                                    <?php }
                                    } ?>
                            </div>
                        </div>
                        <div class="comment-reply px-3">
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
                                                    <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => isset($reply->user) ? $reply->user->user_handle : '']) ?>"> <span class="comment-author"><?= isset($reply->user) ? $reply->user->name : '' ?></span></a>
                                                    <span class="comment-date"><?= date("F j, Y", $reply->created_at) . ' at ' . date("H:i A", $reply->created_at) ?></span>
                                                    <div class="comment-text">
                                                        <p><?= $reply->comment ?></p>
                                                    </div>

                                                    <?php if ($reply->user) {
                                                        if (Yii::$app->user->identity && $reply->user_id != Yii::$app->user->id) { ?>
                                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/package/default/flag', 'slug' => $package->package_slug, 'package_comment_id' => $reply->id]) ?>">
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
                                <div class="reply-form ms-lg-4 ms-2" style="display: none;" id="reply-form-<?= $comments->id ?>">

                                </div>

                            <?php } ?>
                        </div>
                    </div>

            <?php
                }
            } ?>
        </div>



    </div>
    <?php if ($package->status == 2) {
        echo "Comment Closed for this Package..." ?>
        <?php } else {
        if (Yii::$app->user->id) { ?>
            <?= $this->render('_comment_form', ['model' => $model]) ?>
    <?php } else {
            echo '<p class="text-center">Please <a href="/site/login?authclient=google&referrer=' .  Url::toRoute(['/package/default/view', 'operator_slug' => $package->safarioperator ? $package->safarioperator->slug : '', 'slug' => $package->package_slug]) . '" class="sign_intext parkrevieBtn">Sign in</a> to Comment</p>';
        }
    } ?>

</div>


<?php

$reply_url = Url::toRoute(['/package/default/reply', 'slug' => $package->package_slug]);

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