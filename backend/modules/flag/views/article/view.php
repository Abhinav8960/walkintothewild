<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Share Safari Comment';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl;

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
                        'label' => 'Flagged Reason',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return  $model->reportreason->reason;
                        }

                    ],

                    [
                        'label' => 'Flagged Detail',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return  $model->report_detail;
                        }
                    ],


                    [
                        'label' => 'Action',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $return = 'N/A';
                            if ($model->status == 2) {
                                $return = 'Delete';
                            } else if ($model->status == 3) {
                                $return = 'Ignore';
                            } else if ($model->status == 20) {
                                $return = 'Blocked User';
                            }
                            return $return;
                        }
                    ],

                    [
                        'label' => 'Admin Comment',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $return = 'N/A';
                            if (!empty($model->reason)) {
                                $return = $model->reason;
                            }
                            return $return;
                        }
                    ],
                    [
                        'label' => 'Action',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::button('<img src="/img/update.png" alt="" width="25" height="25">', [
                                'value' => Url::toRoute(['edit', 'id' => $model->id]),
                                'class' => 'btn btn-warning flag-action mb-2',
                                'title' => 'Edit'
                            ]);
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFlag" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Action
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS

    $('.flag-action').on('click', function () {
        $('#modalFlag').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>