<?php

use common\models\GeneralModel;
use common\models\SmsLog;
use common\models\User;

$date_range = Yii::$app->request->get('SmsLogSearch')['date_range'] ?? null;
$start_date = $end_date = null;

if (!is_null($date_range) && strpos($date_range, ' - ') !== false) {
    list($start, $end) = explode(' - ', $date_range);
    $start_date = strtotime($start . ' 00:00:00');
    $end_date = strtotime($end . ' 23:59:59');
    $date_range = null;
}

$user_generate = SmsLog::find()->select('user_id')->andFilterWhere(['between', 'sms_send_time', $start_date, $end_date])->distinct()->count();
$sms_delivered = SmsLog::find()->where(['is_deliver' => SmsLog::STATUS_DELIVERD])->andFilterWhere(['between', 'sms_send_time', $start_date, $end_date])->count();
$sms_send      = SmsLog::find()->where(['!=', 'sms_send_time', ''])->andFilterWhere(['between', 'sms_send_time', $start_date, $end_date])->count();

$total_user_verified = User::find()->where(['is_mobile_no_verified' => 1])->andFilterWhere(['between', 'mobile_no_verified_at', $start_date, $end_date])->count();

?>

<div class="row ">
    <div class="col-md-12 d-flex">

        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Sms Send</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= $sms_send ?></div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Sms Delivered</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= $sms_delivered ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">Total User Verified</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= $total_user_verified ?></div>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-2">
            <div class="card mb-3 " style="min-height: 120px;  border: 2px solid green; border-radius: 8px;">
                <div class="card-body position-relative">
                    <h5 class=" text-opacity-80 mb-3 fs-16px">User Generated</h5>
                    <div class="  text-opacity-80 text-end colorammount">Count: <?= $user_generate ?></div>
                </div>
            </div>
        </div> -->




    </div>

</div>