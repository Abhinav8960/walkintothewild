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
            <?php }
            } ?>
        </div>
    </div>
</div>