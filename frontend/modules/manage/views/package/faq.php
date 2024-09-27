<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['title'] = $this->title;

?>

<div class="container-lg mt-5 mb-5 pt-5  ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12 ">
            <div class="d-flex justify-content-between mb-4 align-items-center flex-wrap">
                <h6 class="fs-3 fw-bold"><?= $this->title ?></h6>
                <div class=" mt-xxl-0 mt-3">
                    <a href="<?= Url::toRoute(['/package/default/view', 'slug' => $package_model->package_slug, 'operator_slug' => $package_model->safarioperator ? $package_model->safarioperator->slug : '']) ?>" class="btn_newsafari organizeBtn newbg text-center rounded-2  " target="_blank"><i class="fa fa-eye"></i> View </a> &nbsp;
                    <a href="javascript:void(0)" class="packageBtn btn_newsafari organizeBtn newbg text-center rounded-2" value="<?= \yii\helpers\Url::toRoute(['/manage/package/create-faq', 'slug' => $package_model->package_slug]) ?>">+ Create FAQ</a>
                    <!-- <button class="packageBtn btn_newsafari organizeBtn newbg text-center rounded-2 px-3 py-2" value="<?= \yii\helpers\Url::toRoute(['/manage/package/select-faq/' . $package_model->package_slug . '']) ?>">+ Select FAQ</button> -->
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8">
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
                                                            'template' => '{update}&nbsp;',
                                                            'buttons' => [
                                                                'update' => function ($url, $model) use($package_model) {
                                                                    return Html::Button('<i class="fa fa-edit"></i>', ['value' => Url::toROute(['/manage/package/update-faq', 'slug' => $package_model->package_slug, 'faq_id' => $model->id]), 'class' => 'packageBtn btn btn-info bg-blues py-2 text-white', 'title' => 'Update FAQ']);
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
                <h1 class="modal-title fs-5" id="exampleModalLabel"> FAQ</h1>
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