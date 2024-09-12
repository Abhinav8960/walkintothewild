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
// $this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange ', 'title' => 'Create']);
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
                    // [
                    //     'label' => 'Package Name',
                    //     'contentOptions' => ['style' => 'width: 10%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->package_name;
                    //     }
                    // ],
                    [
                        'label' => 'Package Name',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a($model->package_name, ['/package/preview/index', 'id' => $model->id], [
                                'style' => 'color: black !important;',
                                'title' => 'View',
                            ]);
                        }
                    ],
                    [
                        'label' => 'Info',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '';
                            $html .= 'Number Of Day    : ' . GeneralModel::packagedayoption()[$model->no_of_day]  . '<br>';
                            $html .= 'Number Of Night  : ' . $model->no_of_night . '<br>';
                            $html .= 'Number Of Safari : ' . $model->no_of_safari . '<br>';
                            $html .= 'Start Location   : ' . $model->start_location . '<br>';
                            $html .= 'End Location     : ' . $model->end_location . '<br>';
                            return $html;
                        }
                    ],
                    [
                        'label' => 'Cost Per Person',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->cost_per_person;
                        }
                    ],
                    [
                        'label' => 'Stay Category',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->stay_category_id) ? GeneralModel::packageoption()[$model->stay_category_id] : '';
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
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'template' => '&nbsp;{delete}&nbsp;&nbsp;{suspend}',
                        // 'template' => '{view}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{suspend}',
                        'buttons' => [
                            // 'view' => function ($url, $model) {
                            //     return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                            //     ', ['/package/profile/index', 'package_id' => $model->id], [
                            //         'class' => 'btn p-0 change-menuicon',
                            //         'title' => 'View',

                            //     ]);
                            // },
                            'delete' => function ($url, $model) {
                                if ($model->status != -1) {
                                } else {
                                    return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'active_title' => 'Package', 'suspend_title' => 'Pacakge']);
                                }
                            },
                            'suspend' => function ($url, $model) {
                                return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'active_title' => 'Package', 'suspend_title' => 'Package']);
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>