<?php

use common\models\transaction\Transaction;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\accounts\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Dashboard';
?>

<div class="row">
  <div class="col-xxl-10 mb-3">
    <div class="row">
      <div>
        <p style="font-weight: 500;">Developer Portal</p>
      </div>
      <div class="col-xxl-12">
        <div class="row">
          <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
            <a href="<?= Url::toRoute(['/api']) ?>" style="text-decoration: none;">
              <div class="mainCard py-3 px-3">
                <div class="cardChild">
                  <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                    <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                  </div>
                  <div class="text-card mb-2">
                    <p>API Documentation</p>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
            <a href="<?= Url::toRoute(['/code']) ?>" style="text-decoration: none;">
              <div class="mainCard py-3 px-3">
                <div class="cardChild">
                  <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                    <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                  </div>
                  <div class="text-card mb-2">
                    <p>Code Documentation</p>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
            <a href="<?= Url::toRoute(['/feature']) ?>" style="text-decoration: none;">
              <div class="mainCard py-3 px-3">
                <div class="cardChild">
                  <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                    <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                  </div>
                  <div class="text-card mb-2">
                    <p>Feature of WITW</p>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>