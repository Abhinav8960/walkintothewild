<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Url;

$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['title'] = $this->title;
?>

<div class="container-fluid mt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12 d-flex justify-content-between align-items-center mb-4">
        <h6 class="fs-3 fw-bold"><?= $this->title ?></h6>
            <div class="d-flex justify-content-between">
                <a href="<?= Url::toRoute(['/package/default/view', 'slug' => $package_model->package_slug]) ?>" class="btn_newsafari organizeBtn newbg text-center rounded-2 px-3 py-2" target="_blank"><i class="fa fa-eye"></i> View </a> &nbsp;
            </div>
        </div>
        <div class="col-md-4 col-xl-3 col-xxl-2 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-md-8 col-xxl-10 col-xl-9  ">
            <div class="card account-settingside itenary_tabs">
                <div class="card-body p-4 safartabs" >
                    <div class="row">
                        <div class="col-12">
                        <?= $this->render('_profile_navbar', ['package' => $package_model, 'overview_active' => 'active']) ?>
                        </div>
                 
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                    <?= $this->render('_basic_details_form', [
                                        'model' => $model,
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