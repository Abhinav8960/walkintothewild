<?php

use yii\helpers\Url;


$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="timeline">
    <ul>
        <?php
        if ($history_model) {
            foreach ($history_model as $share_safari) {
                if ($share_safari['row_number'] != $total_count) { ?>
                    <li class="timeline-item mb-5">
                        <p class="text-muted mb-2 fw-bold"><?= date('Y-m-d', $share_safari['date']) ?></p>
                        <?php
                        foreach ($columns as $column_data) {
                            $value_changed =  strcmp($share_safari[$column_data['previous_column']], $share_safari[$column_data['current_column']]) != 0;

                        ?>
                            <?php if ($value_changed) { ?>
                                <p class="text-muted"><?= $column_data['label'] ?> : from <u><?= $share_safari[$column_data['previous_column']] ?></u> to <u><?= $share_safari[$column_data['current_column']] ?></u></p>
                            <?php } ?>
                        <?php }
                        ?>

                    </li>
                <?php } else { ?>
                    <li class="timeline-item mb-5">
                        <p class="text-muted mb-2 fw-bold"><?= date('Y-m-d', $share_safari['date']) ?></p>
                        <p class="text-muted">Created Share Safari</p>
                    </li>
                <?php } ?>
        <?php
            }
        } ?>
    </ul>
</div>

<style>
    .timeline {
        border-left: 1px solid hsl(0, 0%, 90%);
        position: relative;
        list-style: none;
    }

    .timeline .timeline-item {
        list-style: none;
        position: relative;
    }

    .timeline .timeline-item:after {
        position: absolute;
        display: block;
        top: 0;
    }

    .timeline .timeline-item:after {
        background-color: hsl(0, 0%, 90%);
        left: -38px;
        border-radius: 50%;
        height: 11px;
        width: 11px;
        content: "";
    }
</style>