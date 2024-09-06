<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Untraced Flag';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl;

?>


<div class="card">

    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?php
            if ($searchModel->type) {

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'contentOptions' => ['style' => 'width: 5%;'],
                        ],
                        [
                            'label' => 'Date',
                            'contentOptions' => ['style' => 'width: 15%;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                return date('Y-m-d', $model->created_at);
                            }
                        ],
                        [
                            'attribute' => 'parentname',
                            'contentOptions' => ['style' => 'width: 10%;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->parentname;
                            }
                        ],

                        // [
                        //     'attribute' => 'commentname',
                        //     'contentOptions' => ['style' => 'width: 10%;'],
                        //     'format' => 'raw',
                        //     'value' => function ($model) {
                        //         return $model->commentname;
                        //     }
                        // ],

                        [
                            'label' => 'Creator Name',
                            'contentOptions' => ['style' => 'width: 10%;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                return isset($model->user) ? $model->user->name : '';
                            }
                        ],

                        [
                            'label' => 'Flagged Reason',
                            'contentOptions' => ['style' => 'width: 10%;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                return  isset($model->reportreason) ? $model->reportreason->reason : '';
                            }

                        ],

                        [
                            'label' => 'Flag Details',
                            'contentOptions' => ['style' => 'width: 10%;'],
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->report_detail;
                            }
                        ],

                    ],
                ]);
            } else {
                echo 'Select a Type to View Untraced Flasgs';
            } ?>
        </div>
    </div>
</div>