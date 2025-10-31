<?php

$webasset = $this->assetManager->getBundle('\developer\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Dashboard';
?>

<div class="row">
  <div class="col-xxl-10 mb-3">
    <div class="row">
      <div>
        <p style="font-weight: 500;">Code Documentation</p>
      </div>
    </div>
  </div>
</div>