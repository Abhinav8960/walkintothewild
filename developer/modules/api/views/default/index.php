<?php

$webasset = $this->assetManager->getBundle('\developer\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'API Documentation - Swagger';
$this->params['title'] = $this->title;
?>
<link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist/swagger-ui.css" />

<div class="row">
  <div class="col-md-12 mb-3">
    <div id="swagger-ui" class="bg-white"></div>
  </div>
</div>


<script src="https://unpkg.com/swagger-ui-dist/swagger-ui-bundle.js"></script>
<script>
  window.onload = () => {
    const ui = SwaggerUIBundle({
      url: "<?= \yii\helpers\Url::toRoute(['json']) ?>",
      dom_id: "#swagger-ui",
      deepLinking: true,
      presets: [SwaggerUIBundle.presets.apis],
      layout: "BaseLayout",
      persistAuthorization: true,
    });
  };
</script>