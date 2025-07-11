<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
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
                        'headerOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Questions',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->question) ? $model->question : '';
                        }
                    ],
                    [
                        'label' => 'Answers',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->answer) ? $model->answer : '';
                        }
                    ],
                    [
                        'label' => 'Park',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->park) ? $model->park->title : '';
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 20%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a(
                                    '<img src="' . Yii::$app->params['baseurl'] . '/images/update.png" alt="" width="25" height="25">',
                                    ['/faqs/default/update', 'id' => $model->id],
                                    [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'Update',
                                    ]
                                );
                            },
                            // 'view' => function ($url, $model) {
                            //     return Html::a('<i class="mdi mdi-eye"></i>', ['/faqs/default/view', 'id' => $model->id], [
                            //         'class' => 'btn p-0 change-menuicon',
                            //         'title' => 'View',
                            //     ]);
                            // },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
