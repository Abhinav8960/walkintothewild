<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Article';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
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
                    //     'label' => 'Article Title',
                    //     'contentOptions' => ['style' => 'width: 15%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return Html::tag('div', $model->article_title, [
                    //             'style' => 'display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;',
                    //         ]);
                    //     }
                    // ],



                    [
                        'attribute' => 'article_title',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->article_title, ['view', 'id' => $model->id], [
                                'style' => 'color: black !important;',
                                'title' => 'View',
                            ]);
                        },
                        'contentOptions' => ['style' => 'width: 20%; text-align: left;'],
                    ],



                    [
                        'label' => 'Writer',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::tag('div', $model->writer, [
                                'style' => 'display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;',
                            ]);
                        }
                    ],
                    [
                        'label' => 'Article Source',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->source) ? GeneralModel::sourceoption()[$model->source] : '';
                        }
                    ],

                    [
                        'label' => 'Post Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => ['date', 'php:Y-m-d'],
                        'value' => function ($model) {
                            return $model->post_date;
                        }
                    ],


                    [
                        'label' => 'Abstract',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::tag('div', $model->key_point, [
                                'style' => 'display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;',
                            ]);
                        }
                    ],
                    [
                        'label' => 'Tags',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            // Decode the tag_id if it's a JSON string, otherwise use it directly
                            $tagIds = is_string($model->tag_id) ? json_decode($model->tag_id, true) : $model->tag_id;

                            if (!empty($tagIds) && is_array($tagIds)) {
                                // Initialize an array to store tag names
                                $tagNames = [];

                                // Loop through each tag ID and fetch its name
                                foreach ($tagIds as $tagId) {
                                    // Get the tag name from the options list, default to 'Unknown' if not found
                                    $tagNames[] = GeneralModel::articletagoption()[$tagId] ?? 'Unknown';
                                }

                                // Convert the array of tag names into a comma-separated string
                                return implode(', ', $tagNames);
                            } else {
                                return ''; // Return empty string if tagIds is empty or not an array
                            }
                        }
                    ],
                    [
                        'label' => 'Link',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->link, $model->link, [
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
                        // 'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
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
                                        'confirm' => 'Are you sure you want to delete  ' . $model->article_title . '?',
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