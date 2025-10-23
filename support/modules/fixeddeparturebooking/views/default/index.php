<?php


use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Fixed Departure Booking';
$this->params['title'] = $this->title;
?>


<div class="table-wrapper">
    <div class="table-responsive">
        <div class="min-width-table">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n<div class='row align-items-center mt-3'>
                            <div class='col-md-4 text-start mb-2'>{summary}</div>
                            <div class='col-md-4 text-center mb-2'>{pager}</div>
                            <div class='col-md-4'></div>
                        </div>",
                'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                    ],
                    [
                        'label' => 'Title',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayShareSafari->share_safari_title <> '' ? $model->displayShareSafari->share_safari_title : 'Untitled';
                        }

                    ],
                    [
                        'label' => 'Start Date',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->displayShareSafari->start_date) ? date('Y-m-d', strtotime($model->displayShareSafari->start_date)) : '';
                        }
                    ],
                    [
                        'label' => 'End Date',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->displayShareSafari->end_date) ? date('Y-m-d', strtotime($model->displayShareSafari->end_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Cut Off Date',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->displayShareSafari->cut_off_date) ? date('Y-m-d', strtotime($model->displayShareSafari->cut_off_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Number Of Safari',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayShareSafari->no_of_safari;
                        }
                    ],
                    [
                        'label' => 'Number Of Seat',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'width: 10%;text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayShareSafari->total_seat;
                        }
                    ],
                    [
                        'label' => 'Share Seat',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'width: 10%;text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $total_seat = $model->displayShareSafari->total_seat ?? 0;
                            $self_occupied_seat = $model->displayShareSafari->self_occupied_seat ?? 0;
                            $booked_seat = $model->displayShareSafari->booked_seat ?? 0;
                            return $total_seat - ($self_occupied_seat + $booked_seat);
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'headerOptions' => ['style' => 'width: 15%; text-align: center;'],
                        'contentOptions' => ['style' => 'width: 15%; text-align: center;'],
                        'template' => '{booked}&nbsp&nbsp',
                        'buttons' => [
                            'booked' => function ($url, $model) {
                                return Html::a(
                                    '<img src="' . $this->params['baseurl'] . '/images/Booked_User.svg" alt="" width="20" height="20">',
                                    Url::toRoute(['booked-user', 'id' => $model->id]),
                                    [
                                        'title' => 'Booked User',
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