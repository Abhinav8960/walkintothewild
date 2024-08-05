<?php

use common\models\GeneralModel;

$this->title = 'Safari Operator Tour Registrations';
$this->params['breadcrumbs_home_url'] = '/registration/safari-operator-tour';
$this->params['breadcrumbs'][] =  ['label' => 'Registration', 'url' => '#'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;

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
<section class="profile-wrapper">
    <div class="container-lg mb-5">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['business' => 'active', 'user' => $user]) ?>
    </div>
</section>

<section>
<div class="container">
<div class="row justify-content-center margin_bottomfooter">
    <div class="col-xl-11 ">
    <div class="card account-settingside">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                        <img src="<?= $safari_operator_request->Imagepath ?>" style="height:180px; object-fit:cover;" class="w-100 rounded-2">
                        </div>
                        <div class="col-md-9 ">
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="text-box">
                                        <p><strong>Business Name : </strong><?= $safari_operator_request->business_name ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="text-box">
                                        <p><strong>Phone Number : </strong><?= $safari_operator_request->phone_no ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="text-box">
                                        <p><strong>Alternate Phone Number : </strong><?= $safari_operator_request->operator_phone_no ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="text-box">
                                        <p><strong>Email Address : </strong><?= $safari_operator_request->email ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="text-box">
                                        <p><strong>Alternate Email Address : </strong><?= $safari_operator_request->operator_email ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="text-box">
                                        <p><strong>Category : </strong><?php
                                                    if ($safari_operator_request->category_id) {
                                                        echo isset(GeneralModel::operatorcategory()[$safari_operator_request->category_id]) ? GeneralModel::operatorcategory()[$safari_operator_request->category_id] : '';
                                                    } ?>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="text-box">
                                        <p><strong>Registered Name : </strong><?= $safari_operator_request->register_comapany_name ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="text-box">
                                        <p><strong>Agree to the terms and conditions : </strong> <?= ($safari_operator_request->is_agree == 1) ? 'Yes' : 'No' ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="text-box">
                                        <p><strong>Rating : </strong> <?= $safari_operator_request->google_rating ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="text-box">
                                        <p><strong>Cancellation : </strong> <?= isset($safari_operator_request->has_cancellation_policy) ? GeneralModel::yesnooption()[$safari_operator_request->has_cancellation_policy] : '' ?></p>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="text-box">
                                        <p><strong>Budget Segment : </strong> <?= implode(', ', $budget) ?></p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Address : </strong><?= $safari_operator_request->address ?></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Offers Other Wildlife Activities : </strong><?= substr($html, 0, -2) ?></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Instagram Link : </strong><a href="<?= $safari_operator_request->instagram_url ?>"><?= $safari_operator_request->instagram_url ?></a></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Facebook Link : </strong><a href="<?= $safari_operator_request->facebook_url ?>"><?= $safari_operator_request->facebook_url ?></a></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Youtube Link : </strong><a href="<?= $safari_operator_request->youtube_link ?>"><?= $safari_operator_request->youtube_link ?></a></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>Website : </strong><a href="<?= $safari_operator_request->website ?>"><?= $safari_operator_request->website ?></a></p>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="text-box">
                                <p><strong>About Business : </strong><?= $safari_operator_request->about_business ?></p>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                     <h6 class="fs-4 fw-bold mb-3">Park List</h6>
                     <div class="table-responsive table_design_manage">
                     <table class="table border">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Park Name</th>
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
  

</div>
</section>
