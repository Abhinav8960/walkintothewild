<?php

use business\assets\AppAsset;


$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
AppAsset::register($this);

$this->title = 'Faqs';
?>
