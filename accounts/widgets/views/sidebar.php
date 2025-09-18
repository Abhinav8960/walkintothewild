<?php
$active_url = "/" . Yii::$app->requestedRoute;
$webasset = $this->assetManager->getBundle('\accounts\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<nav class="side_bar sidebar-offcanvas d-flex justify-content-start">
    <ul class="nav">
    </ul>
</nav>