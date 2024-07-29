<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="card">
    <div class="card-body p-4">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Travelers',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->travelers;
                        }
                    ],
                    [
                        'label' => 'Start Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->start_date;
                        }
                    ],

                    [
                        'label' => 'Requested By',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user) ? $model->user->name : '';
                        }
                    ],

                    [
                        'label' => 'User IP Address',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ip_address;
                        }
                    ],
                    [
                        'label' => 'User OS',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->os;
                        }
                    ],
                    [
                        'label' => 'User Browser',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->browser;
                        }
                    ],
                    [
                        'label' => 'User Device Type',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->device_type;
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>