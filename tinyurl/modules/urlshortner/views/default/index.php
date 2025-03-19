<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;


$webasset = $this->assetManager->getBundle('\tinyurl\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Url Shortner';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange ', 'title' => 'Create']);

?>


<div class="card">

    <div class="card-body">
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                    ],

                    [
                        'label' => 'Url',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->shortner_url;
                        }
                    ],
                    [
                        'label' => 'Short Id',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->short_id, ['/site/redirect-url', 'short_id' => $model->short_id], [
                                'style' => 'color: black !important;',
                                'title' => 'View',
                                'target' => '_blank',
                            ]);
                        },
                        'contentOptions' => ['style' => 'width: 30%; text-align: left;'],
                    ],

                    [
                        'label' => 'Code',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->code;
                        }
                    ],

                    [
                        'label' => 'Alias',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->alias;
                        }
                    ],

                    [
                        'label' => 'Status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>