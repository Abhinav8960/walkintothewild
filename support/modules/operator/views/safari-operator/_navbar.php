<?php

use yii\helpers\Url;
?>
<div class="card mg-b-20 bg-transparent border-0" id="tabs-style2">
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-xl-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <div class="text-card mb-3">
                            <p>Shared Safari</p>
                        </div>
                        <div class="numbwrCount d-flex gap-5">
                            <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center">
                                <img src="<?= $this->params['baseurl'] ?>/images/lead_dashboard.svg"
                                    class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                            </div>
                            <h3 class="">
                                <?= isset($model->safaricount) ? $model->safaricount : ''; ?>
                            </h3>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <div class="text-card mb-3">
                            <p>Fixed Departure</p>
                        </div>
                        <div class="numbwrCount d-flex gap-5">
                            <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center" style="background-color: #FFF4EE;">
                                <img src="<?= $this->params['baseurl'] ?>/images/fixeddepa.png"
                                    class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                            </div>
                                <h3 class="">
                                    <?= isset($model->sharedsafaricount) ? $model->sharedsafaricount : ''; ?>
                                </h3>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                        <div class="text-card mb-3">
                            <p>Package</p>
                        </div>
                        <div class="numbwrCount d-flex gap-5">
                               <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center" style="background-color: #DDFFE7;">
                                <img src="<?= $this->params['baseurl'] ?>/images/package.png"
                                    class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                            </div>
                                <h3 class="">
                                    <?= isset($model->packagecount) ? $model->packagecount : ''; ?>
                                </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="mainCard py-3 px-3">
                    <div class="cardChild">
                          <div class="text-card mb-3">
                            <p>Quotes</p>
                        </div>
                        <div class="numbwrCount d-flex gap-5">
                              <div class="iconsDiv mb-2 d-flex justify-content-center align-items-center" style="background-color: #AAAAAA;">
                                <img src="<?= $this->params['baseurl'] ?>/images/qut.png"
                                    class="" alt="" style="width: 11px; height: 11px; object-fit: cover;">
                            </div>
                                <h3 class="">
                                    <?= isset($model->quotescount) ? $model->quotescount : ''; ?>
                                </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- STATIC TABS NEW START HERE  -->
    <div class="">
        <div class="assign-tabs operatorTab">

            <ul class="nav nav-tabs flex-row flex-wrap" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                <a href="/operator/safari-operator/view?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'overview' ? 'active' : '' ?>">Overview</a>

                </li>
                <li class="nav-item" role="presentation">
                <a href="/operator/safari-operator/legal-entity?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'legal_entity' ? 'active' : '' ?>">Legal Entity</a>
                </li>
                <li class="nav-item" role="presentation">
                <a href="/operator/safari-operator/registration-proof?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'registration_proof' ? 'active' : '' ?>">Registration Proof</a>
                </li>
                <li class="nav-item" role="presentation">
                <a href="/operator/safari-operator/business?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'business' ? 'active' : '' ?>">Business</a>
                </li>
                <li class="nav-item" role="presentation">
                <a href="/operator/safari-operator/bank-details?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'bank_details' ? 'active' : '' ?>">Bank Details</a>
                </li>
                <li class="nav-item" role="presentation">
                <a href="/operator/safari-operator/user-kyc?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'user_kyc' ? 'active' : '' ?>">User KYC</a>
                </li>
                <li class="nav-item" role="presentation">
                <a href="/operator/safari-operator/user-review?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'user_review' ? 'active' : '' ?>">User Review</a>
                </li>
                <li class="nav-item" role="presentation">
                <a href="/operator/safari-operator/operator-parks?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'operator_park' ? 'active' : '' ?>">Operator Park</a>
                </li>
            </ul>

        </div>

    </div>
    <!-- STATIC TABS NEW END HERE  -->








    <?php
$script = <<< JS

function organizefunction() {
	$('.btn_userarticle').on('click', function () {
        $('#organize-modal').modal('show')
		.find('#userstatusmodalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();
JS;
$this->registerJs($script);
?>