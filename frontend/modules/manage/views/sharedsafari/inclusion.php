<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = $safari_operator->businessname . ' | Manage Operator Business';
$this->params['title'] = $this->title;

?>


<div class="container-lg mt-5 mb-5 pt-5">
    <div class="row mb-5 margin_bottomfooter">
        <div class="col-md-12 d-flex justify-content-between mb-4">
            <h6 class="fs-3 fw-bold "><?= $this->title ?></h6>
        </div>
        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'sharedsafari']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8 itenary_tabs">
            <div class="card account-settingside safartabs">
                <div class="card-body p-4">
                    <div class="row">
                        <?= $this->render('_profile_navbar', ['sharedsafari' => $shared_safari_departure_model, 'inclusions_active' => 'active']) ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content accordion" id="myTabContent">
                                <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                    <?= $this->render('_inclusion_form', [
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