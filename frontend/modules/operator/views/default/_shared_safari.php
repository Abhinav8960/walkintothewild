<div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-3 gx-lg-5">
    <?php

    use yii\helpers\Url;
    use common\models\GeneralModel;

    foreach ($shared_safaries as $share_safari) { ?>
        <div class="col mb-4 padding_right">
            <div class="sharesafri-card">
                <div class="flotingdate">
                    <div class="icons text-center">
                        <p class="mb-0"><?= date('M', strtotime($share_safari->start_date)) ?></p>
                        <p class="mb-0"><?= date('d', strtotime($share_safari->start_date)) ?></p>
                    </div>
                </div>
                <div class="shareimg">
                    <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><img src="<?= isset($share_safari->park) && isset($share_safari->park->logo) ? $share_safari->park->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhsmall.jpg' ?>" alt=""></a>
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
                                <h6 class="number-safari"><?= $share_safari->total_seat ?></h6>
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
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                <div class="roundes_countuser">
                                    15+
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="safari text-center">
                                <div class="joinsafari">
                                    <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>">Join Safari</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>