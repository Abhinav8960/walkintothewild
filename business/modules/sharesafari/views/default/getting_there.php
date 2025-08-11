<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Fixed Departure : ' . $shared_safari_departure_version_model->share_safari_title . '';
// $this->params['title'] = $this->title;
?>
<?= $this->render('_form_upper_view', ['shared_safari_departure_version_model' => $shared_safari_departure_version_model]) ?>

<div class="tabs-formswrapper mx-3">
    <?= $this->render('_navbar', ['shared_safari_departure_version_model' => $shared_safari_departure_version_model, 'getting_there_active' => 'active']) ?>

    <div class="tabs-content-wraps">

        <?= $this->render('_getting_there_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>