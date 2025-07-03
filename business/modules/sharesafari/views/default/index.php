<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Fixed Departure';
$this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'button-created create float-end', 'title' => 'Create']);
?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Title',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a(($model->share_safari_title <> '' ? $model->share_safari_title : 'Untitled'), ['fixed-view', 'id' => $model->id], [
                                'style' => 'color: black !important;',
                                'title' => 'View',
                            ]);
                        }

                    ],
                    [
                        'label' => 'Start Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->start_date) ? date('Y-m-d', strtotime($model->start_date)) : '';
                        }
                    ],
                    [
                        'label' => 'End Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->end_date) ? date('Y-m-d', strtotime($model->end_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Cut Off Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->cut_off_date) ? date('Y-m-d', strtotime($model->cut_off_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Number Of Safari',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->no_of_safari;
                        }
                    ],
                    [
                        'label' => 'Number Of Seat',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->total_seat;
                        }
                    ],
                    // [
                    //     'label' => 'Joined',
                    //     'contentOptions' => ['style' => 'width: 5%; text-align: center;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->intrested) ? Html::button($model->getIntrested()->where(['status' => 1])->count(), [
                    //             'value' => Url::toRoute(['intrested', 'id' => $model->id]),
                    //             'style' => 'color: black !important;',
                    //             'class' => 'intrested btn-danger',
                    //             'title' => 'Intrested',
                    //         ]) : '';
                    //     }
                    // ],

                    // [
                    //     'label' => 'Leaved',
                    //     'contentOptions' => ['style' => 'width: 5%; text-align: center;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->intrested) ? Html::button($model->getIntrested()->where(['status' => 0])->count(), [
                    //             'value' => Url::toRoute(['leaved', 'id' => $model->id]),
                    //             'style' => 'color: black !important;',
                    //             'class' => 'leaved btn-info',
                    //             'title' => 'Leaved',
                    //         ]) : '';
                    //     }
                    // ],
                    // [
                    //     'label' => 'Is Publish on Web/App',
                    //     'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         $str = $model->is_published_on_web == 1 ? '<a href="/sharesafari/default/publish-on-web?id=' . $model->id . '" class="badge badge-success">Yes</a>' : '<a class="badge badge-danger">No</a>';
                    //         $str .= '/';
                    //         $str .= $model->is_published_on_api == 1 ? '<a href="/sharesafari/default/publish-on-api?id=' . $model->id . '" class="badge badge-success">Yes</a>' : '<a class="badge badge-danger">No</a>';
                    //         return $str;
                    //     }
                    // ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statuslabel;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'template' => '{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{suspend}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/update.png" alt="" width="25" height="25">
                                ', ['/sharesafari/default/update', 'id' => $model->id], [
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