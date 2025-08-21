<?php

use common\models\GeneralModel;
use common\models\package\PackageVersion;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Package';
// $this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('Create', ['create'], ['class' => 'button-created new create float-end mt-3', 'title' => 'Create']);
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
                            return mb_strimwidth($model->display_package->package_name, 0, 40, "...");
                        }
                    ],
                    [
                        'label' => 'Duration',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->display_package->no_of_day . ' Days, ' . $model->display_package->no_of_night . ' Nights';
                        }
                    ],
                    [
                        'label' => 'Cost Per Person',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return GeneralModel::number_format_indian($model->display_package->cost_per_person);
                        }
                    ],
                    [
                        'label' => 'No of Safari',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->display_package->no_of_safari;
                        }
                    ],
                    [
                        'label' => 'Stay Category',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->display_package->stay_category_id) ? GeneralModel::packagemetastaycategory()[$model->display_package->stay_category_id] : '';
                        }
                    ],

                    [
                        'label' => 'Max Booking Date',
                        'headerOptions' => ['style' => 'width: 12%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->display_package->max_booking_date) ? date("F j, Y", strtotime($model->display_package->max_booking_date)) : '';
                        }
                    ],

                    // [
                    //     'label' => 'Status',
                    //     'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->statustags;
                    //     }
                    // ],

                    [
                        'label' => 'Is Live',
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            // return $model->live_version != null ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>';
                            if ($model->status == 1) {
                                return '<span class="badge bg-success">Yes</span>';
                            } else {
                                return '<span class="badge bg-danger">No</span>';
                            }
                        }
                    ],

                    // [
                    //     'class' => 'yii\grid\ActionColumn',
                    //     'header' => "Actions",
                    //     'headerOptions' => ['style' => 'width: 10%;'],
                    //     'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                    //     'template' => '{update}&nbsp;&nbsp;{view}&nbsp;&nbsp;{sent}',
                    //     'buttons' => [

                    //         'update' => function ($url, $model) {
                    //             if (isset($model->editable_package)) {
                    //                 return  Html::a('<img src="' . $this->params['baseurl'] . '/images/update.png" alt="" width="25" height="25">
                    //             ', ['/package/default/update', 'id' => $model->editable_package->id], [
                    //                     'class' => 'btn p-0 change-menuicon',
                    //                     'title' => 'View',

                    //                 ]);
                    //             }
                    //             return Html::tag('span', '', [
                    //                 'style' => 'display:inline-block;width:25px;height:25px;'
                    //             ]);
                    //         },
                    //         'view' => function ($url, $model) {
                    //              if (isset($model->live_package)) {
                    //                 return  Html::a('<i class="mdi mdi-eye"></i>', ['/package/default/view', 'id' => $model->live_package->id], [
                    //                     'class' => 'btn p-0 change-menuicon',
                    //                     'title' => 'View',
                    //                 ]);
                    //              }
                    //             if (isset($model->editable_package)) {
                    //                 return  Html::a('<i class="mdi mdi-eye"></i>', ['/package/default/view', 'id' => $model->editable_package->id], [
                    //                     'class' => 'btn p-0 change-menuicon',
                    //                     'title' => 'View',
                    //                 ]);
                    //             }

                    //         },

                    //         // 'SentforApproval' => function ($url, $model) {
                    //         //     if ($model->status == PackageVersion::EDIATBLE_STATUS) {

                    //         //         return  Html::a('send-for-approval', ['send-for-approval', 'id' => $model->id], [
                    //         //             'class' => 'btn btn-danger p-0 change-menuicon',
                    //         //             'title' => 'send-for-approval',

                    //         //         ]);
                    //         //     }
                    //         // },
                    //     ]
                    // ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{update}&nbsp;&nbsp;{view}&nbsp;&nbsp;{sent}&nbsp{inactive}',
                        'buttons' => [

                            'update' => function ($url, $model) {
                                if ($model->edit_status == 1) {
                                    return  Html::a('<img src="' . $this->params['baseurl'] . '/images/update.png" alt="" width="25" height="25">
                                ', ['/package/default/update', 'id' => $model->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',

                                    ]);
                                } else if ($model->edit_status == 0) {
                                    return  Html::a('<img src="' . $this->params['baseurl'] . '/images/update.png" alt="" width="25" height="25">
                                ', ['/package/default/copy-with-edit', 'id' => $model->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',

                                    ]);
                                }
                                return Html::tag('span', '', [
                                    'style' => 'display:inline-block;width:25px;height:25px;'
                                ]);
                            },
                            'view' => function ($url, $model) {
                                if (isset($model->live_package)) {
                                    return  Html::a('<i class="mdi mdi-eye"></i>', ['/package/default/view', 'id' => $model->live_package->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',
                                    ]);
                                }
                                if (isset($model->editable_package)) {
                                    return  Html::a('<i class="mdi mdi-eye"></i>', ['/package/default/view', 'id' => $model->editable_package->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',
                                    ]);
                                }
                            },

                            'inactive' => function ($url, $model) {
                                if ($model->status == 1 || $model->status == 0) {
                                    if ($model->status == 1) {
                                        return Html::a('<i class="fa fa-toggle-on"></i>', ['inactive', 'id' => $model->id], [
                                            'class' => 'btn btn-xs btn-success',
                                            'data-method' => 'post',
                                            'data-confirm' => 'Are you sure to inactive this package?',
                                            'title' => 'Inactive Package',
                                            'data-bs-toggle' => "tooltip"
                                        ]);
                                    } else if ($model->status == 0) {
                                        return Html::a('<i class="fa fa-toggle-off"></i>', ['inactive', 'id' => $model->id], [
                                            'class' => 'btn btn-xs btn-danger',
                                            'data-method' => 'post',
                                            'data-confirm' => 'Are you sure to active this package?',
                                            'title' => 'Active Package',
                                            'data-bs-toggle' => "tooltip"
                                        ]);
                                    }
                                }
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>