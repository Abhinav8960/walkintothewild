<?php

use common\models\GeneralModel;
use common\models\transaction\Transaction;
use yii\grid\GridView;
use yii\helpers\Html;
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
                        <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'custom_days' => 1]) ?>">
                            <div class="mainCard py-3 px-3">
                                <div class="cardChild">
                                    <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                                        <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                                    </div>
                                    <div class="text-card mb-2">
                                        <p>Today</p>
                                    </div>
                                    <div class="numbwrCount">
                                        <h3><?= isset($today_success_transaction) ? $today_success_transaction : 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                        <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'custom_days' => 2]) ?>">
                            <div class="mainCard py-3 px-3">
                                <div class="cardChild">
                                    <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                                        <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                                    </div>
                                    <div class="text-card mb-2">
                                        <p>Last 3 Days</p>
                                    </div>
                                    <div class="numbwrCount">
                                        <h3><?= isset($last_three_day_success_transaction) ? $last_three_day_success_transaction : 0 ?></h3>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>

                    <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                        <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'custom_days' => 3]) ?>">
                            <div class="mainCard py-3 px-3">
                                <div class="cardChild">
                                    <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                                        <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                                    </div>
                                    <div class="text-card mb-2">
                                        <p>Last 7 Days</p>
                                    </div>
                                    <div class="numbwrCount">
                                        <h3><?= isset($last_seven_day_success_transaction) ? $last_seven_day_success_transaction : 0 ?></h3>
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
                        'label' => 'Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->transaction_datetime;
                        }
                    ],
                    [
                        'label' => 'Operator',
                        'contentOptions' => ['style' => 'width: 10%;'],
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
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = "Park: " . $model->safaris;
                            $str .= "<br>";
                            $str = "Safaris: " . $model->safaris;
                            $str .= "<br>";
                            $str .= "Travelers: " . $model->travelers;
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
                        'label' => 'Pay Rec PayU',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->payment_received_at_payu == 1) {
                                return '<span style="color: green; font-weight: bold;">Yes</span>';
                            }
                            return '<span style="color: red; font-weight: bold;">No</span>';
                        }
                    ],
                    [
                        'label' => 'Amount',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span style="font-weight: bold; color: #2E8B57; margin-right:5px">₹</span>'
                                . GeneralModel::number_format_indian($model->received_amount);
                        }
                    ],
                    [
                        'label' => 'Rec In Bank',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span style="font-weight: bold; color: #2E8B57; margin-right:5px">₹</span>' . GeneralModel::number_format_indian($model->amount_received_at_bank);
                        }
                    ],
                    [
                        'label' => 'Pay U Charges',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return '<span style="font-weight: bold; color: #2E8B57; margin-right:5px">₹</span>' . GeneralModel::number_format_indian($model->payu_charges);
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statusLabel;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'headerOptions' => ['style' => 'width: 20%; text-align: center;'],
                        'contentOptions' => ['style' => 'width: 20%; text-align: center;'],
                        'template' => '{payU}&nbsp{edit}',
                        'buttons' => [
                            'payU' => function ($url, $model) {
                                if ($model->payment_received_at_payu == 0) {
                                    return Html::a(
                                        'PayU',
                                        [
                                            Url::toRoute(['update-payu-status', 'id' => $model->id]),
                                        ],
                                        [
                                            'data' => [
                                                'confirm' => 'Is Payment Recieved At PayU?',
                                                'method' => 'post',
                                            ],
                                            'class' => 'btn btn-info  m-2',
                                            'title' => 'Approve'
                                        ]
                                    );
                                }
                            },
                            'edit' => function ($url, $model) {
                                if ($model->payment_received_at_payu == 1) {
                                    return Html::button(
                                        '<img src="' . $this->params['baseurl'] . '/images/Edit.svg" alt="" width="20" height="20">',
                                        [
                                            'value' => Url::toRoute(['update-transaction-detail', 'id' => $model->id]),
                                            'title' => 'Update Transaction Detail',
                                            'class' => 'btn btn-link showModalButton',
                                        ]
                                    );
                                }
                            },
                        ]
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>


<div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Action
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS
    $('.showModalButton').on('click', function () {
        $('#modalAction').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
    });
JS;
$this->registerJs($script);
?>