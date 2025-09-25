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
        <p style="font-weight: 500;">Successfull Transaction</p>
      </div>
      <div class="col-xxl-12">
        <div class="row">
          <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
            <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'custom_days' => 1]) ?>">
              <div class="mainCard py-3 px-3">
                <div class="cardChild">
                  <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                    <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                  </div>
                  <div class="text-card mb-2">
                    <p>Today</p>
                  </div>
                  <div class="numbwrCount">
                    <h3><?= isset($today_success_transaction) ? $today_success_transaction : 0 ?></h3>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
            <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'custom_days' => 2]) ?>">
              <div class="mainCard py-3 px-3">
                <div class="cardChild">
                  <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                    <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                  </div>
                  <div class="text-card mb-2">
                    <p>Last 3 Days</p>
                  </div>
                  <div class="numbwrCount">
                    <h3><?= isset($last_three_day_success_transaction) ? $last_three_day_success_transaction : 0 ?></h3>
                  </div>
                </div>
              </div>
            </a>

          </div>

          <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
            <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'custom_days' => 3]) ?>">
              <div class="mainCard py-3 px-3">
                <div class="cardChild">
                  <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                    <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                  </div>
                  <div class="text-card mb-2">
                    <p>Last 7 Days</p>
                  </div>
                  <div class="numbwrCount">
                    <h3><?= isset($last_seven_day_success_transaction) ? $last_seven_day_success_transaction : 0 ?></h3>
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