<?php

use yii\helpers\Url;


$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<div class="row my-4">
    <div class="col-12">
        <div class="wrapper-skybgsafri p-4 pb-2">
            <div class="row">
                <?php
                if ($history_model) {
                    $counter = 1;
                    $previous_history_model = null;
                    foreach ($history_model as $share_safari) {
                        $samepark = $previous_history_model && strcmp($previous_history_model->park->title, $share_safari->park->title) != 0;
                        $same_no_of_safaris = $previous_history_model && strcmp($previous_history_model->no_of_safari, $share_safari->no_of_safari) != 0;
                        $same_total_seat = $previous_history_model && strcmp($previous_history_model->total_seat, $share_safari->total_seat) != 0;
                        $same_share_seat = $previous_history_model && strcmp($previous_history_model->share_seat, $share_safari->share_seat) != 0;
                        $same_estimate_min_price = $previous_history_model && strcmp($previous_history_model->estimate_price_min, $share_safari->estimate_price_min) != 0;
                        $same_estimate_max_price = $previous_history_model && strcmp($previous_history_model->estimate_price_max, $share_safari->estimate_price_max) != 0;
                ?>
                        <div class="card card_history col-6">
                            <?php if ($counter != 1) { ?>
                                <h6>Previous</h6>
                            <?php } else { ?>
                                <h6 style="color:green">Current Updated</h6>
                            <?php } ?>
                            <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                            <h5 class="mb-0" style="<?= ($samepark) ? 'background-color:yellow' : '' ?>"><?= $share_safari->park->title ?></h5>
                            <p class="mb-0 pt-2">Organized by <strong><?= $share_safari->user->name ?> (Wildlife
                                    Influencer)</strong></p>
                            <p class="mb-0 pt-2" style="<?= ($same_no_of_safaris) ? 'background-color:yellow' : '' ?>">Safaris <strong><?= $share_safari->no_of_safari ?></strong></p>
                            <p class="mb-0 pt-2" style="<?= ($same_total_seat) ? 'background-color:yellow' : '' ?>">Total Seat <strong><?= $share_safari->total_seat ?></strong></p>
                            <p class="mb-0 pt-2" style="<?= ($same_share_seat) ? 'background-color:yellow' : '' ?>">Share Seat <strong><?= $share_safari->share_seat ?></strong></p>
                            <p class="mb-0 pt-2" style="<?= ($same_estimate_min_price) ? 'background-color:yellow' : '' ?>">Estimate Min Price <strong><?= $share_safari->estimate_price_min ?></strong></p>
                            <p class="mb-0 pt-2" style="<?= ($same_estimate_max_price) ? 'background-color:yellow' : '' ?>">Estimate Max Price <strong><?= $share_safari->estimate_price_max ?></strong></p>
                        </div>
                <?php $counter++;
                        $previous_history_model = $share_safari;
                    }
                } ?>
            </div>
        </div>
    </div>
</div>