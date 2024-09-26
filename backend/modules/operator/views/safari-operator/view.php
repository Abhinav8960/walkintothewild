<?php

use common\models\GeneralModel;

$this->title = 'Safari Tour Operator : ' . $model->business_name;
$this->params['breadcrumbs_home_url'] = '/operator/safari-operator';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;

$budget = [];
if ($model->is_offer_premium_budget == 1) {
    $budget[] = "Premium";
}
if ($model->is_offer_standard_budget == 1) {
    $budget[] = "Standard";
}
if ($model->is_offer_economical_budget == 1) {
    $budget[] = "Economical";
}

$html = '';
$activies = GeneralModel::operatorresquestactivties($model->id);
foreach ($activies as $key => $role) {
    if (isset(GeneralModel::wildlifeactivities()[$key])) {
        $html .= GeneralModel::wildlifeactivities()[$key] . ', ';
    }
}

$html_park = '';
$park = GeneralModel::operatorpark($model->id);
foreach ($park as $key => $role) {
    if (isset(GeneralModel::safariparkoption()[$key])) {
        $html_park .= GeneralModel::safariparkoption()[$key] . ', ';
    }
}
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'overview']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="<?= $model->Imagepath ?>">
                            </div>
                            <div class="col-md-3">
                                <div class="text-box">
                                    <p>
                                        <span>Business Name:</span><?= $model->business_name ?>
                                    </p>
                                    <p>
                                        <span>Address: </span><?= $model->address ?>
                                    </p>
                                    <p>
                                        <span>Phone Number: </span><?= $model->phone_no ?>
                                    </p>
                                    <p>
                                        <span>Email Address: </span><?= $model->email ?>
                                    </p>
                                    <p>
                                        <span>Alternate Phone Number: </span><?= $model->operator_phone_no ?>
                                    </p>
                                    <p>
                                        <span>Alternate Email Address: </span><?= $model->operator_email ?>
                                    </p>
                                    <p>
                                        <span>Registered Name: </span><?= $model->register_comapany_name ?>
                                    </p>
                                    <p>
                                        <span>Category: </span><?php
                                                                if ($model->category_id) {
                                                                    echo isset(GeneralModel::operatorcategory()[$model->category_id]) ? GeneralModel::operatorcategory()[$model->category_id] : '';
                                                                } ?>
                                    </p>
                                    <p>
                                        <span>Approved Status:</span>
                                        <?php
                                        if ($model->is_approved) {
                                            echo isset(GeneralModel::yesnooption()[$model->is_approved]) ? GeneralModel::yesnooption()[$model->is_approved] : '';
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
                                        <span>Instagram Link: </span><a href="<?= $model->instagram_url ?>" target="_blank"><?= $model->instagram_url ?></a>
                                    </p>
                                    <p>
                                        <span>Facebook Link: </span><a href="<?= $model->facebook_url ?>" target="_blank"><?= $model->facebook_url ?></a>
                                    </p>
                                    <p>
                                        <span>Youtube Link: </span><a href="<?= $model->youtube_link ?>" target="_blank"><?= $model->youtube_link ?></a>
                                    </p>

                                    <p>
                                        <span>Website: </span><a href="<?= $model->website ?>"><?= $model->website ?></a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-box">

                                    <p>
                                        <span>Rating: </span><?= $model->google_rating ?>
                                    </p>
                                    <p>
                                        <span>Cancellation: </span><?= isset($model->has_cancellation_policy) ? GeneralModel::yesnooption()[$model->has_cancellation_policy] : '' ?>
                                    </p>
                                    <p>
                                        <span>Budget Segment: </span><?= implode(', ', $budget) ?>
                                    </p>
                                    <p>
                                        <span>Offers Other Wildlife Activities: </span><?= substr($html, 0, -2) ?>
                                    </p>

                                    <p>
                                        <span>Operates in Parks : </span><?= substr($html_park, 0, -2) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="text-box">
                                <p>
                                    <span>About Business: </span><?= $model->about_business ?>
                                </p>
                            </div>
                        </div>

                        <?php
                        $followerlist = $model->getFollowerlist()->where(['status' => 1])->all();
                        if ($followerlist) {
                        ?>
                            <div class="col-md-12 mt-4">
                                <h3>Follower List</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>User Profile</th>
                                                <th>Follow Datetime</th>
                                                <th>IP Address</th>
                                                <th>Device</th>
                                                <th>Platform/OS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($followerlist as $follower) {
                                                if ($user = $follower->user) {
                                            ?>
                                                    <tr>
                                                        <td><img src="<?= $follower->user->avatar != '' ? $follower->user->avatar : '/img/dpmain.png' ?>" class="rounded profile-picture" style="width:28px;"> <?= $user->name ?></td>
                                                        <td><?= $follower->follow_datetime ?></td>
                                                        <td><?= $follower->user_ip_address ?></td>
                                                        <td><?= $follower->user_device ?></td>
                                                        <td><?= $follower->user_platform ?></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-box p span {
        color: brown !important;
    }
</style>