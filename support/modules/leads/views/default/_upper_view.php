<?php

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

?>

<section class="listCard mx-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="iconsDiv d-flex justify-content-center align-items-center">
                                <img src="<?= $this->params['baseurl'] ?>/images/whislist.svg" alt="Wishlist">
                            </div>
                            <div class="text-card">
                                <p>Current Active Leads</p>
                            </div>
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
            <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="iconsDiv d-flex justify-content-center align-items-center">
                                <img src="<?= $this->params['baseurl'] ?>/images/quote_request.svg" alt="Quotes">
                            </div>
                            <div class="text-card">
                                <p>Leads in Discussion</p>
                            </div>
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
                <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                    <div class="mainCard py-3 px-3">
                        <div class="cardChild d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="iconsDiv d-flex justify-content-center align-items-center">
                                    <img src="<?= $this->params['baseurl'] ?>/images/Icon material-twotone-currency-rupee.svg" alt="Quotes">
                                </div>
                                <div class="text-card">
                                    <p>Payment Received</p>
                                </div>
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
            <div class="col-xxl-3 col-xl-4 col-md-6 col-12 mb-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="iconsDiv d-flex justify-content-center align-items-center">
                                <img src="<?= $this->params['baseurl'] ?>/images/package_comment.svg" alt="Comment">
                            </div>
                            <div class="text-card">
                                <p>Pending Payments</p>
                            </div>
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