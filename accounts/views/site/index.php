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
      <div class="col-xxl-12">
        <div class="row">
          <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
            <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'status' => Transaction::STATUS_SUCCESS]) ?>">
              <div class="mainCard py-3 px-3">
                <div class="cardChild">
                  <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                    <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                  </div>
                  <div class="text-card mb-2">
                    <p>Success Transaction</p>
                  </div>
                  <div class="numbwrCount">
                    <h3><?= isset($success_transaction) ? $success_transaction : 0 ?></h3>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
            <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'status' => Transaction::STATUS_INITIATED]) ?>">
              <div class="mainCard py-3 px-3">
                <div class="cardChild">
                  <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                    <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                  </div>
                  <div class="text-card mb-2">
                    <p>Initated Transaction</p>
                  </div>
                  <div class="numbwrCount">
                    <h3><?= isset($initated_transaction) ? $initated_transaction : 0 ?></h3>
                  </div>
                </div>
              </div>
            </a>

          </div>

          <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
            <a style="text-decoration:none;" href="<?= Url::to(['/transactioninfo/default/index', 'status' => Transaction::STATUS_FAILED]) ?>">
              <div class="mainCard py-3 px-3">
                <div class="cardChild">
                  <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                    <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg" alt="Lead">
                  </div>
                  <div class="text-card mb-2">
                    <p>Failed Transaction</p>
                  </div>
                  <div class="numbwrCount">
                    <h3><?= isset($failed_transaction) ? $failed_transaction : 0 ?></h3>
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