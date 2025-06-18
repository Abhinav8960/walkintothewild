<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Package';
// $this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange float-end', 'title' => 'Create']);
?>


<?php echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="table-wrapper">
    <div class="table-responsive">
        <div class="min-width-table">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n<div class='row align-items-center mt-3'>
                            <div class='col-md-4 text-start mb-2'>{summary}</div>
                            <div class='col-md-4 text-center mb-2'>{pager}</div>
                            <div class='col-md-4'></div>
                        </div>",
                'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Package Name',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->package_name;
                        }
                    ],
                    [
                        'label' => 'Cost Per Person',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return GeneralModel::number_format_indian($model->cost_per_person);
                        }
                    ],
                    [
                        'label' => 'Stay Category',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->stay_category_id) ? GeneralModel::packagemetastaycategory()[$model->stay_category_id] : '';
                        }
                    ],

                    [
                        'label' => 'Feature',
                        'headerOptions' => ['style' => 'width: 15%;'],
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
                        'label' => 'Live Version',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (!empty($model->live_version->final_approved_at)) {
                                // return Html::a($model->live_version->version, Url::toRoute(['view', 'id' => $model->id]), [
                                //     'class' => 'btn btn-sm btn-primary',
                                // ]);
                                return date("F j, Y, g:i a", $model->live_version->final_approved_at);
                            }
                            return '';
                        }
                    ],

                    // [
                    //     'label' => 'Status',
                    //     'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->newstatuslabel;
                    //     }
                    // ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{update}&nbsp;&nbsp;{view}&nbsp;&nbsp;{sent}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/update.png" alt="" width="25" height="25">
                                ', ['/package/default/update', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',

                                ]);
                            },
                            'view' => function ($url, $model) {
                                return  Html::a('<i class="mdi mdi-eye"></i>', ['/package/default/view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',
                                ]);
                            },

                            // 'SentforApproval' => function ($url, $model) {
                            //     if ($model->status == PackageVersion::EDIATBLE_STATUS) {

                            //         return  Html::a('send-for-approval', ['send-for-approval', 'id' => $model->id], [
                            //             'class' => 'btn btn-danger p-0 change-menuicon',
                            //             'title' => 'send-for-approval',

                            //         ]);
                            //     }
                            // },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>