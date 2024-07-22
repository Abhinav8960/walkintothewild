<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = $user->name . ' | Profile';
$this->params['title'] = $this->title;
?>


<div class="container mb-5">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['profile' => 'active', 'user' => $user]) ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card mt-2 mb-4">
                <div class="card-body">
                    <h6>About</h6>
                    <?php if ($user->about) { ?>
                        <p><?= $user->about ?></p>
                    <?php } ?>
                    <h6>Social Media</h6>
                    <?php if ($user->facebook_url) { ?>
                        <a href="<?= $user->facebook_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-facebook-f"></i> <?= $user->facebook_url; ?></a>
                    <?php } ?>
                    <?php if ($user->whatsapp_url) { ?>
                        <a href="<?= $user->whatsapp_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-whatsapp"></i> <?= $user->whatsapp_url; ?></a>
                    <?php } ?>
                    <?php if ($user->x_url) { ?>
                        <a href="<?= $user->x_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-x-twitter"></i><?= $user->x_url; ?></a>
                    <?php } ?>
                    <?php if ($user->insta_url) { ?>
                        <a href="<?= $user->insta_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i> <?= $user->insta_url; ?></a>
                    <?php } ?>
                </div>
            </div>

            <div class="card mt-2 mb-2">
                <div class="card-body">
                    <h5>Share Safari Experience</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?= $this->render('_following_card', ['user' => $user]) ?>

            <div class="card mt-2 mb-2">
                <div class="card-body">
                    <h5>Instagram</h5>
                </div>
            </div>


            <div class="card mt-2 mb-2">
                <div class="card-body">
                    <h5>Organized Shared Safari <?= $model_count ?></h5>
                    <?php if ($model) {
                        foreach ($model as $share_safari) {
                    ?>
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
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>