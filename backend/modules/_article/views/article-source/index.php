<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Article Source';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<?php
// Debugging statements to inspect the dataProvider
// echo '<pre>';
// print_r($dataProvider->getModels());
// echo '</pre>';
// die; // Uncomment this line if you want to stop execution after debugging
?>
<?php Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
]); ?>

<div class="card">
    <div class="card-body">
        <div class="mb-3">
            <?= Html::a('Create', ['create'], ['class' => 'btn btn-orange', 'title' => 'Create']) ?>
        </div>

        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // [
                    //     'label' => 'Article Source',
                    //     'contentOptions' => ['style' => 'width: 30%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->article_source;
                    //     }
                    // ],

                    [
                        'attribute' => 'article_source',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->article_source, ['view', 'id' => $model->id], [
                                'style' => 'color: black !important;',
                                'title' => 'View',
                            ]);
                        },
                        'contentOptions' => ['style' => 'width: 30%; text-align: left;'],
                    ],

                    [
                        'label' => 'Publisher',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->publisher;
                        }
                    ],
                    [
                        'label' => 'Category',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->category_id) ? GeneralModel::categoryoption()[$model->category_id] : '';
                        }
                    ],

                    [
                        'label' => 'Frequency',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->frequency_id) ? GeneralModel::frequencyoption()[$model->frequency_id] : '';
                        }
                    ],

                    [
                        'label' => 'Link',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->web_link, $model->web_link, [
                                'target' => '_blank',
                                'style' => 'color: blue !important;',
                            ]);
                        }
                    ],



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
                        'template' => '&nbsp;{update}&nbsp;&nbsp;{delete}',
                        'buttons' => [
                            // 'view' => function ($url, $model) {
                            //     return  Html::a('<img src="/img/view.png" alt="" width="25" height="25">
                            //     ', ['view', 'id' => $model->id], [
                            //         'class' => 'btn p-0 change-menuicon',
                            //         'name' => 'View',
                            //     ]);
                            // },
                            'update' => function ($url, $model) {
                                return  Html::a('<img src="/img/update.png" alt="" width="25" height="25">
                                ', ['update', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'name' => 'Update',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return  Html::a('<img src="/img/delete.png" alt="" width="25" height="25">', ['delete', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'name' => 'Delete',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete  ' . $model->article_source . '?',
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

<?php Pjax::end(); ?>