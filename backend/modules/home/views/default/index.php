<?php

use common\models\UserPosts;
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'User Posts';
$this->params['breadcrumbs_home_url'] = '/home/default';
$this->params['breadcrumbs'][] =  ['label' => 'User Posts', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

?>
<div class="card">

    <div class="card-body">

        <div id="w1-button" class="mb-3"></div>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'layout' => '{items}',
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'User Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            // return Html::a($model->user->name, ['view', 'id' => $model->id], [
                            //     'style' => 'color: black !important;',
                            //     'title' => 'View',
                            // ]);
                            return isset($model->user) ? $model->user->name : '';
                        },
                        'contentOptions' => ['style' => 'width: 20%; '],
                    ],

                    [
                        'attribute' => 'filepath',
                        'format' => 'html',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'label' => 'Image',
                        'value' => function ($model) {
                            if ($model->filepath) {

                                return Html::img(Yii::$app->params['s3_endpoint'] .'/'. $model->filepath, ['alt' => 'User Posts', 'style' => 'max-width:60px;']);
                            }
                            return '';
                        }
                    ],
                    [
                        'attribute' => 'Caption',
                        'format' => 'raw',
                        'value' => function ($model) {
                            // return Html::a($model->user->name, ['view', 'id' => $model->id], [
                            //     'style' => 'color: black !important;',
                            //     'title' => 'View',
                            // ]);
                            return isset($model->caption) ? $model->caption : '';
                        },
                        'contentOptions' => ['style' => 'width: 20%; '],
                    ],

                    'created_at:dateTime:Created at',
                    [
                        'header' => 'Action',
                        'value' => function ($model) {
                            if ($model->status == UserPosts::STATUS_ACTIVE) {
                                return Html::a('<i class="fa fa-toggle-on"></i>', ['suspend', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-success',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure to suspend this post?',
                                    'title' => 'Suspend Post',
                                    'data-bs-toggle' => "tooltip"
                                ]);
                            } else {
                                return Html::a('<i class="fa fa-toggle-off"></i>', ['suspend', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-warning',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure to active this post?',
                                    'title' => 'Active Post',
                                    'data-bs-toggle' => "tooltip"
                                ]);
                            }
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:5%;'],
                        'contentOptions' => ['style' => 'width:5%;'],
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>