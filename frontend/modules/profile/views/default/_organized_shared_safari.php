<?php

use yii\helpers\Url;
use common\models\sharesafari\ShareSafari;

if (Yii::$app->user->identity) {
    if ($user->id == Yii::$app->user->identity->id) {
        $model = ShareSafari::find()->where(['host_user_id' => $user->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->orderby(['id' => SORT_DESC])->limit(2)->all();
        $model_count = ShareSafari::find()->where(['host_user_id' => $user->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->count();
    } else {
        $model = ShareSafari::find()->where(['host_user_id' => $user->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->andWhere(['>=', 'start_date', date("Y-m-d")])->orderby(['id' => SORT_DESC])->limit(2)->all();
        $model_count = ShareSafari::find()->where(['host_user_id' => $user->id, 'type' => ShareSafari::TYPE_SAFARI, 'status' => [ShareSafari::STATUS_ACTIVE, ShareSafari::STATUS_FULL_SEAT]])->andWhere(['>=', 'start_date', date("Y-m-d")])->count();
    }
}

?>

<?php if ($model) { ?>
    <div class="request_quote mt-4">
        <button class="intested_btn interestBtn d-flex justify-content-between" value="#" style="background-color: var(--background-primary) !important;cursor:default;">
            Organized Shared Safari <span><?= $model_count ?></span></button>
        <div class="interst_wrapper py-4 px-xxl-5 bg-white">
            <div class="row justify-content-center">
                <?php
                foreach ($model as $share_safari) {
                ?>

                    <div class="col-md-6 col-lg-4 col-xxl-12 col-xl-12 col-sm-6 mb-4 padding_righ">
                        <?= $this->render('@frontend/modules/sharedsafari/views/default/_shared_safari_card', ['share_safari' => $share_safari]) ?>
                    </div>

                <?php }
                ?>
                <div class="col-12">
                    <div class="safari text-end">
                        <div class="viewAllreview">
                            <a href="<?= Url::toRoute(['/profile/share-safari/index', 'user_handle' => $user->user_handle]) ?>" data-pjax="0">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>