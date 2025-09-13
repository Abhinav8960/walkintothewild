<?php

use common\models\transaction\Transaction;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Transaction Info';
$this->params['title'] = $this->title;
?>

<div class="tab-content" id="pills-tabContent">
    <div class="response">
        <div class="col-xl-12">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                <!-- BEGIN col-6 -->
                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'status' => Transaction::STATUS_INITIATED]) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Initated Transaction</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= $initiated_count ?></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'status' => Transaction::STATUS_FAILED]) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Failed Transaction</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= $failed_count ?></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'status' => Transaction::STATUS_SUCCESS]) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Success Transaction</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= $success_count ?></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?= $this->render('_search', ['model' => $searchModel]) ?>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Reference/Order No',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->reference_id . ' / ' . $model->order_id;
                        }
                    ],
                    [
                        'label' => 'Operator',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->partner->business_name ?? '';
                        }
                    ],
                    [
                        'label' => 'User',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = $model->name;
                            $str .= "<br>";
                            $str .= $model->email;
                            $str .= "<br>";
                            $str .= $model->phone;
                            return $str;
                        }
                    ],

                    [
                        'label' => 'Quotation',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = "Park: " . $model->safaris;
                            $str .= "<br>";
                            $str = "Safaris: " . $model->safaris;
                            $str .= "<br>";
                            $str .= "Sravelers: " . $model->travelers;
                            $str .= "<br>";
                            $str .= "Stay Category: " . $model->staycatgory_lable;
                            $str .= "<br>";
                            $str .= "Start date: " . $model->start_date;
                            $str .= "<br>";
                            $str .= "End date: " . $model->end_date;

                            return $str;
                        }
                    ],
                    [
                        'label' => 'Amount',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->received_amount;
                        }
                    ],
                    [
                        'label' => 'Device info',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = "Device: " . $model->device;
                            $str .= "<br>";

                            $str .= "Platform: " . $model->platform;
                            $str .= "<br>";

                            $str .= "Platform Version: " . $model->platform_version;
                            $str .= "<br>";

                            $str .= "Application Version: " . $model->application_version;
                            return $str;
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statusLabel;
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>