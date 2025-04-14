<?php

use common\models\sighting\Sighting;
use common\models\UserPosts;
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Sightings';
$this->params['breadcrumbs_home_url'] = '/home/sighting';
$this->params['breadcrumbs'][] =  ['label' => 'Sightings', 'url' => '#'];
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
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'label' => 'Sightings',
                        'value' => function ($model) {
                            return "<div style='text-align: center;'>
                                        <video width='320' height='240' controls>
                                            <source src='" . Yii::$app->params['cloud_front_url'] . $model->filepath . "' type='video/mp4'>
                                        </video>
                                    </div>";
                        }
                    ],
                    'created_at:dateTime:Created at',
                    [
                        'header' => 'Action',
                        'value' => function ($model) {
                            if ($model->status == Sighting::STATUS_ACTIVE) {
                                return Html::a('<i class="fa fa-toggle-on"></i>', ['suspend', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-success',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure to suspend this sighting?',
                                    'title' => 'Suspend Sighting',
                                    'data-bs-toggle' => "tooltip"
                                ]);
                            } else {
                                return Html::a('<i class="fa fa-toggle-off"></i>', ['suspend', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-warning',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure to active this sighting?',
                                    'title' => 'Active Sighting',
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