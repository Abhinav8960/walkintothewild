<?php

use common\models\transaction\Transaction;
use yii\grid\GridView;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\accounts\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Transaction Info';
$this->params['title'] = $this->title;
?>


<div class="row">
    <div class="col-xxl-10 mb-3">
        <div class="row">
            <div class="col-xxl-12">
                <div class="row">
                    <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                        <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'status' => Transaction::STATUS_SUCCESS]) ?>">
                            <div class="mainCard py-3 px-3">
                                <div class="cardChild">
                                    <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                                        <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                                    </div>
                                    <div class="text-card mb-2">
                                        <p>Success Transaction</p>
                                    </div>
                                    <div class="numbwrCount">
                                        <h3><?= isset($success_transaction) ? $success_transaction : 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                        <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'status' => Transaction::STATUS_INITIATED]) ?>">
                            <div class="mainCard py-3 px-3">
                                <div class="cardChild">
                                    <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                                        <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                                    </div>
                                    <div class="text-card mb-2">
                                        <p>Initated Transaction</p>
                                    </div>
                                    <div class="numbwrCount">
                                        <h3><?= isset($initated_transaction) ? $initated_transaction : 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>

                    <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                        <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'status' => Transaction::STATUS_FAILED]) ?>">
                            <div class="mainCard py-3 px-3">
                                <div class="cardChild">
                                    <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                                        <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                                    </div>
                                    <div class="text-card mb-2">
                                        <p>Failed Transaction</p>
                                    </div>
                                    <div class="numbwrCount">
                                        <h3><?= isset($failed_transaction) ? $failed_transaction : 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<div class="table-wrapper">
    <div class="table-responsive">
        <div class="min-width-table">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n<div class='row align-items-center mt-3'>
                            <div class='col-md-4 text-start mb-2'>{summary}</div>
                            <div class='col-md-4 text-center mb-2'>{pager}</div>
                            <div class='col-md-4'></div>
                        </div>",
                'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
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