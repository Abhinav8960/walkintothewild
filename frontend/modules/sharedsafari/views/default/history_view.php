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
                ?>
                        <div class="card card_history col-6">
                            <?php if ($counter != 1) { ?>
                                <h6>Previous</h6>
                            <?php } else { ?>
                                <h6 style="color:green">Current Updated</h6>
                            <?php } ?>
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
                <?php $counter++;
                    }
                } ?>
            </div>
        </div>
    </div>
</div>