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
        <div class="d-flex justify-content-between align-items-center  flex-wrap mb-4">
            <h6 class="fs-3 fw-bold mb-0"><?= $this->title ?></h6>
            <div class=" mt-xxl-0 mt-3">
                <a href="<?= Url::toRoute(['/package/default/view', 'slug' => $package_model->package_slug]) ?>" class="btn_newsafari organizeBtn newbg text-center rounded-2" target="_blank">
                    <i class="fa fa-eye"></i> View
                </a>
                &nbsp;
                <a  href="javascript:void(0)" class="packageBtn btn_newsafari organizeBtn newbg text-center rounded-2" value="<?= \yii\helpers\Url::toRoute(['/manage/package/create-gallery?package_id=' . $package_model->id]) ?>">
                    + Add Gallery
                </a>
            </div>
        </div>
        <div class="col-md-4 col-xl-3 col-xxl-2 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-md-8 col-xl-9 col-xxl-10">
            <div class="card account-settingside itenary_tabs">
                <div class="card-body safartabs p-4">
                    <div class="row">
                        <div class="col-12">

                            <?= $this->render('_profile_navbar', ['package' => $package_model, 'gallery_active' => 'active']) ?>
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
                                                            'label' => 'Image Caption',
                                                            'contentOptions' => ['style' => 'width: 15%;'],
                                                            'format' => 'raw',
                                                            'value' => function ($model) {
                                                                return $model->image_caption;
                                                            }
                                                        ],
                                                        [
                                                            'label' => 'Image',
                                                            'contentOptions' => ['style' => 'width: 15%;'],
                                                            'format' => 'raw',
                                                            'value' => function ($model) {
                                                                return Html::img($model->imagepath, ['alt' => 'Banner Photograph', 'style' => 'max-width:60px;']);
                                                            }
                                                        ],
                                                        [
                                                            'class' => 'yii\grid\ActionColumn',
                                                            'header' => "Actions",
                                                            'contentOptions' => ['style' => 'width: 15%;'],
                                                            'template' => '{update}',
                                                            'buttons' => [
                                                                'update' => function ($url, $model) {
                                                                    return Html::Button('+ Edit Gallery Image', ['value' => "/manage/package/create-gallery?package_id=$model->package_id&id=$model->id", 'class' => 'packageBtn btn btn-info join_btn py-2', 'title' => 'Edit Gallery Image']);
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add a Gallery</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body p-4">
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