<?php

use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Photo';
$this->params['title'] = $this->title;
?>

<section class="profile-wrapper">
    <div class="container-lg mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['photo' => 'active', 'user' => $user]) ?>
    </div>
</section>

<?php if (Yii::$app->user->identity) { ?>
    <section>
        <div class="container-lg ">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">
                    <div class="row justify-content-center ">
                        <div class="col-xxl-11 margin_bottomfooter">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card_bodyPadding">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-4">
                                                <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;">Photo Shared by <?= Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id ? 'me' : $user->name ?> </h6>
                                            </div>
                                            <div class="tab-content_tour active">
                                                <div class="row">
                                                    <?php
                                                    if ($user) {
                                                    ?>
                                                        <div class="col-md-4 gap-2  mb-2">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <h6 class="fs-6  mb-0" style="padding-bottom: 0 !important;">Display Picture</h6>
                                                            </div>
                                                            <div class="parksImgireview h-100 position-relative">
                                                                <img src="<?= isset($user->profileimage) <> '' ?  $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="w-100 h-100 rounded-2">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-8 gap-2  mb-2">
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <h6 class="fs-6  mb-0" style="padding-bottom: 0 !important;">Cover Picture</h6>

                                                            </div>
                                                            <div class="parksImgireview h-100 position-relative">
                                                                <img src="<?= isset($user->cover_image) <> '' ?  $user->coverimage : $this->params['baseurl'] . '/img/defaultcover_walkwild.jpg' ?>" alt="" class=" banner-cover rounded-2">
                                                            </div>

                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-6">
                                                            No Photo added!
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="d-flex justify-content-between mb-4 mt-4">
                                                    <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;"> Shared Safari Pictures </h6>

                                                </div>
                                                <div class="row">
                                                    <?php
                                                    if ($shared_safari) {
                                                        foreach ($shared_safari as $share_safari) {
                                                    ?>
                                                            <div class="col-md-4 gap-2  mb-2">
                                                                <div class=" parksImgireview h-100 position-relative">
                                                                    <img src="<?= isset($share_safari->sharedimagepath) ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="rounded-2">
                                                                </div>

                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div class="col-6">
                                                            No Photo added!
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="d-flex justify-content-between mb-4 mt-4">
                                                    <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;"> Articles Pictures </h6>

                                                </div>
                                                <div class="row">
                                                    <?php
                                                    if ($articles) {
                                                        foreach ($articles as $article) {
                                                    ?>
                                                            <div class="col-md-4 gap-2  mb-2">
                                                                <div class="parksImgireview rounded h-100 position-relative">
                                                                    <img src="<?= isset($article->banner_image) ? $article->bannerimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt="" class="rounded-2">
                                                                </div>

                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div class="col-6">
                                                            No Photo added!
                                                        </div>
                                                    <?php } ?>
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
    </section>
<?php } else { ?>

    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-xxl-11 margin_bottomfooter">
                <div class="card position-relative" style="min-height: 350px;">
                    <div class="card-body">
                        <div class="withoutlogedin">
                            <h6 class="fs-6 fw-bold">Photos</h6>
                        </div>

                        <div class="logininfo text-center">
                            <h6>Please log in to view the Photo.</h6>
                            <div class="viewAllreview">
                                <a href="/site/login?authclient=google&referrer=/profile/photo/<?= $user->user_handle ?>">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>