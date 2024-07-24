<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Url;

$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['title'] = $this->title;
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12 d-flex justify-content-between">
            <h5><?= $this->title ?></h5>
            <div class="d-flex justify-content-between">
                <a href="<?= Url::toRoute(['/package/default/view', 'slug' => $package_model->package_slug]) ?>" class="btn btn-success mb-2" target="_blank"><i class="fa fa-eye"></i> View </a> &nbsp;
            </div>
        </div>
        <div class="col-md-2">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <?= $this->render('_navbar', ['package' => $package_model, 'booknow_active' => 'active']) ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                    <div class="col-6">
                                        No Bookings Done!
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