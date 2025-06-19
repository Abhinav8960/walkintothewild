<?php

use common\models\CallLog;
use common\models\CallLogSearch;

$date_range = Yii::$app->request->get('CallLogSearch')['date_range'] ?? null;
$start_date = $end_date = null;

if (!is_null($date_range) && strpos($date_range, ' - ') !== false) {
    list($start_date, $end_date) = explode(' - ', $date_range);
    // $start_date .= ' 00:00:00';
    // $end_date .= ' 23:59:59';
}

$call_request = CallLog::find()->andFilterWhere(['between', 'datetime', $start_date, $end_date])->count();
$call_dialed_succesfully = CallLog::find()->where(['status'=>CallLog::STATUS_ACTIVE])->andFilterWhere(['between', 'datetime', $start_date, $end_date])->count(); 
$users_called = CallLog::find()->select('request_caller_1_user_id')->andFilterWhere(['between', 'datetime', $start_date, $end_date])->distinct()->count();

?>

<div class="row ">
    <div class="col-md-12 d-flex">
        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Call Requests</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= $call_request ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Successfull Calls</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= $call_dialed_succesfully ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Dialed Users</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= $users_called ?></div>
                </div>
            </div>
        </div>

    </div>

</div>