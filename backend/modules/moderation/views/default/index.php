<?php

/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Moderation';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange ', 'title' => 'Create']);

?>
<div class="card">

    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'Type',
                        'label' => 'Type',
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'value' => function ($model) {
                            if ($model->type == 2) {
                                return 'Video';
                            } elseif ($model->type == 3) {
                                return 'Image';
                            }
                            return 'Unknown';
                        },
                    ],
                    [
                        'attribute' => 'content',
                        'label' => 'Content',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->type == 2) {
                                return "<video width='320' height='240' controls>
                                        <source src='" . Yii::$app->params['cloud_front_url'] . $model->video_url . "' type='video/mp4'>
                                        </video>";
                            } elseif ($model->type == 3) {
                                // return  "<img src='" . \Yii::$app->params['cloud_front_url'] .  $model->image_url . "' alt='' height='240px' width='320px'>";
                                return Html::img(\Yii::$app->params['cloud_front_url'] . $model->image_url, ['alt' => 'Uploaded Image', 'height' => '240px', 'width' => '320px']);
                            }
                            return 'Unknown';
                        },
                    ],
                    [
                        'label' => 'Meta Data',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->type == 2 && $model->videoMetadata) {
                                $attributes = [];
                                foreach ($model->videoMetadata->metaAttributes as $key => $value) {
                                    $attributes[] = "<strong>" . $key . ":</strong> " . $value;
                                }
                                return implode('&nbsp;&nbsp;|&nbsp;&nbsp;', $attributes);
                            } else if ($model->type == 3 && $model->imageMetadata) {
                                $attributes = [];
                                foreach ($model->imageMetadata->metaAttributes as $key => $value) {
                                    $attributes[] = "<strong>" . $key . ":</strong> " . $value;
                                }
                                return implode('&nbsp;&nbsp;|&nbsp;&nbsp;', $attributes);
                            }
                            return null;
                        },
                    ],
                    [
                        'label' => 'Moderation Details',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->type == 2) {
                                return $model->indexVideotags;
                            }
                            if ($model->type == 3) {
                                return $model->indexImageDetails;
                            }
                            return null;
                        },
                    ],

                    [
                        'label' => 'Duration Flag',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->type == 2) {
                                return $model->duration_flag == 1 ? 'Yes' : 'No';
                            }
                        },
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'template' => '{view}&nbsp',

                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['/moderation/default/view', 'id' => $model->id], [
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