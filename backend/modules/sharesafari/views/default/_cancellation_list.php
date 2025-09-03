<?php


use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Fixed Departure List';
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl;

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
                        'label' => 'Organizer',

                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->organizedbyname) ? $model->organizedbyname : '';
                        }
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
                        'label' => 'Seats',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->total_seat;
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>