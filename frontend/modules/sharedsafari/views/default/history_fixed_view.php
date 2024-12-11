<?php

use yii\helpers\Url;


$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<div class="row my-4">
    <div class="col-12">
        <div class="wrapper-skybgsafri p-4 pb-2">
            <div class="row justify-content-center gap-5">
                <?php
                if ($history_model) {
                    $counter = 1;
                    $previous_history_model = null;
                    foreach ($history_model as $share_safari) {
                        $samepark = $previous_history_model && strcmp($previous_history_model->park->title, $share_safari->park->title) != 0;
                        $same_no_of_safaris = $previous_history_model && strcmp($previous_history_model->no_of_safari, $share_safari->no_of_safari) != 0;
                        $same_total_seat = $previous_history_model && strcmp($previous_history_model->total_seat, $share_safari->total_seat) != 0;
                        $same_share_seat = $previous_history_model && strcmp($previous_history_model->share_seat, $share_safari->share_seat) != 0;
                        $same_cost_price = $previous_history_model && strcmp($previous_history_model->cost_per_person, $share_safari->cost_per_person) != 0;
                ?>
                        <div class="card card_history col-xl-6 col-mb-6 gap-2">
                            <?php if ($counter != 1) { ?>
                                <h6>Previous</h6>
                            <?php } else { ?>
                                <h6 style="color:green">Current</h6>
                            <?php } ?>
                            <h6><?= date('d M y', strtotime($share_safari->start_date)) ?> - <?= date('d M y', strtotime($share_safari->end_date)) ?></h6>
                           
                            <p class="mb-0 p-2 rounded" style="<?= ($same_no_of_safaris) ? 'background-color:yellow' : '' ?>">Safaris <strong><?= $share_safari->no_of_safari ?></strong></p>
                            <p class="mb-0 p-2 rounded" style="<?= ($same_total_seat) ? 'background-color:yellow' : '' ?>">Total Seat <strong><?= $share_safari->total_seat ?></strong></p>
                            <p class="mb-0 p-2 rounded" style="<?= ($same_share_seat) ? 'background-color:yellow' : '' ?>">Share Seat <strong><?= $share_safari->share_seat ?></strong></p>
                            <p class="mb-0 p-2 rounded" style="<?= ($same_cost_price) ? 'background-color:yellow' : '' ?>">Cost Per Person <strong><?= $share_safari->cost_per_person ?></strong></p>
                        </div>
                <?php $counter++;
                        $previous_history_model = $share_safari;
                    }
                } ?>
            </div>
        </div>
    </div>
</div>

<style>
    .card_history {
        width: 300px !important;
    }
</style>