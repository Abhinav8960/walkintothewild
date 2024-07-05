<?php

use yii\helpers\Url;


$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<div class="row my-4">
    <div class="col-12">
        <div class="wrapper-skybgsafri p-2 pb-2">
            <?php

            if ($history_model) {
                foreach ($history_model as $share_safari) { ?>
                <div class="table_design">
                <table class="table">
                    <thead>
                        <tr>
                        <th class="th_history">Previous</th>
                        <th class="th_history">New updated</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="card card_history mb-1 h-100">
                                     <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                                     <h5 class="mb-0"><?= $share_safari->park->title ?></h5>
                                     <p class="mb-0 pt-2">Organized by <strong><?= $share_safari->user->name ?> (Wildlife
                                                Influencer)</strong></p>
                                </div>
                            </td>
                            <td>
                            <div class="card card_history mb-1 h-100">
                                     <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                                     <h5 class="mb-0"><?= $share_safari->park->title ?></h5>
                                     <p class="mb-0 pt-2">Organized by <strong><?= $share_safari->user->name ?> (Wildlife
                                                Influencer)</strong></p>
                                </div>
                            </td>
                            
                        </tr>
                      
                        
                    </tbody>
                </table>
                </div>
                    <!-- <div class="row border_bottom2 pb-4">
                        <div class="col-lg-7 border-right">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="safritimg">
                                        <img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100">
                                    </div>
                                </div>
                                <div class="col-sm-10 pt-sm-0 pt-3">
                                    <div class="safrititles">
                                        <h5><?= $share_safari->park->title ?></h5>
                                        <div class="date_bx">
                                            <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                                        </div>
                                        <p class="mb-0 pt-2">Organized by <strong><?= $share_safari->user->name ?> (Wildlife
                                                Influencer)</strong></p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 pt-lg-0 pt-4">
                            <div class="row px-sm-4 px-0">
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/safari_4391688.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= $share_safari->no_of_safari ?> Safaris</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/car-seat_5102816.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">Available Seats - <?= $share_safari->total_seat ?>/<?= $share_safari->share_seat ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/camera.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?php
                                                            if ($share_safari->share_safari_agenda_id == 1) {
                                                                echo "Photography";
                                                            } elseif ($share_safari->share_safari_agenda_id == 2) {
                                                                echo "Vlogging";
                                                            } elseif ($share_safari->share_safari_agenda_id == 3) {
                                                                echo "Safari Experience";
                                                            } ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6  mb-3">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/resort_11834952.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0">Premium</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 ">
                                    <div class="safridetails_form d-flex gap-3 align-items-center">
                                        <div class="iconImg">
                                            <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/rupee_3104891.png" alt="">
                                        </div>
                                        <div class="text-form">
                                            <p class="mb-0"><?= $share_safari->estimate_price_min ?>- <?= $share_safari->estimate_price_max ?> Estimate Per Person Cost</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
            <?php }
            } ?>
        </div>
    </div>
</div>