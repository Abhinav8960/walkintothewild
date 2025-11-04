<?php

use api\models\sharesafari\ShareSafariIntrested;
use common\models\GeneralModel;
use common\models\sharesafari\ShareSafari;

$query = ShareSafari::find()
    ->select("count(id) as total_data")
    ->where(['!=', 'status', ShareSafari::STATUS_DELETE])
    ->andFilterWhere([
        'park_id' => $model->park_id,
        'host_type' => $model->host_type
    ]);
if (!empty($model->start_date) && !empty($model->end_date)) {
    $query->andFilterWhere(['between', 'start_date', $model->start_date, $model->end_date]);
}
$total_safari = $query->asArray()->one();


$query1 = ShareSafari::find()
    ->select("COUNT(DISTINCT host_user_id) as total_data")
    ->where(['!=', 'status', ShareSafari::STATUS_DELETE])
    ->andFilterWhere([
        'park_id' => $model->park_id,
        'host_type' => $model->host_type
    ]);
if (!empty($model->start_date) && !empty($model->end_date)) {
    $query1->andFilterWhere(['between', 'start_date', $model->start_date, $model->end_date]);
}
$total_unique_host = $query1->asArray()->one();


$query2 = ShareSafariIntrested::find()
    ->select([
        "COUNT(DISTINCT share_safari_intrested.user_id) as total_unique_joined",
        "COUNT(share_safari_intrested.user_id) as total_joined"
    ])
    ->where(['share_safari_intrested.status' => ShareSafariIntrested::STATUS_ACTIVE])
    ->joinWith(['sharesafari'])
    ->andWhere(['!=', 'share_safari.status', ShareSafari::STATUS_DELETE])
    ->andFilterWhere([
        'share_safari.host_type' => $model->host_type,
        'share_safari.park_id' => $model->park_id,
    ]);
if (!empty($model->start_date) && !empty($model->end_date)) {
    $query2->andFilterWhere(['between', 'intrested_at', strtotime($model->start_date), strtotime($model->end_date)]);
}

$joined = $query2->asArray()->one();


?>

<div class="row ">
    <div class="col-md-12 d-flex">
        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Total Safari</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= GeneralModel::numberformat($total_safari['total_data']) ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px; border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Total Unique Host</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= GeneralModel::numberformat($total_unique_host['total_data']) ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px; border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Total Unique joined</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= GeneralModel::numberformat($joined['total_unique_joined']) ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px; border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Total joined</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= GeneralModel::numberformat($joined['total_joined']) ?></div>
                </div>
            </div>
        </div>

    </div>

</div>