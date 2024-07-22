<?php

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
$this->title = $safari_operator->business_name . ' | Manage Operator Business';

?>


<div class="container mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <h5><?= $this->title ?></h5>
        </div>
        <div class="col-md-3">
            <?= $this->render('_sidebar', ['active' => 'profile']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($safari_operator->imagepath) { ?>
                                <img src="<?= $safari_operator->imagepath ?>" style="width:100%;" class="mb-2">
                            <?php } ?>
                            <div class="text-box">
                                <p>
                                    <span>Business Name:</span><?= $safari_operator->business_name ?>
                                </p>
                                <p>
                                    <span>Address: </span><?= $safari_operator->address ?>
                                </p>
                                <p>
                                    <span>Phone Number: </span><?= $safari_operator->phone_no ?>
                                </p>
                                <p>
                                    <span>Email Address: </span><?= $safari_operator->email ?>
                                </p>
                                <p>
                                    <span>Alternate Phone Number: </span><?= $safari_operator->operator_phone_no ?>
                                </p>
                                <p>
                                    <span>Alternate Email Address: </span><?= $safari_operator->operator_email ?>
                                </p>
                                <p>
                                    <span>Registered Name: </span><?= $safari_operator->register_comapany_name ?>
                                </p>
                                <p>
                                    <span>Category: </span><?php


                                                            if ($safari_operator->category_id) {
                                                                echo isset(GeneralModel::operatorcategory()[$safari_operator->category_id]) ? GeneralModel::operatorcategory()[$safari_operator->category_id] : '';
                                                            } ?>
                                </p>
                                <p>
                                    <span>Approved Status:</span>
                                    <?php
                                    if ($safari_operator->is_approved) {
                                        echo isset(GeneralModel::yesnooption()[$safari_operator->is_approved]) ? GeneralModel::yesnooption()[$safari_operator->is_approved] : '';
                                    } else {
                                        echo 'No';
                                    }
                                    ?>
                                </p>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-box">
                                <p>
                                    <span>Instagram Link: </span><a href="<?= $safari_operator->instagram_url ?>" target="_blank"><?= $safari_operator->instagram_url ?></a>
                                </p>
                                <p>
                                    <span>Facebook Link: </span><a href="<?= $safari_operator->facebook_url ?>" target="_blank"><?= $safari_operator->facebook_url ?></a>
                                </p>
                                <p>
                                    <span>Youtube Link: </span><a href="<?= $safari_operator->youtube_link ?>" target="_blank"><?= $safari_operator->youtube_link ?></a>
                                </p>

                                <p>
                                    <span>Website: </span><a href="<?= $safari_operator->website ?>"><?= $safari_operator->website ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-box">

                                <p>
                                    <span>Rating: </span><?= $safari_operator->google_rating ?>
                                </p>
                                <p>
                                    <span>Cancellation: </span><?= isset($safari_operator->has_cancellation_policy) ? GeneralModel::yesnooption()[$safari_operator->has_cancellation_policy] : '' ?>
                                </p>
                                <p>
                                    <span>Budget Segment: </span><?= implode(', ', $budget) ?>
                                </p>
                                <p>
                                    <span>Offers Other Wildlife Activities: </span><?= substr($html, 0, -2) ?>
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="text-box">
                            <p>
                                <span>About Business: </span><?= $safari_operator->about_business ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>