<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Sighting';
$this->params['title'] = $this->title;

// $this->params['buttons'][] = Html::a('Download',  [Url::toRoute(['download', 'url' => $model->full_file_path])], ['class' => 'btn btn-orange', 'title' => 'Download']);

?>

<!-- <div class="card">
    <div class="card-body" style="background-color: #F5F5F5;">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <video width='445px' height='647px' controls>
                    <source src='<?= $model->full_file_path ?>' type='video/mp4'>
                </video>
                <div class="d-flex justify-content-around">
                    <div class="d-flex mb-2">
                        <img src="<?= $this->params['baseurl'] ?>/img/like.svg" alt="Like">
                        <p class="ms-1 mt-2 pt-2"><?= $model->like_count; ?></p>
                    </div>
                    <div class="d-flex mb-2">
                        <img src="<?= $this->params['baseurl'] ?>/img/comment.svg" alt="Comment">
                        <p class="ms-1 mt-2 pt-2"><?= $model->comment_count; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <div class="row">
                    <div class="d-flex col-lg-12 col-md-12">
                        <div class="col-lg-6 col-md-6">

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
                                                        <img src="<?= $comments->user->profile_display_image ?>" alt="User Avatar" class="user-avatar">
                                                        <div class="flex-grow-1 p-3" style="background-color: #F5F5F5; border-radius: 15px 30px 30px; ">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <h6 class="mb-0"><?= $comments->user->name ?></h6>
                                                                <a href="<?= Url::toRoute(['comment-delete', 'id' => $comments->id]) ?>" class="btn btn-orange ms-auto me-2"><i class="fa fa-trash me-1"></i>Delete</a>
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
                                                                    <img src="<?= $reply->user->profile_display_image ?>" alt="User Avatar" class="user-avatar">
                                                                    <div class="flex-grow-1 p-2" style="background-color: #F5F5F5; border-radius: 15px 20px 20px;">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                            <h6 class="mb-0"><?= $reply->user->name ?></h6>
                                                                            <a href="<?= Url::toRoute(['reply-delete', 'id' => $reply->id]) ?>" class="btn btn-orange ms-auto me-2"><i class="fa fa-trash me-1"></i>Delete</a>
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
</style> -->


<?php
$script = <<< JS
    $('.toggle-replies').on('click', function() {
        var commentId = $(this).data('comment-id');
        $('#replies-' + commentId).slideToggle();
    });
    
    $('.update-popup').on('click', function () {
        $('#logo-modal').modal('show')
		.find('#logoContent')
		.load($(this).attr('value'));
	});
JS;
$this->registerJs($script);
?>










