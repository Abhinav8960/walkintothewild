<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = $safari_operator->businessname . ' | Manage Operator Business';

?>

<div class="container-lg mt-5 mb-5 pt-5">
    <div class="row margin_bottomfooter">
        <div class="col-md-12">
            <h6 class="fs-3 fw-bold mb-4"><?= $this->title ?></h6>
        </div>
        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'article']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8">
            <?= $this->render('_form', ['model' => $model]) ?>
        </div>

    </div>
</div>