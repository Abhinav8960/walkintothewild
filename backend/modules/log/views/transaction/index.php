<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Transaction Log';
$this->params['breadcrumbs_home_url'] = '/log';
$this->params['breadcrumbs'][] =  ['label' => 'Log', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="card">

    <div class="card-body">
        <?php  $this->render('_search', ['model' => $searchModel]); ?>

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
                            return $model->reference_id . ' / ' . $model->reference_id;
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
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Action",
                        'contentOptions' => ['style' => 'width: 11%; text-align: left;'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',

                                ]);
                            },
                        ]
                    ],


                ],
            ]); ?>
        </div>
    </div>
</div>