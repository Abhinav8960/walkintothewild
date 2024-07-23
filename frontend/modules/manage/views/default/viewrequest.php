<?php

use common\models\GeneralModel;

$this->title = $safari_operator->business_name . ' | Manage Operator Business';

$budget = [];
if ($safari_operator_request->is_offer_premium_budget == 1) {
    $budget[] = "Premium";
}
if ($safari_operator_request->is_offer_standard_budget == 1) {
    $budget[] = "Standard";
}
if ($safari_operator_request->is_offer_economical_budget == 1) {
    $budget[] = "Economical";
}

$html = '';
$activies = GeneralModel::operatorresquestactivties($safari_operator_request->id);
foreach ($activies as $key => $role) {
    if (isset(GeneralModel::wildlifeactivities()[$key])) {
        $html .= GeneralModel::wildlifeactivities()[$key] . ', ';
    }
}

$park = GeneralModel::operatorresquestpark($safari_operator_request->id);

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
                    <div class="row mt-2 mb-5">
                        <div class="col-md-3">
                            <img src="<?= $safari_operator_request->Imagepath ?>" style="width:100%;">
                        </div>
                        <div class="col-md-3">
                            <div class="text-box">
                                <p>
                                    <span>Business Name:</span><?= $safari_operator_request->business_name ?>
                                </p>
                                <p>
                                    <span>Address: </span><?= $safari_operator_request->address ?>
                                </p>
                                <p>
                                    <span>Phone Number: </span><?= $safari_operator_request->phone_no ?>
                                </p>
                                <p>
                                    <span>Email Address: </span><?= $safari_operator_request->email ?>
                                </p>
                                <p>
                                    <span>Alternate Phone Number: </span><?= $safari_operator_request->operator_phone_no ?>
                                </p>
                                <p>
                                    <span>Alternate Email Address: </span><?= $safari_operator_request->operator_email ?>
                                </p>
                                <p>
                                    <span>Registered Name: </span><?= $safari_operator_request->register_comapany_name ?>
                                </p>
                                <p>
                                    <span>Category: </span><?php
                                                            if ($safari_operator_request->category_id) {
                                                                echo isset(GeneralModel::operatorcategory()[$safari_operator_request->category_id]) ? GeneralModel::operatorcategory()[$safari_operator_request->category_id] : '';
                                                            } ?>
                                </p>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-box">
                                <p>
                                    <span>Instagram Link: </span><a href="<?= $safari_operator_request->instagram_url ?>"><?= $safari_operator_request->instagram_url ?></a>
                                </p>
                                <p>
                                    <span>Facebook Link: </span><a href="<?= $safari_operator_request->facebook_url ?>"><?= $safari_operator_request->facebook_url ?></a>
                                </p>
                                <p>
                                    <span>Youtube Link: </span><a href="<?= $safari_operator_request->youtube_link ?>"><?= $safari_operator_request->youtube_link ?></a>
                                </p>

                                <p>
                                    <span>Website: </span><a href="<?= $safari_operator_request->website ?>"><?= $safari_operator_request->website ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-box">

                                <p>
                                    <span>Rating: </span><?= $safari_operator_request->google_rating ?>
                                </p>
                                <p>
                                    <span>Cancellation: </span><?= isset($safari_operator_request->has_cancellation_policy) ? GeneralModel::yesnooption()[$safari_operator_request->has_cancellation_policy] : '' ?>
                                </p>
                                <p>
                                    <span>Budget Segment: </span><?= implode(', ', $budget) ?>
                                </p>
                                <p>
                                    <span>Offers Other Wildlife Activities: </span><?= substr($html, 0, -2) ?>
                                </p>

                                <p>
                                    <span>Agree to the terms and conditions.: </span><?= ($safari_operator_request->is_agree == 1) ? 'Yes' : 'No' ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-box">
                                <p>
                                    <span>About Business: </span><?= $safari_operator_request->about_business ?>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h4>Park List</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <td>Park Name</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $srn = 1;
                                    foreach ($park as $key => $park_name) {
                                    ?>
                                        <tr>
                                            <td><?= $srn ?></td>
                                            <td><?= $park_name ?></td>
                                        </tr>
                                    <?php

                                        $srn++;
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>