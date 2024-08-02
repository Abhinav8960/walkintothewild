<?php

use yii\helpers\Url;
use common\models\sharesafari\ShareSafari;

$shared_safari_list = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'type' => ShareSafari::TYPE_FIXED_DEPARTURE, 'host_user_id' => $operator->id])->limit(3)->all();

?>

<div class="request_quote mt-4">
    <button class="intested_btn interestBtn d-flex justify-content-between" value="#" style="background-color: var(--background-primary) !important;">
        Organized Safari <span><?= count($shared_safari_list); ?></span></button>
    <div class="interst_wrapper py-4 px-md-5 bg-white">

        <?php if ($shared_safari_list) { ?>
            <div class="row justify-content-center">
                <?php
                foreach ($shared_safari_list as $share_safari) {
                ?>
                    <div class="col-md-12 mb-4 padding_righ">
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
                                    <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><?= isset($share_safari->park) ? $share_safari->park->title : '' ?></a></h6>
                                    <div class="orgnizer">
                                        <p>Organized by: <strong><?= $share_safari->organizedbyname ?></strong></p>
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
                ?>
            </div>

            <div class="col-12">
                <div class="safari text-end">
                    <div class="viewAllreview">
                        <a href="<?= \yii\helpers\Url::toRoute(['/operator/default/sharedsafari', 'slug' => $operator->slug, '#' => 'memberview']) ?>">View All</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>