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
                                        <source src='" . Yii::$app->params['cloud_front_url'] . $model->video_url . "' type='video/mp4'>
                                        </video>";
                            } elseif ($model->type == 3) {
                                return  $model->image_url;
                            }
                            return 'Unknown';
                        },
                    ],

                    [
                        'attribute' => 'moderation_details',
                        'label' => 'Moderation Details',
                        'format' => 'raw',
                        'value' => function ($model) {

                            if ($model->type == 1) {
                                return $model->moderationTextDetails;
                            }

                            if ($model->type == 2) {
                                return $model->tags;
                            }
                        },
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>