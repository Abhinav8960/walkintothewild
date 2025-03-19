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
        <?php //echo $this->render('_search', ['model' => $searchModel]); 
        ?>
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
                            if ($model->type == 1) {
                                return 'Text';
                            } elseif ($model->type == 2) {
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
                            if ($model->type == 1) {
                                return  $model->text;
                            } elseif ($model->type == 2) {
                                // return  $model->video_url;
                                return "<video width='320' height='240' controls>
                                        <source src='" . $model->video_url . "' type='video/mp4'>
                                        </video>";
                            } elseif ($model->type == 3) {
                                return  $model->image_url;;
                            }
                            return 'Unknown';
                        },
                    ],

                    [
                        'attribute' => 'description',
                        'label' => 'Description',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->type == 1 && $model->moderationtext) {
                                $badges = [];
                                $badges[] = Html::tag('span', 'Sexual ' . ($model->moderationtext->sexual * 100) . ' %', ['class' => 'badge rounded-pill text-bg-primary', 'style' => 'font-size: 12px;']);
                                $badges[] = Html::tag('span', 'Discriminatory ' . ($model->moderationtext->discriminatory * 100) . ' %', ['class' => 'badge rounded-pill text-bg-danger', 'style' => 'font-size: 12px;']);
                                $badges[] = Html::tag('span', 'Insulting ' . ($model->moderationtext->insulting * 100) . ' %', ['class' => 'badge rounded-pill text-bg-warning', 'style' => 'font-size: 12px;']);
                                $badges[] = Html::tag('span', 'Violent ' . ($model->moderationtext->violent * 100) . ' %', ['class' => 'badge rounded-pill text-bg-secondary', 'style' => 'font-size: 12px;']);
                                $badges[] = Html::tag('span', 'Toxic ' . ($model->moderationtext->toxic * 100) . ' %', ['class' => 'badge rounded-pill text-bg-info', 'style' => 'font-size: 12px;']);
                                $badges[] = Html::tag('span', 'Self Harm ' . ($model->moderationtext->self_harm * 100) . ' %', ['class' => 'badge rounded-pill text-bg-success', 'style' => 'font-size: 12px;']);

                                return implode(' ', $badges);
                            }
                            if ($model->type == 2) {
                                return $model->tags;
                            }
                            // return null;
                        },
                    ],

                    // [
                    //     'class' => 'yii\grid\ActionColumn',
                    //     'header' => "Actions",
                    //     'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                    //     'template' => '{view}',
                    //     'buttons' => [
                    //         'view' => function ($url, $model) {
                    //             return Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">', ['view', 'id' => $model->id], [
                    //                 'class' => 'btn p-0 change-menuicon',
                    //                 'title' => 'View',

                    //             ]);
                    //         },
                    //     ]
                    // ],
                ],
            ]); ?>
        </div>
    </div>
</div>