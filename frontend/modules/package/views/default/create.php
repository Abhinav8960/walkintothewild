<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */

$this->title = 'Package';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/package/default/index'];
$this->params['breadcrumbs'][] = "Create";
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


?>
<div class="card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>