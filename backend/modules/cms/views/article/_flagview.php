<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;

?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('d-m-Y', $model->created_at);
                        }
                    ],
                    [
                        'label' => 'Flagged Reason',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->reportreason) ? $model->reportreason->reason : '';
                        }
                    ],
                    [
                        'label' => 'Flagged Reason',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->report_detail;
                        }
                    ],
                    'created_at:dateTime:Created at',
                ]
            ]); ?>
        </div>
    </div>
</div>