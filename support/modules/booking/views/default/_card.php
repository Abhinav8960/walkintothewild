<?php

use common\models\GeneralModel;

$webasset = $this->assetManager->getBundle('\business\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

?>
<section class="listCard mb-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <div class="text-card mb-3">
                            <p>Total Bookings</p>
                        </div>
                        <div class="numbwrCount d-flex gap-5">
                            <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                                <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg"
                                    class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                            </div>
                            <?php if ($totalbookings) { ?>
                                <div class="numbwrCount">
                                    <h3><?= $totalbookings ?></h3>
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
            <div class="col-xl-4">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <div class="text-card mb-3">
                            <p>Total Customers</p>
                        </div>
                        <div class="numbwrCount d-flex gap-5">
                            <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center" style="background-color: #FFF4EE;">
                                <img src="<?= $this->params['baseurl'] ?>/images/fixeddepa.png"
                                    class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                            </div>
                            <?php if ($totalcustomers) { ?>
                                <div class="numbwrCount">
                                    <h3><?= $totalcustomers ?></h3>
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
            <div class="col-xl-4">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <div class="text-card mb-3">
                            <p>Total Amount</p>
                        </div>
                        <div class="numbwrCount d-flex gap-5">
                            <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center" style="background-color: #DDFFE7;">
                                <img src="<?= $this->params['baseurl'] ?>/images/package.png"
                                    class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                            </div>
                            <?php if ($totalamount) { ?>
                                <div class="numbwrCount">
                                    <h3><?= '<span style="font-weight: bold; color: #2E8B57; margin-right:5px">₹</span>'. GeneralModel::number_format_indian($totalamount) ?></h3>
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