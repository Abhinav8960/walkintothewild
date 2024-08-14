<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['title'] = $this->title;

?>

<div class="container-fluid mt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12 ">
            <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fs-3 fw-bold"><?= $this->title ?></h6>
            <div class="d-flex justify-content-between align-items-center flex-basis-50 gap-2">
                <a href="<?= Url::toRoute(['/package/default/view', 'slug' => $package_model->package_slug]) ?>" class="btn_newsafari organizeBtn newbg text-center rounded-2 px-3 py-2" target="_blank"><i class="fa fa-eye"></i> View </a> 
                <button class="packageBtn btn_newsafari organizeBtn newbg text-center rounded-2 px-3 py-2" value="<?= \yii\helpers\Url::toRoute(['/manage/package/create-faq/' . $package_model->id . '']) ?>">+ Create FAQ</button>
                <button class="packageBtn btn_newsafari organizeBtn newbg text-center rounded-2 px-3 py-2" value="<?= \yii\helpers\Url::toRoute(['/manage/package/select-faq/' . $package_model->id . '']) ?>">+ Select FAQ</button>
            </div>
            </div>
           
        </div>
        <div class="col-md-12 mb-3">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-md-12">
            <div class="card account-settingside itenary_tabs">
                <div class="card-body safartabs p-4">
                    <div class="row">
                        <div class="col-12">

                            <?= $this->render('_profile_navbar', ['package' => $package_model, 'faq_active' => 'active']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive table_design_manage">
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
                                                        [
                                                            'class' => 'yii\grid\ActionColumn',
                                                            'header' => "Actions",
                                                            'contentOptions' => ['style' => 'width: 15%;'],
                                                            'template' => '{delete}&nbsp;&nbsp;{suspend}',
                                                            'buttons' => [
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
                                </div>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Select a FAQ</h1>
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