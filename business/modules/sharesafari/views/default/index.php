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
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'contentOptions' => ['style' => 'width: 15%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayShareSafari->no_of_safari;
                        }
                    ],
                    [
                        'label' => 'Number Of Seat',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'contentOptions' => ['style' => 'width: 15%;text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayShareSafari->total_seat;
                        }
                    ],
                    [
                        'label' => 'Share Seat',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'contentOptions' => ['style' => 'width: 15%;text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayShareSafari->share_seat;
                        }
                    ],

                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayShareSafari->statustags;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{seat}&nbsp{update}&nbsp{view}',
                        'buttons' => [
                            'seat' => function ($url, $model) {
                                if ($model->displayShareSafari->status == ShareSafariVersion::APPROVED_AND_LIVE_STATUS) {
                                    return Html::button(
                                        '<img src="' . $this->params['baseurl']  . '/images/person-seat.svg" alt="" width="20" height="20">',
                                        [
                                            'value' => Url::toRoute(['/sharesafari/default/update-seat', 'id' => $model->displayShareSafari->id]),
                                            'class' => 'btn p-0 change-menuicon seatAction',
                                            'title' => 'View',
                                        ]
                                    );
                                }
                            },
                            'update' => function ($url, $model) {
                                if ($model->status == ShareSafariVersion::EDIATBLE_STATUS) {
                                    return  Html::a('<img src="' . $this->params['baseurl'] . '/images/update.png" alt="" width="25" height="25">
                                ', ['/sharesafari/default/update', 'id' => $model->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',

                                    ]);
                                } else if ($model->displayShareSafari->status == ShareSafariVersion::APPROVED_AND_LIVE_STATUS) {
                                    if ($share_safari = ShareSafari::find()->where(['id' => $model->share_safari_id])->andWhere(['IS NOT', 'editable_version', null])->limit(1)->one()) {
                                        $share_safari_version = ShareSafariVersion::find()->where(['share_safari_id' => $share_safari->id])->andWhere(['version' => $share_safari->editable_version])->limit(1)->one();
                                        return  Html::a('<img src="' . $this->params['baseurl'] . '/images/update.png" alt="" width="25" height="25">
                                        ', ['/sharesafari/default/update', 'id' => $share_safari_version->id], [
                                            'class' => 'btn p-0 change-menuicon',
                                            'title' => 'View',

                                        ]);
                                    }
                                } else {
                                    return Html::tag('span', '', [
                                        'style' => 'display:inline-block;width:25px;height:25px;'
                                    ]);
                                }
                            },
                            'view' => function ($url, $model) {
                                return  Html::a('<i class="mdi mdi-eye"></i>', ['view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',
                                ]);
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