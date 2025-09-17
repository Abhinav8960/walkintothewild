<?php


use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Booked Users';
?>

<div class="card" style="margin-top: 90px;">
    <div class="card-body">
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $shareSafariDataProvider,
                'layout' => "{items}",
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Title',
                        'format' => 'raw',
                        'value' => function ($model) {

                            return $model->share_safari_title <> '' ? $model->share_safari_title : 'Untitled';
                        }

                    ],
                    [
                        'label' => 'Start Date',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->start_date) ? date('Y-m-d', strtotime($model->start_date)) : '';
                        }
                    ],
                    [
                        'label' => 'End Date',
                        'headerOptions' => ['style' => 'width: 10%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->end_date) ? date('Y-m-d', strtotime($model->end_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Cut Off Date',
                        'headerOptions' => ['style' => 'width: 10%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->cut_off_date) ? date('Y-m-d', strtotime($model->cut_off_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Safaris',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->no_of_safari;
                        }
                    ],
                    [
                        'label' => 'Price',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return GeneralModel::number_format_indian($model->cost_per_person);
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>



<div class="card">
    <div class="card-body">
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $bookedDataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'User Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->name;
                        }

                    ],
                    [
                        'label' => 'Email',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->email;
                        }
                    ],
                    [
                        'label' => 'Phone Number',
                        'headerOptions' => ['style' => 'width: 10%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->phone;
                        }
                    ],
                    [
                        'label' => 'Transaction',
                        'headerOptions' => ['style' => 'width: 10%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->transaction_datetime;
                        }
                    ],
                    [
                        'label' => 'No of Seat',
                        'headerOptions' => ['style' => 'width: 10%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->travelers;
                        }
                    ],

                    [
                        'label' => 'Price',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return GeneralModel::number_format_indian($model->received_amount);
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{chat}',
                        'buttons' => [

                            'chat' => function ($url, $model) use ($share_safari) {
                                if ($model->status == 1) {
                                    return Html::a(
                                        '<img src="' . $this->params['baseurl'] . '/img/chat.png" alt="" width="20" height="20">',
                                        Url::toRoute(['booked-user-chat', 'share_safari_id' => $share_safari->id, 'share_safari_lead_id' => $model->share_safari_lead_id]),
                                        [
                                            'title' => 'Chat',
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

<style>
    .details-packages {
        margin-bottom: 20px;
    }

    .thead-details th {
        background-color: #C4E3BD !important;
        padding: 15px;
        text-align: left;
        font-weight: unset;
        color: #333;
    }

    .tbody-leads td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        vertical-align: top;
    }

    .tbody-leads tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .tbody-leads tr:hover {
        background-color: #f0f8ff;
    }

    .price-container {
        display: flex;
        align-items: center;
    }

    .rupee-icon {
        width: 15px;
        margin-right: 5px;
        margin-bottom: 2px;
    }
</style>