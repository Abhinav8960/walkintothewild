<?php

use yii\helpers\Url;
use common\models\GeneralModel;
use common\models\sharesafari\ShareSafariIntrested;


$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

?>

<section class="touroprator_section ">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-12">
                <div class="row pt-5 pb-4">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12">
                        <div class="row">
                            <div class=" col-xxl-8 col-lg-">
                                <div class="card card_bodyPadding">
                                    <div class="card-body">
                                        <div class="tab-content_tour active">
                                            <div class="row gx-5 justify-content-center">
                                                <?php
                                                if ($shared_safaries) {
                                                    foreach ($shared_safaries as $share_safari) { ?>
                                                        <div class="col-md-5 mb-4 ">
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
                                                                        <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><?= isset($share_safari->park_id) ? GeneralModel::safariparkoption()[$share_safari->park_id] : '' ?></a></h6>
                                                                        <div class="orgnizer">
                                                                            <p>Organized by: <strong><?= isset($share_safari->user) ? $share_safari->user->name : '' ?></strong></p>
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
                                                                                    }
                                                                                };
                                                                                $count = $share_safari->getIntrested()->count();
                                                                                $avatar_count = 3;
                                                                                $data = $count - $avatar_count;
                                                                                if ($data > 3) {  ?>
                                                                                    <div class="roundes_countuser">
                                                                                        <?= $data ?>+
                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="safari text-center">
                                                                                <div class="joinsafari">
                                                                                    <?php if (Yii::$app->user->identity) {
                                                                                        $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                                                                        if ($share_safari_intrested) { ?>
                                                                                            <a href="<?= Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $share_safari->slug]) ?>" data-method="POST">Leave Safari</a>
                                                                                        <?php } else { ?>
                                                                                            <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>" data-method="POST">Join Safari</a>
                                                                                        <?php  }
                                                                                    } else { ?>
                                                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>" data-method="POST">Join Safari</a>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } else {
                                                    echo '<p class="noData">No Shared Safari Found!</p>';
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
</section>