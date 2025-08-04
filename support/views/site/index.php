<?php

/** @var yii\web\View $this */

use support\assets\AppAsset;
use common\models\GeneralModel;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Dashboard';
// $this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
