<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Html;
use yii\helpers\Url;


$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Package: ' . $package_version_model->package_name;
$this->params['title'] = mb_strimwidth($this->title,0, 70, "...");

?>

<?php if (false) { ?>
    <?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>
<?php } ?>

<div class="tabs-formswrapper mx-3">

    <?= $this->render('_navbar', ['package' => $package_version_model, 'overview_active' => 'active']) ?>

    <div class="tabs-content-wraps">

        <div class="tab-content">
            <div class="tab-pane active">
                <?= $this->render('_form', [
                    'model' => $model,
                    'safari_operator' => $safari_operator,
                ]) ?>
            </div>
        </div>
    </div>
</div>