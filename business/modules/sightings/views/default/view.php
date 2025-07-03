<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Sighting';
// $this->params['title'] = $this->title;
?>

<div class="wrapper_inner">
    <div class="row">
        <div class="col-xl-5">
            <div class="details-packages mb-3">
                <div class="topHeader d-flex justify-content-between align-items-center px-3 py-3">
                    <div class="date-or-time">
                        <p class="mb-1">UPLOADED DATE TIME:</p>
                        <p class="mb-0"><?= date("d F Y, h:i A", $model->created_at); ?></p>
                    </div>
                    <!-- <div class="active-btn">
                        <a href="">ACTIVE</a>
                    </div> -->
                </div>

                <table class="table w-100 border-0 border_o d-inline-block py-3">
                    <tbody class="tbody-leads sighting-leads py-5 w-100">
                        <tr>
                            <td style="width: 20%;">Sighting Date:</td>
                            <td style="width: 80%;">
                                <p><?= date("d F Y, h:i A", strtotime($model->post_datetime)); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>Animal:</td>
                            <td>
                                <p><?= isset($model->animalDetail) ? $model->animalDetail->name : ''; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>Session:</td>
                            <td>
                                <p><?= isset($model->safariSessionDetail) ? $model->safariSessionDetail->title : ''; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>Description:</td>
                            <td>
                                <p><?= $model->description; ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="details-packages mb-3 py-4 px-3">
                <div class="row justify-content-between gx-0">
                    <div class="col-xl-5">
                        <div class="video-area">
                            <p>Video</p>
                            <div class="sightings-parent-card sightings-parent-card-view">
                                <div class="card p-2 border-0">
                                    <video class="card-img-top sightings-video" controls>
                                        <source src='<?= $model->full_file_path ?>' type='video/mp4'>
                                    </video>
                                    <div class="card-body">
                                        <div class="liksMain pt-0 d-flex align-items-center justify-content-between">
                                            <div class="likes d-flex align-items-center gap-1">
                                                <a href=""><img src="<?= $this->params['baseurl'] ?>/images/like.svg" alt=""></a>
                                                <a href="">
                                                    <p class="mb-0"><span><?= $model->like_count; ?></span> Likes</p>
                                                </a>
                                            </div>
                                            <div class="likes d-flex align-items-center gap-1">
                                                <a href="">
                                                    <p class="mb-0"><span><?= $model->comment_count; ?></span> Comments</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="galleryCard video-area">
                            <p>Thumbnail</p>
                            <div class="card p-0 border-0 bg-transparent">
                                <div class="">
                                    <a href=""> <img src="<?= $model->thumbnail ?>"
                                            class="card-img-top sightings-thumbnail" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 pt-5">
                        <!-- <div class="d-flex justify-content-center">
                            <a href="" class="sequenceBtn" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Edit</a>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="itrnTextCard py-4">
                <h6><?= $model->comment_count; ?> Comments</h6>
                <div class="one_box position-relative pb-4">
                    <?php if ($parent_comments = $model->getComments()->andWhere(['parent_id' => null])->joinWith('user')->andWhere(['user.status' => 10, 'sighting_comment.status' => 1])->all()) {
                        foreach ($parent_comments as $comments) {
                            $replies = $comments->getReplies()->joinWith('user')->andWhere(['user.status' => 10, 'sighting_comment.status' => 1])->all();

                    ?>
                            <div class="postcomment d-flex gap-2 pt-3 w-100">
                                <div class="avatar">
                                    <img src="<?= $comments->user->profile_display_image ?>" alt="Profile"
                                        class="rounded-circle bg-info">
                                </div>
                                <div class="text_com">
                                    <div class="requestContact d-flex gap-2 align-items-center font-color">
                                        <span class="comment-author"><?= $comments->user->name ?></span>
                                        <span class="userDate-time"><?= date("d F Y, h:i A", $comments->created_at); ?></span>
                                    </div>
                                    <p><?= $comments->comment ?></p>
                                    <div class="user-active d-flex align-items-center gap-2">
                                        <a href="javascript:void(0);" class="show-replies" data-id="<?= $comments->id ?>">Reply <span><?= count($replies) ?></span></a> |
                                        <a href="">Like <span><?= $comments->liked_count ?></span></a>
                                    </div>
                                    <?php if ($replies) { ?>
                                        <div class="replies-wrapper mt-2" id="replies-wrapper-<?= $comments->id ?>" style="display: none;">
                                            <div class="hide-and-show hide-replies" id="replies-<?= $comments->id ?>">
                                                <a href=""><span>Hide replies</span></a>
                                            </div>
                                            <?php foreach ($replies as $reply) { ?>
                                                <div class="postcomment d-flex gap-2 pt-2 w-100">
                                                    <div class="avatar">
                                                        <img src="<?= $reply->user->profile_display_image ?>" alt="Profile" class="rounded-circle bg-info">
                                                    </div>
                                                    <div class="text_com">
                                                        <div class="requestContact d-flex gap-2 align-items-center font-color">
                                                            <span class="comment-author"><?= $reply->user->name ?></span>
                                                            <span class="userDate-time"><?= date("d F Y, h:i A", $reply->created_at); ?></span>
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
                <?php if (false) { ?>
                    <form id="comment-form"><input type="hidden" value="TOKEN_HERE" name="_csrf-frontend">
                        <div class="comments-persons px-0 pt-4">
                            <div class="postcomment d-flex gap-3">
                                <div class="avatar"><a href="/profile/user/md-sarwar" data-discover="true"><img alt=""
                                            width="30" height="30" class="me-1 d-xl-inline-flex rounded-circle bg-info"
                                            src="https://dwi8hvna105nz.cloudfront.net/user/profile/2134_google_avatar.jpg"></a>
                                </div>
                                <div class="text-area">
                                    <div class="mb-3 field-sharesafaricommentform-comment required">
                                        <textarea id="sharesafaricommentform-comment" class="form-control w-100"
                                            name="ShareSafariCommentForm[comment]" rows="5"
                                            placeholder="Write a comment..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="comments-persons px-4 pt-2">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-xl-8">

                                </div>
                                <div class="col-lg-12 col-xl-4">
                                    <div class="comment_button float-end mb-lg-0 mb-3">
                                        <button type="submit" class="post-comment">Comment</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"">
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
</div> -->

<?php
$js = <<<JS

$(document).on('click', '.show-replies', function() {
    var id = $(this).data('id');
    $('#replies-wrapper-' + id).slideDown();
    $(this).show();
});


$(document).on('click', '.hide-replies', function() {
    var id = $(this).data('id');
    $('#replies-wrapper-' + id).slideUp();
});
JS;

$this->registerJs($js);
?>