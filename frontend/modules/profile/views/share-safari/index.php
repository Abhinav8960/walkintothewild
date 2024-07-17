<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Shared Safari';
$this->params['title'] = $this->title;
?>

<div class="container">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['share_safari' => 'active', 'user' => $user]) ?>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">
            <div class="row">
                <div class="col-8">
                    <div class="card mt-2">
                        <div class="card-body">
                            <h5>Shared Safari Organized by <?= $user->name ?> <?= count($organized_by); ?></h5>
                            <?php if ($organized_by) {
                                foreach ($organized_by as $share_safari) {
                            ?>
                                    <div class="col-6 mb-4 padding_righ">
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
                <div class="col-4">
                    <div class="card mt-2">
                        <div class="card-body">
                            <h5>Following</h5>
                            <?php if ($followings = $user->userfollowings) {
                                foreach ($followings as $following) { ?>
                                    <img src="<?= $following->user->profile_image <> '' ?  $following->user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle" width="25" height="25">
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card mt-2">
                        <div class="card-body">
                            <h5>Shared Safari Joined by <?= $user->name ?> <?= count($joined_by); ?></h5>
                            <?php if ($joined_by) {
                                foreach ($joined_by as $share_safari) {
                            ?>
                                    <div class="col-6 mb-4 padding_righ">
                                        <div class="sharesafri-card">
                                            <div class="flotingdate">
                                                <div class="icons text-center">
                                                    <p class="mb-0"><?= date('M', strtotime($share_safari->sharesafari->start_date)) ?></p>
                                                    <p class="mb-0"><?= date('d', strtotime($share_safari->sharesafari->start_date)) ?></p>
                                                </div>
                                            </div>
                                            <div class="shareimg">
                                                <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->sharesafari->slug]) ?>"><img src="<?= $share_safari->sharesafari->sharedimagepath ? $share_safari->sharesafari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
                                            </div>
                                            <div class="card_body">
                                                <div class="top_seats">
                                                    <div class="safari d-flex justify-content-between ">
                                                        <div class="safarinum d-flex gap-2 align-items-center ">
                                                            <p class="text_safari">SAFARI</p>
                                                            <h6 class="number-safari"><?= $share_safari->sharesafari->no_of_safari ?></h6>

                                                        </div>
                                                        <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                            <p class="text_safari">SEATS</p>
                                                            <h6 class="number-safari"><?= $share_safari->sharesafari->share_seat ?></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="titleDate">
                                                    <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->sharesafari->slug]) ?>"><?= $share_safari->sharesafari->park->title ?></a></h6>
                                                    <div class="orgnizer">
                                                        <p>Organized by: <strong><?= $share_safari->sharesafari->user->name ?></strong></p>
                                                    </div>
                                                </div>
                                                <div class="footer_card row pb-2 px-2 align-items-center">
                                                    <div class="col-6">
                                                        <div class="users">
                                                            <?php if ($interests = $share_safari->sharesafari->getIntrested()->where(['status' => 1])->limit(3)->all()) {
                                                                $count = $share_safari->sharesafari->getIntrested()->count();
                                                                $avatar_count = 3;
                                                                foreach ($interests as $interest) {
                                                            ?>
                                                                    <img src="<?= $interest->user && $interest->user->avatar <> '' ? $interest->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                                <?php
                                                                };
                                                                $count = $share_safari->sharesafari->getIntrested()->count();
                                                                $avatar_count = 3;
                                                                $data = $count - $avatar_count;
                                                                if ($data > 3) {  ?>
                                                                    <div class="roundes_countuser">
                                                                        <?= $data ?>+
                                                                    </div>
                                                                <?php }
                                                            } else { ?>
                                                                <img src="<?= $share_safari->sharesafari->user && $share_safari->sharesafari->user->avatar <> '' ? $share_safari->sharesafari->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
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
    </div>
</div>