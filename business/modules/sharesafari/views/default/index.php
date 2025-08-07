<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariVersion;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Fixed Departure';
$this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'button-created new create float-end', 'title' => 'Create']);
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
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Title',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayShareSafari->share_safari_title <> '' ? $model->displayShareSafari->share_safari_title : 'Untitled';
                        }

                    ],
                    [
                        'label' => 'Start Date',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->displayShareSafari->start_date) ? date('Y-m-d', strtotime($model->displayShareSafari->start_date)) : '';
                        }
                    ],
                    [
                        'label' => 'End Date',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->displayShareSafari->end_date) ? date('Y-m-d', strtotime($model->displayShareSafari->end_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Cut Off Date',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->displayShareSafari->cut_off_date) ? date('Y-m-d', strtotime($model->displayShareSafari->cut_off_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Number Of Safari',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayShareSafari->no_of_safari;
                        }
                    ],
                    [
                        'label' => 'Number Of Seat',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'width: 10%;text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayShareSafari->total_seat;
                        }
                    ],
                    [
                        'label' => 'Share Seat',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'width: 10%;text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayShareSafari->share_seat;
                        }
                    ],

                    [
                        'label' => 'Is Live',
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->status == 1) {
                                return '<span class="badge bg-success">Yes</span>';
                            } else {
                                return '<span class="badge bg-danger">No</span>';
                            }
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{seat}&nbsp{update}&nbsp{view}&nbsp{inactive}',
                        'buttons' => [
                            'seat' => function ($url, $model) {
                                if ($model->status == 1) {
                                    return Html::button(
                                        '<img src="' . $this->params['baseurl']  . '/images/person-seat.svg" alt="" width="20" height="20">',
                                        [
                                            'value' => Url::toRoute(['update-seat', 'id' => $model->id]),
                                            'class' => 'btn p-0 change-menuicon seatAction',
                                            'title' => 'View',
                                        ]
                                    );
                                }
                            },

                            'update' => function ($url, $model) {
                                if ($model->edit_status != 0) {
                                    return  Html::a('<img src="' . $this->params['baseurl'] . '/images/update.png" alt="" width="25" height="25">
                                ', ['update', 'id' => $model->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',

                                    ]);
                                } else if ($model->edit_status == 0) {
                                    return  Html::a('<img src="' . $this->params['baseurl'] . '/images/update.png" alt="" width="25" height="25">
                                ', ['copy-with-edit', 'id' => $model->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',

                                    ]);
                                }
                                return Html::tag('span', '', [
                                    'style' => 'display:inline-block;width:25px;height:25px;'
                                ]);
                            },

                            'view' => function ($url, $model) {
                                if (isset($model->live_fd)) {
                                    return  Html::a('<i class="mdi mdi-eye"></i>', ['view', 'id' => $model->live_fd->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',
                                    ]);
                                }
                                if (isset($model->editable_fd)) {
                                    return  Html::a('<i class="mdi mdi-eye"></i>', ['view', 'id' => $model->editable_fd->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',
                                    ]);
                                }
                            },

                            'inactive' => function ($url, $model) {
                                if ($model->status != 10) {
                                    if ($model->status == 1) {
                                        return Html::a('<i class="fa fa-toggle-on"></i>', ['inactive', 'id' => $model->id], [
                                            'class' => 'btn btn-xs btn-success',
                                            'data-method' => 'post',
                                            'data-confirm' => 'Are you sure to inactive this package?',
                                            'title' => 'Unblock User',
                                            'data-bs-toggle' => "tooltip"
                                        ]);
                                    } else if ($model->status == 0) {
                                        return Html::a('<i class="fa fa-toggle-off"></i>', ['inactive', 'id' => $model->id], [
                                            'class' => 'btn btn-xs btn-danger',
                                            'data-method' => 'post',
                                            'data-confirm' => 'Are you sure to active this package?',
                                            'title' => 'Block User',
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


<div class="modal fade _standard-text" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Update Seat</h1>
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS

    $('.seatAction').on('click', function () {
        $('#exampleModal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);

?>