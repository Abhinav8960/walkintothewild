<?php

use common\models\CallLog;
use common\models\CallLogSearch;
use common\models\chat\ChatMessage;

$date_range = Yii::$app->request->get('CallLogSearch')['date_range'] ?? null;
$start_date = $end_date = null;

if (!is_null($date_range) && strpos($date_range, ' - ') !== false) {
    list($start_date, $end_date) = explode(' - ', $date_range);
    // $start_date .= ' 00:00:00';
    // $end_date .= ' 23:59:59';
}
$strtotime_start_date = !empty($start_date) ? strtotime($start_date) : null;
$strtotime_end_date = !empty($end_date) ? strtotime($end_date) : null;


$call_request = ChatMessage::find()->andWhere(['status' => 1, 'is_call_request' => 1]);
$call_dialed_attempted = CallLog::find()->where(['status' => CallLog::STATUS_ACTIVE]);
$call_dialed_succesfully = CallLog::find()->where(['status' => CallLog::STATUS_ACTIVE, 'dial_status' => 'ANSWERED']);

if (!empty($strtotime_start_date) && !empty($strtotime_end_date)) {
    $call_request =  $call_request->andFilterWhere(['between', 'created_at', $strtotime_start_date, $strtotime_end_date]);
}
if (!empty($start_date) && !empty($end_date)) {
    $call_dialed_attempted =  $call_dialed_attempted->andFilterWhere(['between', 'datetime', $start_date, $end_date])->count();
    $call_dialed_succesfully =  $call_dialed_succesfully->andFilterWhere(['between', 'datetime', $start_date, $end_date])->count();
    $users_called = $users_called->andFilterWhere(['between', 'datetime', $start_date, $end_date]);
}
$call_request = $call_request->count();
$call_dialed_attempted = $call_dialed_attempted->count();
$call_dialed_succesfully = $call_dialed_succesfully->count();



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
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Calls Dial</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= $call_dialed_attempted ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Calls Connected</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= $call_dialed_succesfully ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Calls Connected</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= $call_dialed_succesfully ?></div>
                </div>
            </div>
        </div>



    </div>

</div>