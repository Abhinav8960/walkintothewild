<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use common\models\package\PackageVersion;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Package : ' . $package_version_model->package_name . '';

?>

<?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>


<div class="tabs-formswrapper mx-3">
    <?= $this->render('_navbar', ['package' => $package_version_model, 'inclusions_active' => 'active']) ?>

    <div class="tabs-content-wraps">
        <div class="tab-content">
            <div class="tab-pane active">
                <?= $this->render('_inclusion_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>