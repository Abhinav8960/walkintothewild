<?php


use common\models\GeneralModel;
use common\models\package\PackageVersion;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Package Approval List';
$this->params['breadcrumbs_home_url'] = '/package';
$this->params['breadcrumbs'][] =  ['label' => 'Package', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
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
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->package_name;
                        }
                    ],
                    [
                        'label' => 'Partner Name',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->safarioperator) ? $model->safarioperator->business_name : '';
                        }
                    ],
                    [
                        'label' => 'Cost Per Person',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'contentOptions' => ['style' => 'text-align: right;'],
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
                            return isset($model->stay_category_id) ? GeneralModel::packageoption()[$model->stay_category_id] : '';
                        }
                    ],

                    [
                        'label' => 'Feature',
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
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->live_version) {
                                return Html::a($model->live_version->version, Url::toRoute(['view', 'id' => $model->id]), [
                                    'class' => 'btn btn-sm btn-primary',
                                ]);
                            }
                            return '';
                        }
                    ],

                    // [
                    //     'label' => 'Pending for Approval',
                    //     'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->status == Package::SEND_FOR_APPROVAL_STATUS ? '<span class="badge badge-warning">Yes</span>' : '<span class="badge badge-success">No</span>';
                    //     }
                    // ],
                    // [
                    //     'label' => 'Status',
                    //     'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->statuslabel;
                    //     }
                    // ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'template' => '{approved}{view}{reject}',
                        'buttons' => [
                           
                            'approved' => function ($url, $model) {
                                if ($model->status == PackageVersion::SEND_FOR_APPROVAL_STATUS) {
                                    return Html::a(
                                        'Approve',
                                        [Url::toRoute(['approved', 'package_id' => $model->package_id, 'version' => $model->version])],
                                        [
                                            'data' => [
                                                'confirm' => 'Are you sure you want to approve this package?',
                                                'method' => 'post',
                                            ],
                                            'class' => 'btn btn-orange  m-2',
                                            'title' => 'Approve'
                                        ]
                                    );
                                }
                            },
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['/packageapproval/default/view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',

                                ]);
                            },
                            // 'reject' => function ($url, $model) {
                            //     if ($model->status == PackageVersion::SEND_FOR_APPROVAL_STATUS) {
                            //         return Html::button(
                            //             'Reject',
                            //             [
                            //                 'value' => Url::toRoute(['reject', 'package_id' => $model->package_id, 'version' => $model->version]),
                            //                 'class' => 'btn btn-danger reasonpopup m-2',
                            //                 'title' => 'Reject'
                            //             ]
                            //         );
                            //     }
                            // },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<div class="modal fade _standard-text" id="reject-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Reason For Rejection</h1>
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='reasonContent'></div>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
function rejection() {
	$('.reasonpopup').on('click', function () {
        $('#reject-modal').modal('show')
		.find('#reasonContent')
		.load($(this).attr('value'));
	});
}
rejection();
JS;
$this->registerJs($script);
?>