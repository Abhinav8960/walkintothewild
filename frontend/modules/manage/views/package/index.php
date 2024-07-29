<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $safari_operator->business_name . ' | Manage Operator Business';

?>

<div class="container-fluid mt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12 d-flex justify-content-between mb-4 align-items-center">
          <h6 class="fs-3 fw-bold "><?= $this->title ?></h6>
            <div class="right_button float-md-end ">
                <button class="btn_newsafari packageBtn btn_newsafari organizeBtn newbg text-center rounded-2 px-3 py-2" value="<?= Url::toRoute(['/manage/package/create']) ?>">+ Create New Package </button>
            </div>
       
        </div>
        <div class="col-md-2">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-md-10">
            <div class="card account-settingside ">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table_design_manage">
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'contentOptions' => ['style' => 'width: 2%;'],
                                        ],
                                        [
                                            'label' => 'Package Name',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return Html::a($model->package_name, ['/package/default/view', 'slug' => $model->package_slug]);
                                            }
                                        ],
                                        [
                                            'label' => 'No of Day',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->no_of_day;
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
                                            'label' => 'Price',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->cost_per_person;
                                            }
                                        ],
                                        [
                                            'label' => 'Created At',
                                            'contentOptions' => ['style' => 'width: 5%;'],
                                            'format' => 'dateTime',
                                            'value' => function ($model) {
                                                return $model->created_at;
                                            }
                                        ],
                                        [
                                            'label' => 'View',
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'width: 5%;'],
                                            'value' => function ($model) {
                                                return   Html::a('View', [Url::toRoute(['view', 'package_id' => $model->id])], ['class' => 'btn btn-info', 'title' => 'View']);
                                            }
                                        ],
                                        [
                                            'label' => 'Update',
                                            'format' => 'raw',
                                            'contentOptions' => ['style' => 'width: 5%;'],
                                            'value' => function ($model) {
                                                return   Html::a('Update', [Url::toRoute(['update', 'package_id' => $model->id])], ['class' => 'btn btn-info join_btn', 'title' => 'Update']);
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
<div class="modal fade _standard-text" id="package-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create a New Package</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body modal_form p-4">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
function organizefunction() {
	$('.packageBtn').on('click', function () {
        $('#package-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();
             
JS;
$this->registerJs($script);
?>