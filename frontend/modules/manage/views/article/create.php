<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $safari_operator->business_name . ' | Manage Operator Business';
?>


<div class="container-fluid mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12">
        <h6 class="fs-3 fw-bold mb-4"><?= $this->title ?></h6>
        </div>
        <div class="col-md-2">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'article']); ?>
        </div>
        <div class="col-md-10">
            <div class="card account-settingside">
                <div class="card-body">
                    <?= $this->render('_form', ['model' => $model]) ?>
                </div>
            </div>
        </div>
    </div>
</div>