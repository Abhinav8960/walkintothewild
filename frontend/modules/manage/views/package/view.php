<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Url;

$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['title'] = $this->title;
?>

<div class="container-fluid mt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12 d-flex justify-content-between mb-4 align-items-center">
        <h6 class="fs-3 fw-bold "><?= $this->title ?></h6>
            <div class="d-flex justify-content-between">
                <a href="<?= Url::toRoute(['/package/default/view', 'slug' => $package_model->package_slug]) ?>" class="btn_newsafari organizeBtn newbg text-center rounded-2 px-3 py-2" target="_blank"><i class="fa fa-eye"></i> View </a> &nbsp;
            </div>
        </div>
        <div class="col-md-4 col-xl-3 col-xxl-2 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-md-8 col-xl-9 col-xxl-10">
            <div class="card account-settingside ">
                <div class="card-body p-4">
                    <div class="row">
                        <?= $this->render('_navbar', ['package' => $package_model, 'quote_active' => 'active']) ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                    <?= $this->render('_quote', [
                                        'model' => $model,
                                        'dataProvider' => $dataProvider
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>