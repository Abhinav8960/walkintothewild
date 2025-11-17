<?php

/** @var yii\web\View $this */

use common\models\GeneralModel;
use yii\helpers\Url;

$this->title = 'Dashboard';
// $this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="tab-content" id="pills-tabContent">
    <div class="response">
        <div class="col-xl-12">
            <!-- BEGIN row new operator -->
            <strong>
                <p>Pending For Approvals</p>
            </strong>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                <!-- BEGIN col-6 -->
                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/packageapproval/default/index']) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Package</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= isset($package_model) ? $package_model : '0' ?></div>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/sharesafari/fixed-departure/index']) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">Fixed Departure</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($fixed_departure_model) ? $fixed_departure_model : '0' ?></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/pendingapproval/operator-review/index']) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">Operator Review</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($operator_review_model) ? $operator_review_model : '0' ?></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/pendingapproval/park-review-approval/index']) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">Park Review</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($park_review_model) ? $park_review_model : '0' ?></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/galleryapproval/default/index']) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">Gallery Approval</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($gallery_model) ? $gallery_model : '0' ?></div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>

        <div class="col-xl-12">
            <!-- BEGIN row new operator -->
            <strong>
                <p>Flags</p>
            </strong>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                <!-- BEGIN col-6 -->
                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/flag/user-post/index']) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">Posts</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Count: <?= isset($post_model) ? $post_model : '0' ?></div>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/flag/sighting/index']) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">Sightings</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($sighting_model) ? $sighting_model : '0' ?></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/flag/share-safari/index']) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">Share Safari</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($share_safari_flag_mmodel) ? $share_safari_flag_mmodel : '0' ?></div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::to(['/flag/package/index']) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">Package </h5>
                                <div class=" text-opacity-80 text-end colorammount"> Count: <?= isset($package_flag_model) ? $package_flag_model : '0' ?></div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>



        <div class="col-xl-12">
            <!-- BEGIN row new operator -->
            <strong>
                <p>API Services Status</p>
            </strong>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                <!-- BEGIN col-6 -->
                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::toRoute(['/log/sms-log/index']) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class=" text-opacity-80 mb-3 fs-16px">SMS</h5>
                                <div class="  text-opacity-80 text-end colorammount"> Last Status: <?= $last_sms_status->statuslabels ?? '-' ?></div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a style="text-decoration:none;" href="<?= Url::toroute(['/log/call-log/index']) ?>">
                        <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-blue-new" style="min-height: 120px;">
                            <div class="card-img-overlay mb-n4 me-n4 d-flex" style="bottom: 0; top: auto;">
                                <img src="<?= $this->params['baseurl'] ?>/img/icon/order.svg" alt="" class="ms-auto d-block mb-n3" style="max-height: 50px">
                            </div>
                            <div class="card-body position-relative">
                                <h5 class="text-opacity-80 mb-3 fs-16px">Call</h5>
                                <div class=" text-opacity-80 text-end colorammount"> Last Status: <?= $last_call_status->callstatuslabel ?? '-' ?></div>
                            </div>
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