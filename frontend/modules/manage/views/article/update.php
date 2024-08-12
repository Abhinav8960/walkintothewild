<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = $safari_operator->businessname . ' | Manage Operator Business';

?>

<div class="container-fluid mt-5 mb-5">
    <div class="row margin_bottomfooter">
    <div class="col-md-12">
        <h6 class="fs-3 fw-bold mb-4"><?= $this->title ?></h6>
        </div>
        <div class="col-md-4 col-xl-3 col-xxl-2 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'article']); ?>
        </div>
        <div class="col-md-8 col-xl-9 col-xxl-10">
      
                    <?= $this->render('_form', ['model' => $model]) ?>
                </div>
           
    </div>
</div>