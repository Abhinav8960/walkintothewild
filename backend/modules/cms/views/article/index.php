<?php

use common\models\GeneralModel;
use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Article';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('Create',  ['create'], ['class' => 'btn btn-orange', 'title' => 'Create']);
?>
<?php Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
]); ?>

<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'title',
                    [
                        'label' => 'Author Name',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->articleAuthor) ? $model->articleAuthor->author_name : '';
                        }
                    ],
                    [
                        'label' => 'Topics',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '';
                            $topics = $model->articletopics;
                            foreach ($topics as $key => $topic) {
                                if (isset(GeneralModel::topicoption()[$key])) {
                                    $html .= GeneralModel::topicoption()[$key] . ', ';
                                }
                            }
                            return $html;
                        }
                    ],
                    [
                        'label' => 'Tag',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->articletag) ? $model->articletag->title : '';
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statuslabel;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'template' => '{update}&nbsp;&nbsp;{delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return  Html::a('<img src="/img/update.png" alt="" width="25" height="25">
                                ', ['update', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'Update',

                                ]);
                            },

                            'delete' => function ($url, $model) {
                                return  Html::a('<img src="/img/delete.png" alt="" width="25" height="25">', ['delete', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'Delete',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete  ' . $model->title . '?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ]
                    ],
                    [
                        'label' => 'Comment',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a('<img src="/img/view.png" alt="" width="25" height="25">', ['comment', 'id' => $model->id], ['class' => 'btn p-0 change-menuicon']);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>