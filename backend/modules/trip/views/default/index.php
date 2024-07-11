<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Package';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl;
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
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Package Name',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->package_name;
                        }
                    ],
                    [
                        'label' => 'Number Of Day',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->no_of_day;
                        }
                    ],
                    [
                        'label' => 'Number Of Night',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->no_of_night;
                        }
                    ],
                    [
                        'label' => 'Number Of Safari',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->no_of_safari;
                        }
                    ],
                    [
                        'label' => 'Start Location',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->start_location;
                        }
                    ],
                    [
                        'label' => 'End Location',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->end_location;
                        }
                    ],
                    [
                        'label' => 'Cost Per Person',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->cost_per_person;
                        }
                    ],

                    [
                        'label' => 'Feature',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '';
                            $features = $model->packagefeatures;
                            foreach ($features as $key => $feature) {
                                if (isset(GeneralModel::packagefeatureoption()[$feature->feature_id])) {
                                    $html .= GeneralModel::packagefeatureoption()[$feature->feature_id] . ', ';
                                }
                            }
                            return $html;
                        }
                    ],

                    [
                        'label' => 'Included',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '';
                            $included = $model->packageincluded;
                            foreach ($included as $key => $data) {
                                if (isset(GeneralModel::packageincludeoption()[$data->include_id])) {
                                    $html .= GeneralModel::packageincludeoption()[$data->include_id] . ', ';
                                }
                            }
                            return $html;
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
                                        'confirm' => 'Are you sure you want to delete  ' . $model->package_name . '?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>