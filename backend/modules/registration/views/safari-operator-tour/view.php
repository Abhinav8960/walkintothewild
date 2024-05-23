<?php

use common\models\GeneralModel;

$this->title = 'Safari Operator Tour Registrations';
$this->params['breadcrumbs_home_url'] = '/registration/safari-operator-tour';
$this->params['breadcrumbs'][] =  ['label' => 'Registration', 'url' => '#'];
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



$activities = [];
if ($model->is_wildlife_trekking == 1) {
    $activities[] = "Wildlife Trekking/Hiking";
}
if ($model->is_wildlife_non_safari_drive == 1) {
    $activities[] = "Wildlife Safari";
}
if ($model->is_bird_watching == 1) {
    $activities[] = "Birding Safari";
}

if ($model->is_camping == 1) {
    $activities[] = "Camping";
}
?>

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
                        <span>Email Address: </span><?= $model->email ?>
                    </p>
                    <p>
                        <span>Registered Name: </span><?= $model->register_comapany_name ?>
                    </p>
                    <p>
                        <span>Category: </span><?= isset($model->category_id) ? GeneralModel::operatorcategory()[$model->category_id] : '' ?>
                    </p>

                </div>
            </div>
            <div class="col-md-3">
                <div class="text-box">
                    <p>
                        <span>Instagram Link: </span><a href="<?= $model->instagram_url ?>"><?= $model->instagram_url ?></a>
                    </p>
                    <p>
                        <span>Facebook Link: </span><a href="<?= $model->facebook_url ?>"><?= $model->facebook_url ?></a>
                    </p>
                    <p>
                        <span>Youtube Link: </span><a href="<?= $model->youtube_link ?>"><?= $model->youtube_link ?></a>
                    </p>

                    <p>
                        <span>Website: </span><a href="<?= $model->website ?>"><?= $model->website ?></a>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-box">

                    <p>
                        <span>Google Rating: </span><?= $model->google_rating ?>
                    </p>
                    <p>
                        <span>Cancellation: </span><?= isset($model->has_cancellation_policy) ? GeneralModel::yesnooption()[$model->has_cancellation_policy] : '' ?>
                    </p>
                    <p>
                        <span>Budget Segment: </span><?= implode(', ', $budget) ?>
                    </p>
                    <p>
                        <span>Offers Other Wildlife Activities: </span><?= implode(', ', $activities)  ?>
                    </p>
                </div>
            </div>
        </div>
        <p>
            <span>About Business: </span><?= $model->about_business ?>
        </p>
    </div>
</div>

<style>
    .text-box p span {
        color: brown !important;
    }
</style>