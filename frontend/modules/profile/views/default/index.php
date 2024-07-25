<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = $user->name . ' | Profile';
$this->params['title'] = $this->title;
?>

<section class="profile-wrapper">
    <div class="container mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['profile' => 'active', 'user' => $user]) ?>

    </div>
</section>

<section class="ta">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-xxl-11">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card mt-2 mb-4">
                            <div class="card-body">
                                <h6>About</h6>
                                <?php if ($user->about) { ?>
                                    <p><?= $user->about ?></p>
                                <?php } ?>
                                <h6>Social Media</h6>
                                <?php if ($user->facebook_url) { ?>
                                    <div class="links_sociels d-flex gap-2">
                                        <a href="" class="iconSize sizecontact"><i class="fa-brands fa-facebook-f me-1"></i></a>
                                        <p>Facebook
                                            <span> <a href="<?= $user->facebook_url; ?>" target="_blank" class="iconSize"><?= $user->facebook_url; ?></a></span>
                                        </p>
                                    </div>
                                <?php } ?>
                                <?php if ($user->whatsapp_url) { ?>
                                    <div class="links_sociels d-flex gap-2">
                                        <a href="" class="iconSize sizecontact"><i class="fa-brands fa-whatsapp me-1"></i></a>
                                        <p>Whatsapp
                                            <span> <a href="<?= $user->whatsapp_url; ?>" target="_blank" class="iconSize"><?= $user->whatsapp_url; ?></a></span>
                                        </p>
                                    </div>
                                <?php } ?>
                                <?php if ($user->x_url) { ?>
                                    <div class="links_sociels d-flex gap-2">
                                        <a href="" class="iconSize sizecontact"><i class="fa-brands fa-x-twitter me-1"></i></a>
                                        <p>Twitter
                                            <span> <a href="<?= $user->x_url; ?>" target="_blank" class="iconSize"><?= $user->x_url; ?></a></span>
                                        </p>
                                    </div>
                                <?php } ?>
                                <?php if ($user->insta_url) { ?>
                                    <div class="links_sociels d-flex gap-2">
                                        <a href="" class="iconSize sizecontact"><i class="fa-brands fa-instagram me-1"></i></a>
                                        <p>Instagram
                                            <span><a href="<?= $user->insta_url; ?>" target="_blank" class="iconSize"> <?= $user->insta_url; ?></a></span>
                                        </p>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>

                        <div class="card mt-2 mb-2">
                            <div class="card-body">
                                <h6 class="fs-6 fw-bold">Share Safari Experience</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 mb-5 pb-5">
                        <?= $this->render('_following_card', ['user' => $user]) ?>

                        <div class="request_quote mt-4">
                            <button class="intested_btn interestBtn " value="#" style="background-color: var(--background-primary) !important;">
                                Instagram</button>
                            <div class="interst_wrapper pt-3 px-md-5 bg-white">

                            </div>
                        </div>
                        <div class="request_quote mt-4">
                            <button class="intested_btn interestBtn " value="#" style="background-color: var(--background-primary) !important;">
                                Organized Shared Safari <?= $model_count ?></button>
                            <div class="interst_wrapper pt-3 px-md-5 bg-white">
                                <?php if ($model) {
                                    foreach ($model as $share_safari) {
                                ?>
                                        <div class="row justify-content-center">
                                            <div class="col-md-12 mb-4">
                                                <div class="sharesafri-card">
                                                    <div class="flotingdate">
                                                        <div class="icons text-center">
                                                            <p class="mb-0"><?= date('M', strtotime($share_safari->start_date)) ?></p>
                                                            <p class="mb-0"><?= date('d', strtotime($share_safari->start_date)) ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="shareimg">
                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
                                                    </div>
                                                    <div class="card_body">
                                                        <div class="top_seats">
                                                            <div class="safari d-flex justify-content-between ">
                                                                <div class="safarinum d-flex gap-2 align-items-center ">
                                                                    <p class="text_safari">SAFARI</p>
                                                                    <h6 class="number-safari"><?= $share_safari->no_of_safari ?></h6>

                                                                </div>
                                                                <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                                    <p class="text_safari">SEATS</p>
                                                                    <h6 class="number-safari"><?= $share_safari->share_seat ?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="titleDate">
                                                            <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><?= $share_safari->park->title ?></a></h6>
                                                            <div class="orgnizer">
                                                                <p>Organized by: <strong><?= $share_safari->user->name ?></strong></p>
                                                            </div>
                                                        </div>
                                                        <div class="footer_card row pb-2 px-2 align-items-center">
                                                            <div class="col-6">
                                                                <div class="users">
                                                                    <?php if ($interests = $share_safari->getIntrested()->where(['status' => 1])->limit(3)->all()) {
                                                                        $count = $share_safari->getIntrested()->count();
                                                                        $avatar_count = 3;
                                                                        foreach ($interests as $interest) {
                                                                    ?>
                                                                            <img src="<?= $interest->user && $interest->user->avatar <> '' ? $interest->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                                        <?php
                                                                        };
                                                                        $count = $share_safari->getIntrested()->count();
                                                                        $avatar_count = 3;
                                                                        $data = $count - $avatar_count;
                                                                        if ($data > 3) {  ?>
                                                                            <div class="roundes_countuser">
                                                                                <?= $data ?>+
                                                                            </div>
                                                                        <?php }
                                                                    } else { ?>
                                                                        <img src="<?= $share_safari->user && $share_safari->user->avatar <> '' ? $share_safari->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="safari text-center">
                                                                    <div class="joinsafari">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
</section>