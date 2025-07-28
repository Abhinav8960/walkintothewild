<?php

use support\assets\AppAsset;
use common\models\GeneralModel;
use common\models\package\PackageVersion;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Package';

?>

<!-- <div class="main-pannel mt-0"> -->
<?= $this->render('_upper_view', ['package' => $package]) ?>
<section class="safari_wrapper  pt-sm-4 pt-0">
    <div class="container-fluid">

        <div class="row py-4">
            <div class="col-xl-9">

                <div class="tabContent mx-3">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Overview" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-xl-12 mb-4">
                                    <div class="itrnTextCard py-4">
                                        <h6 class="pb-3">About Trip / Overview</h6>
                                        <p><?= $package->package_description ?></p>
                                        <?php if ($package->partner_gallery_id && !empty($package->gallery_json)) {
                                            $gallery_images = json_decode($package->gallery_json, true);
                                            $images = $gallery_images['images'];
                                        ?>
                                            <h6>Accomodation Images</h6>
                                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                                <!-- <div class="carousel-indicators">
                                                            <?php foreach ($images as $index => $image) { ?>
                                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
                                                            <?php } ?>
                                                        </div> -->
                                                <div class="carousel-inner">
                                                    <?php foreach ($images as $index => $image) { ?>
                                                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                                            <img class="d-block w-100 rounded carousel-img" src="<?= $image['gallery_image_path'] ?>" alt="<?= htmlspecialchars($image['title']) ?>">
                                                            <div class="carousel-caption d-none d-md-block">
                                                                <h5><?= $image['title'] ?></h5>
                                                                <p><?= $image['caption'] ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                                <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button> -->
                                            </div>


                                        <?php } ?>

                                    </div>
                                </div>



                                <?php if ($package->live_version) { ?>
                                    <div class="col-xl-12">
                                        <div class="itrnTextCard py-4">
                                            <h6><?= $package->commentCount ?> Comments</h6>
                                            <div class="one_box position-relative pb-4">
                                                <?php if ($live_package = $package->livePackage) {
                                                    if ($parent_comments = $live_package->getComments()->where(['parent_id' => null, 'deleted_by' => 0])->joinWith('user')->andWhere(['user.status' => 10, 'package_comment.status' => 1])->all()) {
                                                        foreach ($parent_comments as $comments) {
                                                            $replies = $comments->getReplies()->andWhere(['deleted_by' => 0])->joinWith('user')->andWhere(['user.status' => 10, 'package_comment.status' => 1])->all();

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
                                                                        <a href="javascript:void(0);" class="show-replies" data-id="<?= $comments->id ?>">Reply <span><?= count($replies) ?></span></a>
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
                                                    }
                                                } ?>
                                            </div>

                                            <?php if (false) { ?>
                                                <form id="comment-form"><input type="hidden" value="TOKEN_HERE"
                                                        name="_csrf-frontend">
                                                    <div class="comments-persons px-0 pt-4">
                                                        <div class="postcomment d-flex gap-3">
                                                            <div class="avatar"><a
                                                                    href="/profile/user/md-sarwar"
                                                                    data-discover="true"><img alt="" width="30"
                                                                        height="30"
                                                                        class="me-1 d-xl-inline-flex rounded-circle bg-info"
                                                                        src="https://dwi8hvna105nz.cloudfront.net/user/profile/2134_google_avatar.jpg"></a>
                                                            </div>
                                                            <div class="text-area">
                                                                <div
                                                                    class="mb-3 field-sharesafaricommentform-comment required">
                                                                    <textarea
                                                                        id="sharesafaricommentform-comment"
                                                                        class="form-control w-100"
                                                                        name="ShareSafariCommentForm[comment]"
                                                                        rows="5"
                                                                        placeholder="Write a comment..."></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="comments-persons px-4 pt-2">
                                                        <div class="row justify-content-center">
                                                            <div class="col-lg-12 col-xl-8">
                                                                <!-- <div class="post_text padding_ad">
                                                                            <p>Commenting on this thread will notify all
                                                                                event attendees and will also be visible
                                                                                to everyone viewing the event.</p>
                                                                        </div> -->
                                                            </div>
                                                            <div class="col-lg-12 col-xl-4">
                                                                <div
                                                                    class="comment_button float-end mb-lg-0 mb-3">
                                                                    <button type="submit"
                                                                        class="post-comment">Post
                                                                        Comment</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Itinerary" role="tabpanel"
                            aria-labelledby="itinerary-tab"><?= $this->render('_overview', ['package' => $package]) ?>
                        </div>
                        <div class="tab-pane fade" id="Inclusions" role="tabpanel"
                            aria-labelledby="profile-tab"><?= $this->render('_inclusion', ['package' => $package]) ?></div>
                        <div class="tab-pane fade" id="Exclusions" role="tabpanel"
                            aria-labelledby="contact-tab"><?= $this->render('_getting_there', ['package' => $package]) ?>
                        </div>
                        <div class="tab-pane fade" id="Accomodation" role="tabpanel"
                            aria-labelledby="contact-tab"> <?= $this->render('_getting_there', ['package' => $package]) ?></div>
                        <div class="tab-pane fade" id="common" role="tabpanel"
                            aria-labelledby="contact-tab"> <?= $this->render('_policy', ['package' => $package]) ?></div>
                        <div class="tab-pane fade" id="FAQ" role="tabpanel"
                            aria-labelledby="contact-tab"><?= $this->render('_faqs', ['package' => $package, 'faqs' => $faqs]) ?></div>
                    </div>
                </div>

            </div>
            <div class="col-xl-2">
                <div class="request_quote mb-4"><button type="button"
                        class="intested_btn interestBtn d-flex justify-content-between btn btn-primary"
                        style="background-color: #09422D; cursor: default; border: none;">Edit
                        History</button>
                    <div class="interst_wrapper px-3 bg-white text-center">
                        <p class="mb-0">
                            <?php if ($package->versions) {
                                foreach ($package->versions as $v) { ?>
                        <div class="border mb-2">
                            <a href="<?= Url::toRoute(['view', 'id' => $v->id]) ?>" style="color:black;">
                                <?= $v->version ?>-<?= $v->statusLabel ?><br>(<?= date('Y-m-d H:i:s', $v->created_at) ?>)
                            </a>
                        </div>
                <?php }
                            } ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- </div> -->



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

<style>
    .carousel-img {
        height: 400px;
    }
</style>