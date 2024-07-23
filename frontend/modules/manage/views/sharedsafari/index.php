<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $safari_operator->business_name . ' | Manage Operator Business';

?>
<div class="container-fluid mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <h5><?= $this->title ?></h5>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'sharedsafari']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 ms-auto">
                            <button class="btn_newsafari departureBtn" value="<?= \yii\helpers\Url::toRoute(['create-fixed-departure']) ?>">+ Create Fixed Departure </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?= GridView::widget([
                                    'dataProvider' => $fixed_safari_provider,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'contentOptions' => ['style' => 'width: 2%;'],
                                        ],
                                        [
                                            'label' => 'Park List',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return Html::a($model->park->title, ['/sharedsafari/default/view', 'slug' => $model->slug]);
                                            }
                                        ],
                                        [
                                            'label' => 'Start Date',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->start_date;
                                            }
                                        ],
                                        [
                                            'label' => 'End Date',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->end_date;
                                            }
                                        ],
                                        [
                                            'label' => 'No of Safari',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->no_of_safari;
                                            }
                                        ],
                                        [
                                            'label' => 'Total Seat',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->total_seat;
                                            }
                                        ],
                                        [
                                            'label' => 'Tour Duration',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->tour_duration;
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
                                            'label' => 'Action',
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'width: 5%;'],
                                            'value' => function ($model) {
                                                return   Html::Button('Update', ['value' => Url::toRoute(['update-fixed-departure', 'slug' => $model->slug]), 'class' => 'btn btn_newsafari departureBtn', 'title' => 'Update']);
                                            }
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
</div>

<div class="modal fade _standard-text" id="departure-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Organize a New Fixed Departure</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS

function departurefunction() {
	$('.departureBtn').on('click', function () {
        $('#departure-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
departurefunction();
             
JS;
$this->registerJs($script);
?>