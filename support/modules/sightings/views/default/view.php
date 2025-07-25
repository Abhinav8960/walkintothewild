<?php

use common\models\sighting\Sighting;
use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Sighting';
$this->params['title'] = $this->title;

?>

<div class="container-fluid">
    <div class="wrapper_inner">
        <div class="row">
            <div class="col-xl-5">
                <div class="row">
                    <div class="col-4 mb-3">
                        <div class="card p-0 bg-transparent h-100" style="border: 5px solid #F0F0F0; border-radius: 12px;">
                            <div class="h-100">
                                <a href=""> <img src="<?= $model->thumbnail ?>" class="card-img-top sightings-thumbnail h-100 object-fit-cover rounded" alt=""></a>
                            </div>

                        </div>
                    </div>
                    <div class="col-8 mb-3">
                        <div class="details-packages">
                            <div class="topHeader d-flex justify-content-between align-items-center px-3 py-3">
                                <div class="date-or-time">
                                    <p class="mb-1">UPLOADED DATE TIME:</p>
                                    <p class="mb-0"><?= date("F j, Y", $model->created_at) . ' , ' . date("H:i:s A", $model->created_at) ?></p>
                                </div>
                                <?php if ($model->status == Sighting::STATUS_ACTIVE) { ?>
                                    <div class="active-btn">
                                        <a href="">ACTIVE</a>
                                    </div>
                                <?php } else { ?>
                                    <div class="inactive-btn">
                                        <a href="">INACTIVE</a>
                                    </div>
                                <?php } ?>
                            </div>

                            <table class="table w-100 border-0 border_o d-inline-block pt-3 mb-0">
                                <tbody class="tbody-leads sighting-leads py-5 w-100">
                                    <tr>
                                        <td style="width: 35%;">Sighting Date:</td>
                                        <td style="width: 65%;">
                                            <p><?= date("F j, Y", strtotime($model->post_datetime)); ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Animal:</td>
                                        <td>
                                            <p><?= isset($model->animalDetail) ? $model->animalDetail->name : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Session:</td>
                                        <td>
                                            <p><?= isset($model->safariSessionDetail) ? $model->safariSessionDetail->title : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Description:</td>
                                        <td>
                                            <p><?= isset($model->description) ? $model->description : '' ?></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="details-packages mb-3 py-4 px-3">
                    <div class="row justify-content-between gx-0">
                        <div class="col-xl-5">
                            <div class="video-area sighting-video-area">
                                <!-- <p>Video</p> -->
                                <div class="sightings-parent-card sightings-parent-card-view">
                                    <div class="card p-2 border-0 bg-white">
                                        <a href="">
                                            <img src="<?= $model->full_file_path ?>" alt="">
                                            <!-- <img
                                    src="<?= $this->params['baseurl'] ?>/images/Article-2.jpg" class="card-img-top sightings-video"alt="">  -->
                                            <!-- <img src="/assets/a8486371/images/shigtingimage-one.png" class="card-img-top sightings-video" alt=""> -->
                                        </a>
                                        <div class="card-body">
                                            <div class="liksMain pt-0 d-flex align-items-center justify-content-between">
                                                <div class="likes d-flex align-items-center gap-1">
                                                    <a href=""><img src="<?= $this->params['baseurl'] ?>/images/like.svg" alt=""></a>
                                                    <a href="">
                                                        <p class="mb-0"><span><?= $model->like_count; ?></span> Likes</p>
                                                    </a>
                                                </div>
                                                <div class="likes d-flex align-items-center gap-1">
                                                    <!-- <a href=""><img src="<?= $this->params['baseurl'] ?>/images/comment.svg" alt=""></a> -->
                                                    <a href="">
                                                        <p class="mb-0"><span><?= $model->comment_count; ?></span> Comments</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center pt-3">
                                    <!-- <a href="" class="sequenceBtn editBtn" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</a> -->
                                </div>
                            </div>

                        </div>
                        <!-- <div class="col-xl-6">
                        <div class="galleryCard video-area">
                            <p>Thumbnail</p>
                            <div class="card p-0 border-0 bg-transparent">
                                <div class="">
                                    <a href=""> <img src="/assets/a8486371/images/gallery-one.png"
                                            class="card-img-top sightings-thumbnail" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                        <!-- <div class="col-12 pt-5">
                        <div class="d-flex justify-content-center">
                            <a href="" class="sequenceBtn editBtn" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Edit</a>
                        </div>

                    </div> -->
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="itrnTextCard py-4">
                    <h6><?= $model->comment_count; ?>&nbsp;Comments</h6>
                    <div class="one_box position-relative pb-4">

                        <?php if ($parent_comments = $model->getComments()->andWhere(['parent_id' => null])->joinWith('user')->andWhere(['user.status' => 10, 'sighting_comment.status' => 1])->all()) {
                            foreach ($parent_comments as $comments) {
                                $replies = $comments->getReplies()->joinWith('user')->andWhere(['user.status' => 10, 'sighting_comment.status' => 1])->all();

                        ?>
                                <div class="postcomment d-flex gap-2 pt-3 w-100">

                                    <div class="avatar">
                                        <!-- <a href="/user/default/profile?user_id=<?=$comments->user->id?>" data-discover="true"> -->
                                            <img alt="Profile" class="rounded-circle bg-info" title="user-image" src="<?= $comments->user->profile_display_image ?>">
                                        </a>
                                    </div>
                                    <div class="text_com">
                                        <div class="requestContact d-flex gap-2 align-items-center font-color">
                                            <!-- <a href="/user/default/profile?user_id=<?=$comments->user->id?>" data-discover="true"><span class="comment-author"> -->
                                                <?= $comments->user->name ?></span>
                                            <!-- </a> -->
                                            <span class="userDate-time"><?= date("F j, Y", $comments->created_at) . ' , ' . date("H:i:s A", $comments->created_at) ?></span>
                                        </div>
                                        <p><?= $comments->comment ?></p>
                                        <div class="user-active d-flex align-items-center gap-2">
                                            <a href="">Reply <span><?= count($replies) ?></span></a> |
                                            <a href="">Like <span><?= count($replies) ?></span></a>
                                        </div>
                                        <div class="hide-and-show">
                                            <a href="javascript:void(0);" class="toggle-replies"><span>Hide replies</span></a>
                                        </div>
                                        <?php if ($replies) { ?>
                                            <div class="reply-container">
                                                <?php foreach ($replies as $reply) { ?>
                                                    <div class="postcomment d-flex gap-2 pt-2 w-100">
                                                        <div class="avatar">
                                                            <!-- <a href="/user/default/profile?user_id=<?=$reply->user->id?>" data-discover="true"> -->
                                                                <img alt="Profile" class="rounded-circle bg-info" title="user-image" src="<?= $reply->user->profile_display_image ?>">
                                                            <!-- </a> -->
                                                        </div>
                                                        <div class="text_com">
                                                            <div class="requestContact d-flex gap-2 align-items-center font-color">
                                                                <!-- <a href="/user/default/profile?user_id=<?=$reply->user->id?>" data-discover="true"> -->
                                                                    <span class="comment-author"><?= $reply->user->name ?></span>
                                                                <!-- </a> -->
                                                                <span class="userDate-time"><?= date("F j, Y", $reply->created_at) . ' , ' . date("H:i:s A", $reply->created_at) ?></span>
                                                            </div>
                                                            <p><?= $reply->comment ?></p>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>

                    <?= $this->render('_comment_form', ['comment_model' => $comment_model,'model'=>$model]) ?>

                </div>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class=" modal-content">
                <div class="modal-header headerTitle border-bottom-0 align-items-baseline px-4">
                    <p class="" id="">Update Sighting</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-5">
                    <div class="row">
                        <div class="col-lg-12 pb-5">
                            <div class="form_boxes">
                                <label for="">Caption <span>*</span></label>
                                <textarea name="" id="" class="form-control" placeholder="Lorem ipsum is a dummy or placeholder text commonly used in graphic design, publishing, and web development."></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="modalCrateButton">
                                <button type="btn" class="w-100">Update</button>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div> -->
</div>


<?php
$script = <<<JS
    $('.toggle-replies').on('click', function (e) {
        e.preventDefault();
        var replyContainer = $(this).closest('.hide-and-show').next('.reply-container');
        replyContainer.toggle();

        var spanText = $(this).find('span');
        if (replyContainer.is(':visible')) {
            spanText.text('Hide replies');
        } else {
            spanText.text('View replies');
        }
    });
JS;

$this->registerJs($script);
?>