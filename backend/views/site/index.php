<?php

/** @var yii\web\View $this */

use common\models\GeneralModel;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="tab-content" id="pills-tabContent">
    <div class="response">
        <div class="col-xl-12">
            <!-- BEGIN row new operator -->
            <strong>
                <p>New Operator</p>
            </strong>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                <!-- BEGIN col-6 -->
                <div class="col">
                    <a style="text-decoration:none;" href="/operator/safari-operator/index?SafariOperatorSearch%5Breport_days%5D=today">

                        <!-- BEGIN card -->
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Today</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= isset($todaynew_operator) ? GeneralModel::numberformat(round($todaynew_operator, 0)) : '0' ?></div>

                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/operator/safari-operator/index?SafariOperatorSearch%5Breport_days%5D=tw">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Week</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thisweek_new_operator) ? GeneralModel::numberformat(round($thisweek_new_operator, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/operator/safari-operator/index?SafariOperatorSearch%5Breport_days%5D=tm">

                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thismonth_new_operator) ? GeneralModel::numberformat(round($thismonth_new_operator, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/operator/safari-operator/index?SafariOperatorSearch%5Breport_days%5D=lm">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Last Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($lastmonth_new_operator) ? GeneralModel::numberformat(round($lastmonth_new_operator, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/operator/safari-operator/index?SafariOperatorSearch%5Breport_days%5D=all">

                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Total </h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($total_new_operator) ? GeneralModel::numberformat(round($total_new_operator, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
            </div>

            <!-- BEGIN row operator request quote -->
            <strong>
                <p>Operator Request Quote</p>
            </strong>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                <!-- BEGIN col-6 -->
                <div class="col">
                    <a style="text-decoration:none;" href="/park/operator-quote/index?OperatorQuoteSearch%5Breport_days%5D=today">
                        <!-- BEGIN card -->
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Today</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= isset($todayoperator_request_quote) ? GeneralModel::numberformat(round($todayoperator_request_quote, 0)) : '0' ?></div>

                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/park/operator-quote/index?OperatorQuoteSearch%5Breport_days%5D=tw">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Week</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thisweek_operator_request_quote) ? GeneralModel::numberformat(round($thisweek_operator_request_quote, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/park/operator-quote/index?OperatorQuoteSearch%5Breport_days%5D=tm">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thismonth_operator_request_quote) ? GeneralModel::numberformat(round($thismonth_operator_request_quote, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/park/operator-quote/index?OperatorQuoteSearch%5Breport_days%5D=lm">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Last Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($lastmonth_operator_request_quote) ? GeneralModel::numberformat(round($lastmonth_operator_request_quote, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/park/operator-quote/index?OperatorQuoteSearch%5Breport_days%5D=all">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Total </h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($total_operator_request_quote) ? GeneralModel::numberformat(round($total_operator_request_quote, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
            </div>


            <!-- BEGIN row new package -->
            <strong>
                <p>New Package</p>
            </strong>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                <!-- BEGIN col-6 -->
                <div class="col">
                    <a style="text-decoration:none;" href="/package/default/index?PackageSearch%5Breport_days%5D=today">

                        <!-- BEGIN card -->
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Today</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= isset($todaynew_package) ? GeneralModel::numberformat(round($todaynew_package, 0)) : '0' ?></div>

                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/package/default/index?PackageSearch%5Breport_days%5D=tw">

                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Week</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thisweek_new_package) ? GeneralModel::numberformat(round($thisweek_new_package, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/package/default/index?PackageSearch%5Breport_days%5D=tm">

                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thismonth_new_package) ? GeneralModel::numberformat(round($thismonth_new_package, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/package/default/index?PackageSearch%5Breport_days%5D=lm">

                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Last Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($lastmonth_new_package) ? GeneralModel::numberformat(round($lastmonth_new_package, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/package/default/index?PackageSearch%5Breport_days%5D=all">

                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Total </h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($total_new_package) ? GeneralModel::numberformat(round($total_new_package, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
            </div>


            <!-- BEGIN row package request quote -->
            <strong>
                <p>Package Request Quote</p>
            </strong>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                <!-- BEGIN col-6 -->
                <div class="col">

                    <a style="text-decoration:none;" href="/package/quote?PackageQuoteSearch%5Breport_days%5D=today">
                        <!-- BEGIN card -->
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Today</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= isset($todaypackage_request_quote) ? GeneralModel::numberformat(round($todaypackage_request_quote, 0)) : '0' ?></div>

                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/package/quote?PackageQuoteSearch%5Breport_days%5D=tw">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Week</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thisweek_package_request_quote) ? GeneralModel::numberformat(round($thisweek_package_request_quote, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/package/quote?PackageQuoteSearch%5Breport_days%5D=tm">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thismonth_package_request_quote) ? GeneralModel::numberformat(round($thismonth_package_request_quote, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/package/quote?PackageQuoteSearch%5Breport_days%5D=lm">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Last Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($lastmonth_package_request_quote) ? GeneralModel::numberformat(round($lastmonth_package_request_quote, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/package/quote?PackageQuoteSearch%5Breport_days%5D=all">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Total </h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($total_package_request_quote) ? GeneralModel::numberformat(round($total_package_request_quote, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
            </div>




            <!-- BEGIN row new share safari -->
            <strong>
                <p>New Share Safari</p>
            </strong>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                <!-- BEGIN col-6 -->
                <div class="col">
                    <a style="text-decoration:none;" href="/sharesafari/default/index?ShareSafariSearch%5Breport_days%5D=today&ShareSafariSearch%5Btype%5D=1">
                        <!-- BEGIN card -->
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Today</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= isset($todaynew_share_safari) ? GeneralModel::numberformat(round($todaynew_share_safari, 0)) : '0' ?></div>

                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/sharesafari/default/index?ShareSafariSearch%5Breport_days%5D=tw&ShareSafariSearch%5Btype%5D=1">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Week</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thisweek_new_share_safari) ? GeneralModel::numberformat(round($thisweek_new_share_safari, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/sharesafari/default/index?ShareSafariSearch%5Breport_days%5D=tm&ShareSafariSearch%5Btype%5D=1">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thismonth_new_share_safari) ? GeneralModel::numberformat(round($thismonth_new_share_safari, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/sharesafari/default/index?ShareSafariSearch%5Breport_days%5D=lm&ShareSafariSearch%5Btype%5D=1">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Last Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($lastmonth_new_share_safari) ? GeneralModel::numberformat(round($lastmonth_new_share_safari, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/sharesafari/default/index?ShareSafariSearch%5Breport_days%5D=al&ShareSafariSearch%5Btype%5D=1l">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Total </h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($total_new_share_safari) ? GeneralModel::numberformat(round($total_new_share_safari, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
            </div>



            <!-- BEGIN row new fixed departure -->
            <strong>
                <p>New Fixed Departure</p>
            </strong>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                <!-- BEGIN col-6 -->
                <div class="col">
                    <a style="text-decoration:none;" href="/sharesafari/default/index?ShareSafariSearch%5Breport_days%5D=today&ShareSafariSearch%5Btype%5D=2">

                        <!-- BEGIN card -->
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Today</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= isset($todaynew_fixed_departure) ? GeneralModel::numberformat(round($todaynew_fixed_departure, 0)) : '0' ?></div>

                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/sharesafari/default/index?ShareSafariSearch%5Breport_days%5D=tw&ShareSafariSearch%5Btype%5D=2">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Week</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thisweek_new_fixed_departure) ? GeneralModel::numberformat(round($thisweek_new_fixed_departure, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/sharesafari/default/index?ShareSafariSearch%5Breport_days%5D=tm&ShareSafariSearch%5Btype%5D=2">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thismonth_new_fixed_departure) ? GeneralModel::numberformat(round($thismonth_new_fixed_departure, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/sharesafari/default/index?ShareSafariSearch%5Breport_days%5D=lm&ShareSafariSearch%5Btype%5D=2">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Last Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($lastmonth_new_fixed_departure) ? GeneralModel::numberformat(round($lastmonth_new_fixed_departure, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/sharesafari/default/index?ShareSafariSearch%5Breport_days%5D=all&ShareSafariSearch%5Btype%5D=2">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Total </h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($total_new_fixed_departure) ? GeneralModel::numberformat(round($total_new_fixed_departure, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
            </div>


            <!-- BEGIN row new article -->
            <strong>
                <p>New Article</p>
            </strong>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                <!-- BEGIN col-6 -->
                <div class="col">
                    <a style="text-decoration:none;" href="/cms/article/index?ArticleSearch%5Breport_days%5D=today">
                        <!-- BEGIN card -->
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Today</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= isset($todaynew_article) ? GeneralModel::numberformat(round($todaynew_article, 0)) : '0' ?></div>

                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/cms/article/index?ArticleSearch%5Breport_days%5D=tw">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Week</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thisweek_new_article) ? GeneralModel::numberformat(round($thisweek_new_article, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/cms/article/index?ArticleSearch%5Breport_days%5D=tm">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">This Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($thismonth_new_article) ? GeneralModel::numberformat(round($thismonth_new_article, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/cms/article/index?ArticleSearch%5Breport_days%5D=lm">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Last Month</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($lastmonth_new_article) ? GeneralModel::numberformat(round($lastmonth_new_article, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="/cms/article/index?ArticleSearch%5Breport_days%5D=all">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <!-- BEGIN card-img-overlay -->
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <!-- END card-img-overlay -->

                            <!-- BEGIN card-body -->
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px"> Total </h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($total_new_article) ? GeneralModel::numberformat(round($total_new_article, 0)) : '0' ?></div>
                            </div>
                            <!-- BEGIN card-body -->
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .response a {
        color: black !important;
    }

    .response .card {
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px !important;
        border: 1px solid #09422D !important;
    }
</style>