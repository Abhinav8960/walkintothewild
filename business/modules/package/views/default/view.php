<?php

use business\assets\AppAsset;
use common\models\GeneralModel;
use common\models\package\PackageVersion;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


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
                                    </div>
                                </div>
                                <?php if (false) { ?>
                                    <div class="col-xl-12">
                                        <div class="itrnTextCard py-4">
                                            <h6>2 Comments</h6>
                                            <div class="one_box position-relative pb-4">
                                                <div class="postcomment d-flex gap-2 pt-3 w-100">
                                                    <div class="avatar"><a href="/profile/user/anil-kumar"
                                                            data-discover="true"><img alt="Profile"
                                                                class="rounded-circle bg-info"
                                                                title="Anil Kumar" src=""></a>
                                                    </div>
                                                    <div class="text_com">
                                                        <div
                                                            class="requestContact d-flex gap-2 align-items-center font-color">
                                                            <a href="/profile/user/anil-kumar"
                                                                data-discover="true"><span
                                                                    class="comment-author">Rahul
                                                                    Kumar</span></a>
                                                        </div>
                                                        <p>Oh, that sounds amazing! I've always wanted to
                                                            experience the thrill of seeing wild animals up
                                                            close.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="one_box position-relative pb-4">
                                                <div class="postcomment d-flex gap-2 pt-3 w-100">
                                                    <div class="avatar"><a href="/profile/user/anil-kumar"
                                                            data-discover="true"><img alt="Profile"
                                                                class="rounded-circle bg-info"
                                                                title="Anil Kumar" src=""></a>
                                                    </div>
                                                    <div class="text_com">
                                                        <div
                                                            class="requestContact d-flex gap-2 align-items-center font-color">
                                                            <a href="/profile/user/anil-kumar"
                                                                data-discover="true"><span
                                                                    class="comment-author">Rahul
                                                                    Kumar</span></a>
                                                        </div>
                                                        <p>Oh, that sounds amazing! I've always wanted to
                                                            experience the thrill of seeing wild animals up
                                                            close.</p>
                                                    </div>
                                                </div>
                                            </div>
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
                        <p class="mb-0">Nobody has shared any review about</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- </div> -->