<?php

use common\models\GeneralModel;
use yii\grid\GridView;
?>
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'width: 5%;'],
            ],
            [
                'label' => 'Park',
                'contentOptions' => ['style' => 'width: 15%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return isset($model->park->title) ? $model->park->title : '';
                }
            ],

            [
                'label' => 'Reason',
                'contentOptions' => ['style' => 'width: 15%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return isset($model->report_reason_id) ? GeneralModel::getFlagreasons()[$model->report_reason_id] : '';
                }
            ],

            [
                'label' => 'Flaged By',
                'contentOptions' => ['style' => 'width: 10%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return isset($model->user->name) ? $model->user->name : '';
                }
            ],
        ],
    ]); ?>
</div>