<?php

use common\models\GeneralModel;
use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Business Request';
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
                        'attribute' => 'business_name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            // return Html::a($model->business_name, ['view', 'id' => $model->id], [
                            //     'title' => 'View',
                            //     'style' => 'color: black !important;'
                            // ]);
                            return $model->business_name;

                        },
                        'contentOptions' => ['style' => 'width: 20%;'],
                    ],
                    [
                        'label' => 'address',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->address;
                        }
                    ],
                    [
                        'label' => 'phone_no',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->phone_no;
                        }
                    ],
                    [
                        'label' => 'email',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->email;
                        }
                    ],
                    [
                        'label' => 'Approved Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->is_approved == 1) {
                                return "Approved";
                            } else if ($model->is_approved == 0) {
                                return "Not Approved";
                            };
                        }
                    ],
                    [
                        'header' => 'Action',
                        'value' => function ($model) {
                            if ($model->is_approved != 1) {
                                return Html::a('<i class="fa fa-toggle-on"></i>', ['approved', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-danger',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure to approved this Business?',
                                    'title' => 'Approved Business',
                                    'data-bs-toggle' => "tooltip"
                                ]);
                            }
                            return '';
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:5%;'],
                        'contentOptions' => ['style' => 'width: 5%; text-align: center;'],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>