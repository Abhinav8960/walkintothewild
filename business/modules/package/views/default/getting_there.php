<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */
$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Package : ' . $package_version_model->package_name . '';
$this->params['title'] = mb_strimwidth($this->title,0, 70, "...");


?>
<?php if (false) { ?>
    <?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>
<?php } ?>

<div class="tabs-formswrapper mx-3">
    <?= $this->render('_navbar', ['package' => $package_version_model, 'getting_there_active' => 'active']) ?>

    <div class="tabs-content-wraps">
        <?= $this->render('_getting_there_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>