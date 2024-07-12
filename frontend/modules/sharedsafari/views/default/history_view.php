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
                $counter = 0;
                foreach ($history_model as $share_safari) { ?>
                    <div class="table_design">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="th_history">New updated</th>
                                    <th class="th_history">Previous</th>
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
                                            <p class="mb-0 pt-2">Safaris <strong><?= $share_safari->no_of_safari ?></strong></p>
                                            <p class="mb-0 pt-2">Total Seat <strong><?= $share_safari->total_seat ?></strong></p>
                                            <p class="mb-0 pt-2">Share Seat <strong><?= $share_safari->share_seat ?></strong></p>
                                            <p class="mb-0 pt-2">Estimate Min Price <strong><?= $share_safari->estimate_price_min ?></strong></p>
                                            <p class="mb-0 pt-2">Estimate Max Price <strong><?= $share_safari->estimate_price_max ?></strong></p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="card card_history mb-1 h-100">
                                            <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                                            <h5 class="mb-0"><?= $share_safari->park->title ?></h5>
                                            <p class="mb-0 pt-2">Organized by <strong><?= $share_safari->user->name ?> (Wildlife
                                                    Influencer)</strong></p>
                                            <p class="mb-0 pt-2">Safaris <strong><?= $share_safari->no_of_safari ?></strong></p>
                                            <p class="mb-0 pt-2">Total Seat <strong><?= $share_safari->total_seat ?></strong></p>
                                            <p class="mb-0 pt-2">Share Seat <strong><?= $share_safari->share_seat ?></strong></p>
                                            <p class="mb-0 pt-2">Estimate Min Price <strong><?= $share_safari->estimate_price_min ?></strong></p>
                                            <p class="mb-0 pt-2">Estimate Max Price <strong><?= $share_safari->estimate_price_max ?></strong></p>
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</div>