<?php

use api\models\sharesafari\ShareSafariIntrested;
use common\models\GeneralModel;

$query = ShareSafariIntrested::find()
    ->select([
        "COUNT(share_safari_intrested.id) AS total_data",
        "COUNT(DISTINCT CONCAT(share_safari_intrested.user_id)) AS total_unique"
    ])
    ->joinWith('sharesafari')
    ->where(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE])
    ->andWhere(['!=', 'share_safari.status', -1])
    ->andFilterWhere([
        'share_safari.park_id' => $model->park_id,
    ])
    ->andFilterWhere(['like', 'share_safari.share_safari_title', $model->share_safari_title]);

if (!empty($model->start_date) && !empty($model->end_date)) {
    $query->andFilterWhere(['between', 'share_safari_intrested.intrested_at', $model->start_date, $model->end_date]);
}

$total_joined = $query->asArray()->one();



?>

<div class="row ">
    <div class="col-md-12 d-flex">
        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Total Joined</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= GeneralModel::numberformat($total_joined['total_data']) ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Total Unique Joined</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= GeneralModel::numberformat($total_joined['total_unique']) ?></div>
                </div>
            </div>
        </div>

    </div>

</div>