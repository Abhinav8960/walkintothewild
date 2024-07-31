<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Shared Safari';
$this->params['title'] = $this->title;
?>

<section class="profile-wrapper">
    <div class="container mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['share_safari' => 'active', 'user' => $user]) ?>

    </div>
</section>

<section>
    <div class="container ">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">
                <div class="row justify-content-center ">
                    <div class="col-xxl-11 margin_bottomfooter">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card card_bodyPadding">
                                    <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                    <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;">Shared Safari Organized by <?= Yii::$app->user->identity->id == $user->id ? 'me' : $user->name ?> </h6>
                                            <?php if (Yii::$app->user->identity->id == $user->id) { ?>
                                                <a class="follow_btn text-center mt-sm-0 " href="">View All</a>
                                            <?php } ?>
                                        </div>
                                       
                                        <div class="row gx-5">
                                            <?php if ($organized_by) {
                                                foreach ($organized_by as $share_safari) {
                                            ?>
                                                    <div class="col-md-6 mb-4">
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
                            <div class="col-lg-4">
                                <?= $this->render('@frontend/modules/profile/views/default/_following_card', ['user' => $user]) ?>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>