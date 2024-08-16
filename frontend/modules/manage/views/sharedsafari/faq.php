<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $safari_operator->businessname . ' | Manage Operator Business';
$this->params['title'] = $this->title;

?>

<div class="container-lg mt-5 mb-5 pt-5">
    <div class="row mb-5 margin_bottomfooter">
        <div class="col-md-12 d-flex justify-content-between align-items-center mb-4 flex-wrap ">
            <h6 class="fs-3 fw-bold "><?= $this->title ?></h6>
            <div class="mb-0 mt-xl-0 mt-3">
                <a class="packageBtn btn_newsafari departureBtn btn_newsafari organizeBtn newbg text-center" value="<?= \yii\helpers\Url::toRoute(['/manage/sharedsafari/create-faq', 'slug' => $shared_safari_departure_model->slug]) ?> " style="cursor:pointer">+ Create FAQ</a>
                <a class="packageBtn btn_newsafari departureBtn btn_newsafari organizeBtn newbg text-center" value="<?= \yii\helpers\Url::toRoute(['/manage/sharedsafari/select-faq', 'slug' => $shared_safari_departure_model->slug]) ?>" style="cursor:pointer">+ Select FAQ</a>
            </div>
        </div>

        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8 itenary_tabs">
            <div class="card account-settingside safartabs">
                <div class="card-body">
                    <div class="row">
                        <?= $this->render('_profile_navbar', ['sharedsafari' => $shared_safari_departure_model, 'faq_active' => 'active']) ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

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

<div class="modal fade _standard-text" id="package-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create a FAQ</h1>
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