<?php

/** @var yii\web\View $this */

use accounts\assets\AppAsset;
use common\models\GeneralModel;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\accounts\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Dashboard';
// $this->params['breadcrumbs'][] = $this->title;
// $this->params['title'] = $this->title;
?>

<div class="row">
  <div class="col-xxl-10 mb-3">
    <div class="row">
      <div class="col-xxl-12">
        <div class="row">
          
        </div>
      </div>
      <div class="col-xl-12 mb-4">
        <div class="row">
         
          
        </div>
      </div>
     
    </div>
  </div>

</div>