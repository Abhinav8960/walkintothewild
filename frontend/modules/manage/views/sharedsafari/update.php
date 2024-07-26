<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Url;

$this->title = $safari_operator->business_name . ' | Manage Operator Business';
$this->params['title'] = $this->title;
?>

<div class="container-fluid mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12 d-flex justify-content-between">
        <h6 class="fs-3 fw-bold mb-4"><?= $this->title ?></h6>
        </div>
        <div class="col-md-2">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'sharedsafari']); ?>
        </div>
        <div class="col-md-10">
            <div class="card account-settingside">
                <div class="card-body">
                    <div class="row">
                        <?= $this->render('_profile_navbar', ['sharedsafari' => $shared_safari_departure_model, 'overview_active' => 'active']) ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                    <?= $this->render('_basic_detail_form', [
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