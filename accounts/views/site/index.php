<?php

/** @var yii\web\View $this */

$webasset = $this->assetManager->getBundle('\accounts\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Dashboard';
?>

<div class="row">
    <div class="col-xxl-10 mb-3">
        <div class="row">
        </div>
    </div>

    <div class="col-xxl-2 mb-3">
        <div class="row">


        </div>
    </div>
</div>