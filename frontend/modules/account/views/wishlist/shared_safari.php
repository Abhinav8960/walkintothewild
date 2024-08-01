<?php

use common\models\package\Package;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\UserWishlist;
use yii\helpers\Url;

$this->title = 'Your Wishlist';
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="container mt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12  ">
            <h6 class="fs-3 fw-bold mb-4">Wishlist</h6>
        </div>
        <div class="col-12">
            <div class="card account-settingside mb-5 itenary_tabs">
                <div class="card-body card-body p-4 safartabs">
                    <div class="row ">
                        <div class="col-md-12">
                            <?= $this->render('@frontend/modules/account/views/wishlist/_navbar', ['shared_safari' => 'active']) ?>
                            <div class="tab-content " id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-shared-safari" role="tabpanel" aria-labelledby="pills-shared-safari-tab">
                                    <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-lg-3 gx-lg-4 gx-xxl-5">

                                        <?php if ($wishlist_items) {
                                            foreach ($wishlist_items as $wishlist_item) {
                                                $share_safari_model = ShareSafari::find()->where(['id' => $wishlist_item->item_id])->limit(1)->one();
                                                if (!$share_safari_model) {
                                                    continue;
                                                }

                                        ?>
                                                <div class="col mb-4 padding_righ pt-4">
                                                    <div class="sharesafri-card">
                                                        <div class="flotingdate">
                                                            <div class="icons text-center">
                                                                <p class="mb-0"><?= date('M', strtotime($share_safari_model->start_date)) ?></p>
                                                                <p class="mb-0"><?= date('d', strtotime($share_safari_model->start_date)) ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="floating-watchlist">
                                                            <div class="heart_bx">
                                                                <a href="/sharedsafari/unwishlist/<?= $share_safari_model->slug ?>" data-method="post" style="color:#FD5634;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove to watchlist"><i class="fa-solid fa-heart"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="shareimg">
                                                            <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari_model->slug]) ?>"><img src="<?= $share_safari_model->sharedimagepath ? $share_safari_model->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
                                                        </div>
                                                        <div class="card_body">
                                                            <?php
                                                            $class = '';
                                                            if (Yii::$app->user->identity) {
                                                                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari_model->id, 'status' => 1])->limit(1)->one();
                                                                if ($share_safari_intrested) {
                                                                    $class = 'background-color: #4B4B4B;';
                                                                }
                                                            } ?>
                                                            <div class="top_seats" style='<?= $class ?>'>
                                                                <div class="safari d-flex justify-content-between ">
                                                                    <div class="safarinum d-flex gap-2 align-items-center ">
                                                                        <p class="text_safari">SAFARI</p>
                                                                        <h6 class="number-safari"><?= $share_safari_model->no_of_safari ?></h6>
                                                                    </div>
                                                                    <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                                        <p class="text_safari">SEATS</p>
                                                                        <h6 class="number-safari"><?= $share_safari_model->share_seat ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="titleDate">
                                                                <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari_model->slug]) ?>"><?= $share_safari_model->park->title ?></a></h6>
                                                                <div class="orgnizer">
                                                                    <p>Organized by: <strong><?= $share_safari_model->organizedbyname ?></strong></p>
                                                                </div>
                                                            </div>
                                                            <div class="footer_card row pb-2 px-2 align-items-center">
                                                                <div class="col-6">
                                                                    <div class="users">
                                                                        <?php if ($interests = $share_safari_model->getIntrested()->where(['status' => 1])->limit(3)->all()) {
                                                                            $count = $share_safari_model->getIntrested()->count();
                                                                            $avatar_count = 3;
                                                                            foreach ($interests as $interest) {
                                                                        ?>
                                                                                <img src="<?= $interest->user && $interest->user->avatar <> '' ? $interest->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                                            <?php
                                                                            };
                                                                            $count = $share_safari_model->getIntrested()->count();
                                                                            $avatar_count = 3;
                                                                            $data = $count - $avatar_count;
                                                                            if ($data > 3) {  ?>
                                                                                <div class="roundes_countuser">
                                                                                    <?= $data ?>+
                                                                                </div>
                                                                            <?php }
                                                                        } else { ?>
                                                                            <img src="<?= $share_safari_model->user && $share_safari_model->user->avatar <> '' ? $share_safari_model->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="safari text-center">
                                                                        <div class="joinsafari">
                                                                            <?php if ($share_safari_model->status == 2) { ?>
                                                                                <a href="#">Closed Safari</a>
                                                                                <?php } else {
                                                                                if (Yii::$app->user->identity) {
                                                                                    $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari_model->id, 'status' => 1])->limit(1)->one();
                                                                                    if ($share_safari_intrested) { ?>
                                                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/unjoin', 'slug' => $share_safari_model->slug]) ?>" style="background-color: #F5F5F5; border:1px solid #7070704D; color:#4B4B4B;" data-method="POST">Leave Safari</a>
                                                                                    <?php } else if ($share_safari_model->host_user_id != Yii::$app->user->identity->id) { ?>
                                                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari_model->slug]) ?>" data-method="POST">Join Safari</a>
                                                                                    <?php  }
                                                                                } else { ?>
                                                                                    <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari_model->slug]) ?>" data-method="POST">Join Safari</a>
                                                                            <?php }
                                                                            } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php }
                                        } else {
                                            echo 'No Shared Safari found in wishlist';
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