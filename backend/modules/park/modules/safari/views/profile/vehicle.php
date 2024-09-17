<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Safari Park Vehicle';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/park/modules/safari/views/profile/_profile_navbar', ['safari_park' => $safari_model, 'vehicle_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">

                    <div class="card-body">
                        <a href="/park/safari/profile/createvehicle?safari_park_id=<?= $safari_model->id ?>" class="btn btn-orange  mt-3 col-md-2 float-end mb-3">+ Create</a>

                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'label' => 'vehicle',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return isset($model->vehicle_id) ? GeneralModel::vehicleoption()[$model->vehicle_id] : '';
                                        }
                                    ],
                                    'created_at:dateTime:Created at',
                                    'updated_at:dateTime:Last Updated at',
                                    [
                                        'label' => 'Status',
                                        'contentOptions' => ['style' => 'width: 5%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->newstatuslabel;
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => "Actions",
                                        'contentOptions' => ['style' => 'width: 20%;'],
                                        'template' => '{update}&nbsp;&nbsp;{delete}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                return  Html::a('<img src="/img/update.png" alt="" width="25" height="25">
                                                 ', ['updatevehicle', 'safari_park_id' => $model->safari_park_id, 'id' => $model->id], [
                                                    'class' => 'btn p-0 change-menuicon',
                                                    'title' => 'Update',

                                                ]);
                                            },

                                            'delete' => function ($url, $model) {
                                                return  Html::a('<img src="/img/delete.png" alt="" width="25" height="25">', ['deletevehicle', 'id' => $model->id], [
                                                    'class' => 'btn p-0 change-menuicon',
                                                    'title' => 'Delete',
                                                    'data' => [
                                                        'confirm' => 'Are you sure you want to delete  ' . isset($model->vehicle_id) ? GeneralModel::vehicleoption()[$model->vehicle_id] : '' . '?',
                                                        'method' => 'post',
                                                    ],
                                                ]);
                                            },
                                        ]
                                    ],
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>