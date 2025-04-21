<?php


use common\models\GeneralModel;
use common\models\packageapproval\Package;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Package';
$this->params['breadcrumbs_home_url'] = '/package';
$this->params['breadcrumbs'][] =  ['label' => 'Package', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>


<div class="card">
    <div class="card-body">
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
                        'label' => 'Package Name',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->package_name;
                        }
                    ],
                    [
                        'label' => 'Operator Name',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->safarioperator) ? $model->safarioperator->business_name : '';
                        }
                    ],
                    [
                        'label' => 'Cost Per Person',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->cost_per_person;
                        }
                    ],
                    [
                        'label' => 'Live Version',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->live_version;
                        }
                    ],

                    [
                        'label' => 'Pending for Approval',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->approval_status == Package::SEND_FOR_APPROVAL_APPROVAL_STATUS ? '<span class="badge badge-warning">Yes</span>' : '<span class="badge badge-success">No</span>';
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'template' => '{view}{approved}{reject}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['/packageapproval/default/view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',

                                ]);
                            },
                            'approved' => function ($url, $model) {
                                return Html::a(
                                    'Approved',
                                    [Url::toRoute(['#', 'id' => $model->id])],
                                    [
                                        'class' => 'btn btn-warning  m-2',
                                        'title' => 'Approved'
                                    ]
                                );
                            },
                            'reject' => function ($url, $model) {
                                return Html::a(
                                    'Reject',
                                    [
                                        Url::toRoute(['#', 'id' => $model->id])
                                    ],
                                    [
                                        'class' => 'btn btn-info  m-2',
                                        'title' => 'Reject'
                                    ]
                                );
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>