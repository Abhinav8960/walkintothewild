<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Package : ' . $package_version_model->package_name . '';
?>

<?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>

<div class="panel panel-primary tabs-style-2">
    <?= $this->render('_navbar', ['package' => $package_version_model, 'faq_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div>

                            <?= Html::Button('+ Add FAQ', ['value' => Url::toRoute(['create-faq', 'id' => $package_version_model->id]), 'class' => 'btn create-action btn-orange me-2', 'title' => 'Create FAQ']); ?>
                        </div>
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'contentOptions' => ['style' => 'width: 5%;'],
                                    ],
                                    [
                                        'label' => 'Question',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->question;
                                        }
                                    ],
                                    [
                                        'label' => 'Answer',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->answer;
                                        }
                                    ],

                                    'created_at:dateTime:Created at',
                                    'updated_at:dateTime:Last Updated at',
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
                                        'template' => '{update}&nbsp;{delete}&nbsp;&nbsp;{suspend}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                return Html::Button('<i class="fa fa-edit"></i>', ['value' => Url::toRoute(['update-faq', 'id' => $model->package_id, 'faq_id' => $model->id]), 'class' => 'btn update-action btn-orange me-2', 'title' => 'Update FAQ']);
                                            },
                                        ]
                                    ],
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Create Faq
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Update Faq
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

    $('.create-action').on('click', function () {
        $('#modalCreate').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

    $('.update-action').on('click', function () {
        $('#modalUpdate').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>