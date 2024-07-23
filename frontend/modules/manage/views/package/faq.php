<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::Button('+ Add FAQ', ['value' => "Url::toRoute(['/manage/package/create-faq','package_id' => $package_model->id])", 'class' => 'btn popupButton btn-orange me-2', 'title' => 'Create FAQ']);
$this->params['buttons'][] = Html::Button('+ Select FAQ', ['value' => "Url::toRoute(['/manage/package/select-faq','package_id' => $package_model->id])", 'class' => 'btn popupButton btn-orange', 'title' => 'Select FAQ']);

?>



<div class="container-fluid mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12 d-flex justify-content-between">
            <h5><?= $this->title ?></h5>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <?= $this->render('_profile_navbar', ['package' => $package_model, 'faq_active' => 'active']) ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-12  mb-xl-5 mb-3">
                                                <div class="row justify-content-between">
                                                    <div class="col-md-5">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="right_button float-md-end">
                                                            <?php if (Yii::$app->user->identity) { ?>
                                                                <button class="packageBtn join_btn ms-sm-3 mt-sm-0 mt-2" value="<?= \yii\helpers\Url::toRoute(['/manage/package/create-faq/' . $package_model->id . '']) ?>">+ Create FAQ</button>
                                                            <?php } else {  ?>
                                                                <a class="join_btn ms-sm-3 mt-sm-0 mt-2" href="/site/auth?authclient=google">+ Create FAQ</a>
                                                            <?php } ?>

                                                            <?php if (Yii::$app->user->identity) { ?>
                                                                <button class="packageBtn join_btn ms-sm-3 mt-sm-0 mt-2" value="<?= \yii\helpers\Url::toRoute(['/manage/package/select-faq/' . $package_model->id . '']) ?>">+ Select FAQ</button>
                                                            <?php } else {  ?>
                                                                <a class="join_btn ms-sm-3 mt-sm-0 mt-2" href="/site/auth?authclient=google">+ Select FAQ</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create a New Package</h1>
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