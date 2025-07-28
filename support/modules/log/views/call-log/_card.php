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

<section class="listCard mx-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <div class="text-card mb-3">
                            <p>Call Requests</p>
                        </div>
                        <div class="numbwrCount d-flex gap-5">
                            <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                                <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg"
                                    class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                            </div>
                            <?php if ($call_request) { ?>
                                <div class="numbwrCount">
                                    <h3><?= $call_request ?></h3>
                                </div>
                            <?php } else {  ?>
                                <div class="numbwrCount">
                                    <h3>0</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <div class="text-card mb-3">
                            <p>Successfull Calls</p>
                        </div>
                        <div class="numbwrCount d-flex gap-5">
                            <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center" style="background-color: #FFF4EE;">
                                <img src="<?= $this->params['baseurl'] ?>/images/fixeddepa.png"
                                    class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                            </div>
                            <?php if ($call_dialed_succesfully) { ?>
                                <div class="numbwrCount">
                                    <h3><?= $call_dialed_succesfully ?></h3>
                                </div>
                            <?php } else {  ?>
                                <div class="numbwrCount">
                                    <h3>0</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <div class="text-card mb-3">
                            <p>Dialed Users</p>
                        </div>
                        <div class="numbwrCount d-flex gap-5">
                            <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center" style="background-color: #DDFFE7;">
                                <img src="<?= $this->params['baseurl'] ?>/images/package.png"
                                    class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                            </div>
                            <?php if ($call_dialed_attempted) { ?>
                                <div class="numbwrCount">
                                    <h3><?= $call_dialed_attempted ?></h3>
                                </div>
                            <?php } else {  ?>
                                <div class="numbwrCount">
                                    <h3>0</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
    .editBtn a {
        background-color: #237F40;
        color: #ffffff;
        border: 0;
        border-radius: 4px;
        font-size: 15px;
        font-weight: 700;
        padding: 10px 50px;
    }
</style>