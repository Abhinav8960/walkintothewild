<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

?>

<div class="col-lg-9 order-lg-1 order-2">
    <div class="comments_safari">
        <div class="top_replysafari">
            <?php if ($package->created_by) { ?>
                <div class="comments-persons">
                    <div class="postcomment d-flex gap-2">
                        <div class="avatar">
                            <img src="<?= $package->user && $package->user->avatar <> '' ? $package->user->avatar : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
                        </div>
                        <div class="text_com">
                            <h6 class="nameavatri"><?= isset($package->user) ? $package->user->name : '' ?></h6>
                            <?php if ($package->package_description) { ?>
                                <p><?= $package->package_description; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="commentsOther  position-relative">
            <?php if ($parent_comments = $package->getComments()->where("parent_id IS NULL")->andWhere(['status' => 1])->all()) {
                foreach ($parent_comments as $comments) {
                    $replies = $comments->getReplies()->where(['status' => 1])->all();

            ?>
                    <div class="one_box">
                        <div class="postcomment d-flex gap-2 pt-3 w-100">
                            <div class="avatar">
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                            </div>
                            <div class="text_com">
                                <div class="requestContact d-flex gap-2 align-items-center">
                                    <h6 class="nameavatr"><?= $comments->user->name ?></h6>
                                </div>
                                <p><?= $comments->comment ?></p>
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
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
            <?php
                }
            } ?>
        </div>
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