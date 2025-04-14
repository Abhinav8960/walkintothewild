<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Payment Links';
$this->params['breadcrumbs'][] = ['label' => 'Payment Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl;
// $this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange ', 'title' => 'Create']);
?>


<div class="card">

    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],

                    [
                        'label' => 'objective',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->objective;
                        }
                    ],

                    [
                        'label' => 'Title',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->objective;
                        }
                    ],

                    [
                        'label' => 'External Link for User',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->link_hash;
                        }
                    ],
                    [
                        'label' => 'Payment Gateway Link',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->link;
                        }
                    ],



                    [
                        'label' => 'purpose',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->purpose) ? $model->purpose : '';
                        }
                    ],
                    [
                        'label' => 'Customer Name',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->customer_name) ? $model->customer_name : '';
                        }
                    ],
                    [
                        'label' => 'Email',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->email) ? $model->email : '';
                        }
                    ],
                    [
                        'label' => 'Phone No',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->phone_no) ? $model->phone_no : '';
                        }
                    ],
                    // [
                    //     'label' => 'Gross Amount',
                    //     'contentOptions' => ['style' => 'width: 10%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->gross_amount) ? $model->gross_amount : '';
                    //     }
                    // ],
                    // [
                    //     'label' => 'Discount Amount',
                    //     'contentOptions' => ['style' => 'width: 10%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->discount_amount) ? $model->discount_amount : '';
                    //     }
                    // ],
                    // [
                    //     'label' => 'Total Amount',
                    //     'contentOptions' => ['style' => 'width: 10%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->total_amount) ? $model->total_amount : '';
                    //     }
                    // ],
                    // [
                    //     'label' => 'GST Amount',
                    //     'contentOptions' => ['style' => 'width: 10%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->gst_amount) ? $model->gst_amount : '';
                    //     }
                    // ],
                    [
                        'label' => 'Net Amount',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->net_amount) ? $model->net_amount : '';
                        }
                    ],
                    [
                        'label' => 'Link Expiry Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->link_expiry_datetime) ? $model->link_expiry_datetime : '';
                        }
                    ],
                    [
                        'label' => 'Link Generated Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->link_generated_datetime) ? $model->link_generated_datetime : '';
                        }
                    ],
                    [
                        'label' => 'Payment Initiated Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->payment_initiated_datetime) ? $model->payment_initiated_datetime : '';
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statuslabel;
                        }
                    ],

                    // [
                    //     'class' => 'yii\grid\ActionColumn',
                    //     'header' => "Actions",
                    //     'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                    //     'template' => '&nbsp;{delete}&nbsp;&nbsp;{suspend}',
                    //     'template' => '{view}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{suspend}',
                    //     'buttons' => [
                    //         'view' => function ($url, $model) {
                    //             return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                    //             ', ['/package/profile/index', 'package_id' => $model->id], [
                    //                 'class' => 'btn p-0 change-menuicon',
                    //                 'title' => 'View',

                    //             ]);
                    //         },
                    //         'delete' => function ($url, $model) {
                    //             if ($model->status != -1) {
                    //             } else {
                    //                 return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'active_title' => 'Package', 'suspend_title' => 'Pacakge']);
                    //             }
                    //         },
                    //         'suspend' => function ($url, $model) {
                    //             return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'active_title' => 'Package', 'suspend_title' => 'Package']);
                    //         },
                    //     ]
                    // ],
                ],
            ]); ?>
        </div>
    </div>
</div>