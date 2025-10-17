<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

?>

<?php $leadCount = $leadModel->getTilesLeadCount(); ?>

<section class="listCard mx-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <a href="<?= Url::toRoute(['index', 'custom_status' => 3]) ?>" style="text-decoration: none; color: inherit;">
                            <div class="text-card mb-3">
                                <p>Total Active Leads</p>
                            </div>
                            <div class="numbwrCount d-flex gap-5">
                                <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                                    <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg"
                                        class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                                </div>
                                <?php if ($leadModel) { ?>
                                    <div class="numbwrCount">
                                        <h3><?= $leadCount['totalactivelead'] ?></h3>
                                    </div>
                                <?php } else {  ?>
                                    <div class="numbwrCount">
                                        <h3>0</h3>
                                    </div>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <a href="<?= Url::toRoute(['index', 'custom_status' => 1]) ?>" style="text-decoration: none; color: inherit;">
                            <div class="text-card mb-3">
                                <p>Current Active Leads</p>
                            </div>
                            <div class="numbwrCount d-flex gap-5">
                                <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                                    <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg"
                                        class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                                </div>
                                <?php if ($leadModel) { ?>
                                    <div class="numbwrCount">
                                        <h3><?= $leadCount['currentactivelead'] ?></h3>
                                    </div>
                                <?php } else {  ?>
                                    <div class="numbwrCount">
                                        <h3>0</h3>
                                    </div>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <a href="<?= Url::toRoute(['index', 'custom_status' => 4]) ?>" style="text-decoration: none; color: inherit;">

                            <div class="text-card mb-3">
                                <p>Leads in Discussion</p>
                            </div>
                            <div class="numbwrCount d-flex gap-5">
                                <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center" style="background-color: #FFF4EE;">
                                    <img src="<?= $this->params['baseurl'] ?>/images/fixeddepa.png"
                                        class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                                </div>
                                <?php if ($leadModel) { ?>
                                    <div class="numbwrCount">
                                        <h3><?= $leadCount['leadindiscussion'] ?></h3>
                                    </div>
                                <?php } else {  ?>
                                    <div class="numbwrCount">
                                        <h3>0</h3>
                                    </div>
                                <?php } ?>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <a href="<?= Url::toRoute(['index', 'custom_status' => 5]) ?>" style="text-decoration: none; color: inherit;">

                            <div class="text-card mb-3">
                                <p>Payment Received</p>
                            </div>
                            <div class="numbwrCount d-flex gap-5">
                                <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center" style="background-color: #DDFFE7;">
                                    <img src="<?= $this->params['baseurl'] ?>/images/package.png"
                                        class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                                </div>
                                <?php if ($leadModel) { ?>
                                    <div class="numbwrCount">
                                        <h3><?= $leadCount['paymentrecieved'] ?></h3>
                                    </div>
                                <?php } else {  ?>
                                    <div class="numbwrCount">
                                        <h3>0</h3>
                                    </div>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <a href="<?= Url::toRoute(['index', 'custom_status' => 6]) ?>" style="text-decoration: none; color: inherit;">

                            <div class="text-card mb-3">
                                <p>Pending Payments</p>
                            </div>
                            <div class="numbwrCount d-flex gap-5">
                                <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center" style="background-color: #AAAAAA;">
                                    <img src="<?= $this->params['baseurl'] ?>/images/qut.png"
                                        class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                                </div>
                                <?php if ($leadModel) { ?>
                                    <div class="numbwrCount">
                                        <h3><?= $leadCount['pendingpayment'] ?></h3>
                                    </div>
                                <?php } else {  ?>
                                    <div class="numbwrCount">
                                        <h3>0</h3>
                                    </div>
                                <?php } ?>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
    .editBtn a {
        background-color: #237F40;
        color: #ffffff;
        border: 0;
        border-radius: 4px;
        font-size: 15px;
        font-weight: 700;
        padding: 10px 50px;
    }
</style>