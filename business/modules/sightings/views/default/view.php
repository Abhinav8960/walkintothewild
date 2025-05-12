<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Sighting';
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body" style="background-color: #F5F5F5;">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <video width='445px' height='647px' controls>
                    <source src='<?= $model->full_file_path ?>' type='video/mp4'>
                </video>
                <div class="d-flex justify-content-around">
                    <div class="d-flex mb-2">
                        <img src="<?= $this->params['baseurl'] ?>/img/like.svg" alt="Like">
                        <p class="ms-1 mt-2 pt-2"><?= $model->likes_count; ?></p>
                    </div>
                    <div class="d-flex mb-2">
                        <img src="<?= $this->params['baseurl'] ?>/img/comment.svg" alt="Comment">
                        <p class="ms-1 mt-2 pt-2"><?= $model->comments_count; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="d-flex mb-2">
                            <div>
                                <h5><?= isset($model->safarioperator) ? $model->safarioperator->business_name : ''; ?></h5>
                                <p><?= '@' . $model->user->user_handle; ?></p>
                                <p><?= $model->description; ?></p>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <strong>Sighting Date :</strong>
                            <p class="ms-1"><?= date("F j, Y", strtotime($model->post_datetime)); ?></p>
                        </div>
                        <div class="d-flex mb-2">
                            <strong>Animal :</strong>
                            <p class="ms-1"><?= isset($model->animalDetail) ? $model->animalDetail->name : ''; ?></p>
                        </div>
                        <div class="d-flex mb-2">
                            <strong>Session :</strong>
                            <p class="ms-1"><?= isset($model->safariSessionDetail) ? $model->safariSessionDetail->title : ''; ?></p>
                        </div>
                        <div class="d-flex mb-2">
                            <img src="<?= $this->params['baseurl'] ?>/img/location.svg" alt="Location">
                            <p class="ms-1 mt-2 pt-2"><?= isset($model->locationDetail) ? $model->locationDetail->title : ''; ?></p>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Comments</h5>
                                <div class="container">
                                    <div class="comments-list">
                                        <div class="comment-box">
                                            <?php if ($parent_comments = $model->getComments()->andWhere(['parent_id' => null])->joinWith('user')->andWhere(['user.status' => 10, 'sighting_comment.status' => 1])->all()) {
                                                foreach ($parent_comments as $comments) {
                                                    $replies = $comments->getReplies()->joinWith('user')->andWhere(['user.status' => 10, 'sighting_comment.status' => 1])->all();

                                            ?>
                                                    <div class="d-flex gap-3 mb-4">
                                                        <img src="<?= $comments->user->profileimage ?>" alt="User Avatar" class="user-avatar">
                                                        <div class="flex-grow-1 p-3" style="background-color: #F5F5F5; border-radius: 15px 30px 30px; ">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <h6 class="mb-0"><?= $comments->user->name ?></h6>
                                                                <span class="comment-time"><?= date("F j, Y", $comments->created_at) . ' at ' . date("H:i:s A", $comments->created_at) ?></span>
                                                            </div>
                                                            <p class="mb-2"><?= $comments->comment ?></p>
                                                            <div class="comment-actions">
                                                                <a href="javascript:void(0);" class="toggle-replies" data-comment-id="<?= $comments->id ?>">
                                                                    Reply (<?= count($replies) ?>)
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Reply Section -->
                                                    <?php if ($replies) { ?>
                                                        <div class="reply-section mt-3" id="replies-<?= $comments->id ?>" style="display: none;">
                                                            <?php foreach ($replies as $reply) { ?>
                                                                <div class="d-flex gap-3 mb-4">
                                                                    <img src="<?= $reply->user->profileimage ?>" alt="User Avatar" class="user-avatar">
                                                                    <div class="flex-grow-1 p-2" style="background-color: #F5F5F5; border-radius: 15px 20px 20px;">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                            <h6 class="mb-0"><?= $reply->user->name ?></h6>
                                                                            <span class="comment-time"><?= date("F j, Y", $reply->created_at) . ' at ' . date("H:i:s A", $reply->created_at) ?></span>
                                                                        </div>
                                                                        <p class="mb-2"><?= $reply->comment ?></p>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    <?php } ?>
                                            <?php }
                                            } ?>


                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .comment-box {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.2s;
        border: 1px solid #e9ecef;
    }

    .comment-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .comment-input {
        border-radius: 20px;
        padding: 15px 20px;
        border: 2px solid #e9ecef;
        transition: all 0.3s;
    }

    .comment-input:focus {
        box-shadow: none;
        border-color: #86b7fe;
    }

    .comment-time {
        color: #adb5bd;
        font-size: 0.85rem;
    }

    .reply-section {
        margin-left: 60px;
        border-left: 2px solid #e9ecef;
        padding-left: 20px;
    }
</style>


<?php
$script = <<< JS
    $('.toggle-replies').on('click', function() {
        var commentId = $(this).data('comment-id');
        $('#replies-' + commentId).slideToggle();
    });
JS;
$this->registerJs($script);
?>