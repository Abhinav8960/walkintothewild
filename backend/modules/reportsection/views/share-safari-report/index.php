<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Share Safari Report';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl;

?>
<div class="card">

    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php echo $this->render('_card', ['model' => $searchModel]); ?>

        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Title',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {

                            return $model->share_safari_title <> '' ? $model->share_safari_title : 'Untitled';
                        }
                    ],
                    [
                        'label' => 'Park',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {

                            return isset($model->park) ? $model->park->title : 'Untitled';
                        }
                    ],
                    [
                        'label' => 'Start Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->start_date) ? date('Y-m-d', strtotime($model->start_date)) : '';
                        }
                    ],
                    [
                        'label' => 'End Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->end_date) ? date('Y-m-d', strtotime($model->end_date)) : '';
                        }
                    ],
                    [
                        'header' => 'Number Of<br> Safari',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->no_of_safari;
                        }
                    ],
                    [
                        'header' => 'Number Of<br> Seat',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->share_seat;
                        }
                    ],
                    [
                        'label' => 'Organized By',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user->name) ? $model->user->name : '';
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>