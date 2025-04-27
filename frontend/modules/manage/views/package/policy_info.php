<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Package Inclusion : ' . $package_version_model->package_name . '';
$this->params['title'] = $this->title;

?>


<div class="container-lg mt-5 mb-5 pt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12 d-flex justify-content-between align-items-center mb-4">
        <h6 class="fs-3 fw-bold"><?= $this->title ?></h6>
            <div class="d-flex justify-content-between">
                <a href="<?= Url::toRoute(['/package/default/view', 'slug' => $package_version_model->package_slug, 'operator_slug' => $package_version_model->safarioperator ? $package_version_model->safarioperator->slug : '']) ?>" class="btn_newsafari organizeBtn newbg text-center rounded-2 px-3 py-2" target="_blank"><i class="fa fa-eye"></i> View </a> &nbsp;
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
                        <?= $this->render('_profile_navbar', ['package' => $package_version_model, 'policy_info_active' => 'active']) ?>
                        </div>
                      
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                    <?= $this->render('_policy_info_form', [
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