<div class="container-fluid">
                    

                    <div class="wrapper_inner">
    <div class="row">
        <div class="col-xl-5">
            <div class="row">
                <div class="col-4 mb-3">
                    <div class="card p-0 bg-transparent h-100" style="border: 5px solid #F0F0F0; border-radius: 12px;">
                        <div class="h-100">
                            <a href=""> <img src="/assets/a8486371/images/post-thumnailes-img.jpg" class="card-img-top sightings-thumbnail h-100 object-fit-cover rounded" alt=""></a>
                        </div>
                        
                    </div>
                </div>
                <div class="col-8 mb-3">
                    <div class="details-packages">
                        <div class="topHeader d-flex justify-content-between align-items-center px-3 py-3">
                            <div class="date-or-time">
                                <p class="mb-1">UPLOADED DATE TIME:</p>
                                <p class="mb-0">12 April 2025, 10:17 PM</p>
                            </div>
                            <div class="active-btn">
                                <a href="">ACTIVE</a>
                            </div>
                        </div>

                        <table class="table w-100 border-0 border_o d-inline-block pt-3 mb-0">
                            <tbody class="tbody-leads sighting-leads py-5 w-100">
                                <tr>
                                    <td style="width: 25%;">Sighting Date:</td>
                                    <td style="width: 75%;">
                                        <p>12 April 2025</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Animal:</td>
                                    <td>
                                        <p>Tiger</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Session:</td>
                                    <td>
                                        <p>Morning</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Description:</td>
                                    <td>
                                        <p>Bajrang male tiger drinking water in Seeta Mandap in Tala zone</p>
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
                                         <img src="<?= $this->params['baseurl'] ?>/images/partner.jpg" alt="">
                                        <!-- <img
                                    src="<?= $this->params['baseurl'] ?>/images/Article-2.jpg" class="card-img-top sightings-video"alt="">  -->
                                    <!-- <img src="/assets/a8486371/images/shigtingimage-one.png" class="card-img-top sightings-video" alt=""> -->
                                </a>
                                    <div class="card-body">
                                        <div class="liksMain pt-0 d-flex align-items-center justify-content-between">
                                            <div class="likes d-flex align-items-center gap-1">
                                                <a href=""><img src="/assets/a8486371/images/like.png" alt=""></a>
                                                <a href="">
                                                    <p class="mb-0"><span>25</span> Likes</p>
                                                </a>
                                            </div>
                                            <div class="likes d-flex align-items-center gap-1">
                                                <a href="">
                                                    <p class="mb-0"><span>25</span> Comments</p>
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
                <h6>2 Comments</h6>
                <div class="one_box position-relative pb-4">
                    <div class="postcomment d-flex gap-2 pt-3 w-100">
                        <div class="avatar"><a href="/profile/user/anil-kumar" data-discover="true"><img alt="Profile" class="rounded-circle bg-info" title="Anil Kumar" src=""></a>
                        </div>
                        <div class="text_com">
                            <div class="requestContact d-flex gap-2 align-items-center font-color">
                                <a href="/profile/user/anil-kumar" data-discover="true"><span class="comment-author">Rahul Kumar</span></a> <span class="userDate-time">27
                                    Jun, 2025, 02:30 PM</span>
                            </div>
                            <p>Oh, that sounds amazing! I've always wanted to
                                experience the thrill of seeing wild animals up
                                close.</p>
                        </div>
                    </div>
                </div>
                <div class="one_box position-relative pb-4">
                    <div class="postcomment d-flex gap-2 pt-3 w-100">
                        <div class="avatar"><a href="/profile/user/anil-kumar" data-discover="true"><img alt="Profile" class="rounded-circle bg-info" title="Anil Kumar" src=""></a>
                        </div>
                        <div class="text_com">
                            <div class="requestContact d-flex gap-2 align-items-center font-color">
                                <a href="/profile/user/anil-kumar" data-discover="true"><span class="comment-author">Rahul
                                        Kumar</span></a><span class="userDate-time">27 Jun, 2025, 02:30 PM</span>
                            </div>
                            <p>Oh, that sounds amazing! I've always wanted to
                                experience the thrill of seeing wild animals up
                                close.</p>
                            <div class="user-active d-flex align-items-center gap-2">
                                <a href="">Reply <span>1</span></a> |
                                <a href="">Like <span>1</span></a>
                            </div>
                            <div class="hide-and-show">
                                <a href=""><span>Hide replies</span></a>
                            </div>
                            <div class="postcomment d-flex gap-2 pt-2 w-100">
                                <div class="avatar"><a href="/profile/user/anil-kumar" data-discover="true"><img alt="Profile" class="rounded-circle bg-info" title="Anil Kumar" src=""></a>
                                </div>
                                <div class="text_com">
                                    <div class="requestContact d-flex gap-2 align-items-center font-color">
                                        <a href="/profile/user/anil-kumar" data-discover="true"><span class="comment-author">Rahul Kumar</span></a> <span class="userDate-time">27 Jun, 2025, 02:30 PM</span>
                                    </div>
                                    <p>Oh, that sounds amazing! I've always wanted to
                                        experience the thrill of seeing wild animals up
                                        close.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="comment-form"><input type="hidden" value="TOKEN_HERE" name="_csrf-frontend">
                    <div class="comments-persons px-0 pt-4">
                        <div class="postcomment d-flex gap-3">
                            <div class="avatar"><a href="/profile/user/md-sarwar" data-discover="true"><img alt="" width="30" height="30" class="me-1 d-xl-inline-flex rounded-circle bg-info" src="https://dwi8hvna105nz.cloudfront.net/user/profile/2134_google_avatar.jpg"></a>
                            </div>
                            <div class="text-area">
                                <div class="mb-3 field-sharesafaricommentform-comment required">
                                    <textarea id="sharesafaricommentform-comment" class="form-control w-100" name="ShareSafariCommentForm[comment]" rows="5" placeholder="Write a comment..."></textarea>
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
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" "="">
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
</div>                </div>
            </div>