<?php

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

?>

<section class="listCard mx-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
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
                                    <h3><?= $leadModel->activeLeadCount ?></h3>
                                </div>
                            <?php } else {  ?>
                                <div class="numbwrCount">
                                    <h3>0</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
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
                                    <h3><?= $leadModel->partner_chat_started_count ?></h3>
                                </div>
                            <?php } else {  ?>
                                <div class="numbwrCount">
                                    <h3>0</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
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
                                    <h3><?= $leadModel->paymentReceivedCount ?></h3>
                                </div>
                            <?php } else {  ?>
                                <div class="numbwrCount">
                                    <h3>0</h3>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
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
                                    <h3><?= $leadModel->pendingPaymentCount ?></h3>
                                </div>
                            <?php } else {  ?>
                                <div class="numbwrCount">
                                    <h3>0</h3>
                                </div>
                            <?php } ?>
                        </div>
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