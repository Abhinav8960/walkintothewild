<?php

use common\interfaces\StatusInterface;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\GeneralModel;

$budget = [];
if ($safari_operator->is_offer_premium_budget == 1) {
    $budget[] = "Premium";
}
if ($safari_operator->is_offer_standard_budget == 1) {
    $budget[] = "Standard";
}
if ($safari_operator->is_offer_economical_budget == 1) {
    $budget[] = "Economical";
}

$html = '';
$activies = GeneralModel::operatoractivties($safari_operator->id);
foreach ($activies as $key => $role) {
    if (isset(GeneralModel::wildlifeactivities()[$key])) {
        $html .= GeneralModel::wildlifeactivities()[$key] . ', ';
    }
}
$this->title = $safari_operator->businessname . ' | Manage Operator Business';

?>


<div class="container-lg mt-5 pt-5 ">
    <div class="row margin_bottomfooter ">
        <div class="col-md-12 d-flex justify-content-between mb-4 align-items-center flex-wrap">
            <h6 class="fs-3 fw-bold mb-0"><?= $this->title ?></h6>
            <div class=" mt-xxl-0 mt-3">
                <?php if ($safari_operator->status == StatusInterface::STATUS_ACTIVE) { ?>
                    <a href="<?= Url::toRoute(['/operator/default/sharedsafari', 'slug' => $safari_operator->slug]) ?>" class="post-comment newbg rounded-2 padding_btn" target="_blank"><i class="fa fa-eye"></i> View as Member</a> &nbsp;
                    <a href="<?= Url::toRoute(['/manage/default/edit-request']) ?>" class="btn_newsafari organizeBtn newbg text-center rounded-2 "><i class="fa fa-edit"></i> Update Page</a>
                <?php } ?>
            </div>
        </div>
        <div class=" col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('_sidebar', ['active' => 'profile']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8 ">
            <div class="card account-settingside">
                <div class="card-body p-4">
                    <div class="row">
                        <?php if ($safari_operator->status != StatusInterface::STATUS_ACTIVE) {
                            echo $this->context->module->account_deactivate_message;
                        } ?>
                        <div class="col-md-12 col-xl-3">
                            <?php if ($safari_operator->imagepath) { ?>
                                <img src="<?= $safari_operator->imagepath ?>" class="mb-2 w-100 rounded-2" style="height:180px; object-fit:cover;">
                            <?php } ?>
                        </div>
                        <div class="col-md-12 col-xl-9">
                            <div class="row">
                                <div class="col-md-6  col-xxl-6 col-lg-6">
                                    <div class="text-box">
                                        <p><strong>Business Name : </strong><?= $safari_operator->business_name ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xxl-6 col-lg-6  ">
                                    <div class="text-box">
                                        <p><strong>Phone Number : </strong><?= $safari_operator->phone_no ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xxl-6 col-lg-6  ">
                                    <div class="text-box">
                                        <p><strong>Alternate Phone Number : </strong><?= $safari_operator->operator_phone_no ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xxl-6 col-lg-6 ">
                                    <div class="text-box">
                                        <p><strong>Email Address : </strong><?= $safari_operator->email ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xxl-6 col-lg-6">
                                    <div class="text-box">
                                        <p><strong>Alternate Email Address : </strong><?= $safari_operator->operator_email ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xxl-6 col-lg-6 ">
                                    <div class="text-box">
                                        <p><strong>Category : </strong><?php


                                                                        if ($safari_operator->category_id) {
                                                                            echo isset(GeneralModel::operatorcategory()[$safari_operator->category_id]) ? GeneralModel::operatorcategory()[$safari_operator->category_id] : '';
                                                                        } ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xxl-6 col-lg-6 ">
                                    <div class="text-box">
                                        <p><strong>Registered Name : </strong><?= $safari_operator->operator_phone_no ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xxl-6 col-lg-6 ">
                                    <div class="text-box">
                                        <p><strong>Approved Status : </strong> <?php
                                                                                if ($safari_operator->is_approved) {
                                                                                    echo isset(GeneralModel::yesnooption()[$safari_operator->is_approved]) ? GeneralModel::yesnooption()[$safari_operator->is_approved] : '';
                                                                                } else {
                                                                                    echo 'No';
                                                                                }
                                                                                ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xxl-6 col-lg-6 ">
                                    <div class="text-box">
                                        <p><strong>Rating : </strong> <?= $safari_operator->google_rating ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xxl-6 col-lg-6 ">
                                    <div class="text-box">
                                        <p><strong>Cancellation : </strong> <?= isset($safari_operator->has_cancellation_policy) ? GeneralModel::yesnooption()[$safari_operator->has_cancellation_policy] : '' ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6  col-xxl-6 col-lg-6 ">
                                    <div class="text-box">
                                        <p><strong>Budget Segment : </strong> <?= implode(', ', $budget) ?></p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Address : </strong><?= $safari_operator->register_comapany_name ?></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Offers Other Wildlife Activities : </strong><?= substr($html, 0, -2) ?></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Instagram Link : </strong><a href="<?= $safari_operator->instagram_url ?>" target="_blank"><?= $safari_operator->instagram_url ?></a></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Facebook Link : </strong><a href="<?= $safari_operator->facebook_url ?>" target="_blank"><?= $safari_operator->facebook_url ?></a></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Youtube Link : </strong><a href="<?= $safari_operator->youtube_link ?>" target="_blank"><?= $safari_operator->youtube_link ?></a></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Website : </strong><a href="<?= $safari_operator->website ?>"><?= $safari_operator->website ?></a></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>About Business : </strong><?= $safari_operator->about_business ?></p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>