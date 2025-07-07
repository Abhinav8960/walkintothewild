<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */
$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Fixed Departure : ' . $shared_safari_departure_model->share_safari_title . '';
$this->params['title'] = $this->title;

?>


<div class="tabs-formswrapper mx-3">

    <?= $this->render('_navbar', ['shared_safari_departure_model' => $shared_safari_departure_model, 'policy_info_active' => 'active']) ?>

       <div class="tabs-content-wraps">
        <?= $this->render('_policy_info_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>