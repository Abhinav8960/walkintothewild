<?php

use yii\helpers\Url;
use common\models\sharesafari\ShareSafari;

$shared_safari_list = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'type' => ShareSafari::TYPE_FIXED_DEPARTURE, 'host_user_id' => $operator->id])->andWhere(['>=', 'start_date', date("Y-m-d")])->limit(3)->all();
$shared_safari_count = ShareSafari::find()->where(['status' => ShareSafari::STATUS_ACTIVE, 'type' => ShareSafari::TYPE_FIXED_DEPARTURE, 'host_user_id' => $operator->id])->andWhere(['>=', 'start_date', date("Y-m-d")])->count();

?>
<?php if ($shared_safari_list) { ?>

    <div class="request_quote ">
        <button class="intested_btn interestBtn d-flex justify-content-between" value="#" style="background-color: var(--background-primary) !important;">
            Organized Safari <span><?= $shared_safari_count ?></span></button>
        <div class="interst_wrapper py-4 px-xxl-5 bg-white">

            <div class="row justify-content-center">
                <?php
                foreach ($shared_safari_list as $share_safari) {
                ?>
                    <div class="col-md-6 col-lg-12 col-sm-6 mb-4 padding_righ">
                        <?= $this->render('@frontend/modules/sharedsafari/views/default/_shared_safari_card', ['share_safari' => $share_safari]) ?>
                    </div>
                <?php }
                ?>
            </div>

            <div class="col-12">
                <div class="safari text-end">
                    <div class="viewAllreview">
                        <a href="<?= \yii\helpers\Url::toRoute(['/operator/default/sharedsafari', 'slug' => $operator->slug]) ?>" data-pjax="0">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>