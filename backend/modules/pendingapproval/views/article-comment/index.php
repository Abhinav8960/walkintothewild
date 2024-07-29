<?php

use common\models\GeneralModel;
use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;



$this->title = 'Pending Article Comment';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'Pending Approvals', 'url' => '/pendingapproval/article-comment/index'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
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
                        'label' => 'Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->article_date) ? date('M d, Y', strtotime($model->article_date)) : '';
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
                                if (isset(GeneralModel::topicoption()[$topic->master_article_topic_id])) {
                                    $html .= GeneralModel::topicoption()[$topic->master_article_topic_id] . ', ';
                                }
                            }
                            return $html;
                        }
                    ],
                    [
                        'label' => 'Tag',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '';
                            $tags = $model->articletags;
                            foreach ($tags as $key => $tag) {
                                if (isset(GeneralModel::tagoption()[$tag->master_article_tag_id])) {
                                    $html .= GeneralModel::tagoption()[$tag->master_article_tag_id] . ', ';
                                }
                            }
                            return $html;
                        }
                    ],
                    [
                        'label' => 'Comment Count',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->articlecomments) {
                                return count($model->articlecomments);
                            } else {
                                return 0;
                            }
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
                        'template' => '{comment}',
                        'buttons' => [
                            'comment' => function ($url, $model) {
                                return Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">', ['/cms/article/comment', 'id' => $model->id], ['class' => 'btn p-0 change-menuicon']);
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>