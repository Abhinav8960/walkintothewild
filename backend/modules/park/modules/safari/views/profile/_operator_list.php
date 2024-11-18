<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\bootstrap4\Html;
use yii\grid\GridView;

$this->title = 'Safari Park Operator List';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/park/modules/safari/views/profile/_profile_navbar', ['safari_park' => $safari_model, 'operator_list' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">

                    <div class="card-body">
                        <div id="w1-button" class="mb-3"></div>

                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'label' => 'Operator Name',
                                        'contentOptions' => ['style' => 'width: 40%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return isset($model->operator) ? $model->operator->business_name : '';
                                        }
                                    ],
                                    [
                                        'label' => 'Show in Front',
                                        'contentOptions' => ['style' => 'width: 40%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->show_in_front == 1 ? "Yes" : "No";
                                        }
                                    ],
                                    [
                                        'header' => 'Action',
                                        'value' => function ($model) {
                                            if ($model->show_in_front == 1) {
                                                return Html::a('<i class="fa fa-toggle-on"></i>', ['showoperatorfront', 'id' => $model->id], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-method' => 'post',
                                                    'data-confirm' => 'Are you sure to remove this operator in front?',
                                                    'title' => 'Remove from Front',
                                                    'data-bs-toggle' => "tooltip"
                                                ]);
                                            } else {
                                                return Html::a('<i class="fa fa-toggle-off"></i>', ['showoperatorfront', 'id' => $model->id], [
                                                    'class' => 'btn btn-xs btn-danger',
                                                    'data-method' => 'post',
                                                    'data-confirm' => 'Are you sure to show this operator in front?',
                                                    'title' => 'Show in Front',
                                                    'data-bs-toggle' => "tooltip"
                                                ]);
                                            }
                                        },
                                        'format' => 'raw',
                                        'headerOptions' => ['style' => 'width:5%;'],
                                        'contentOptions' => ['style' => 'width:5%;'],
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