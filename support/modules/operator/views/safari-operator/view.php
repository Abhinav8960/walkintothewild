<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Safari Tour Operator : ' . $model->business_name;
$this->params['breadcrumbs_home_url'] = '/operator/safari-operator';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;
// $this->params['buttons'][] = Html::button('Change Logo', ['value' => Url::toRoute(['change-logo', 'id' => $model->id]), 'class' => 'btn btn-orange change-logo-popup', 'title' => 'Change Logo']);

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
    <?= $this->render('@support/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'overview']) ?>

    <!-- <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="<?= $model->Imagepath ?? ''?>">
                            </div>
                            <div class="col-md-3">
                                <div class="text-box">
                                    <p>
                                        <span>Business Name:</span><?= $model->business_name ?? 'N/A'?>
                                    </p>
                                    <p>
                                        <span>Address: </span><?= $model->address ?? 'N/A'?>
                                    </p>
                                    <p>
                                        <span>Phone Number: </span><?= $model->phone_no ?? 'N/A'?>
                                    </p>
                                    <p>
                                        <span>Email Address: </span><?= $model->email ?? 'N/A'?>
                                    </p>
                                    <p>
                                        <span>Alternate Phone Number: </span><?= $model->operator_phone_no ?? 'N/A'?>
                                    </p>
                                    <p>
                                        <span>Alternate Email Address: </span><?= $model->operator_email ?? 'N/A'?>
                                    </p>
                                    <p>
                                        <span>Registered Name: </span><?= $model->register_comapany_name ?? 'N/A'?>
                                    </p>
                                   
                                    <p>
                                        <span>Registered Number: </span><?= $model->registration_number ?? 'N/A'?>
                                    </p>                                      
                                    <p>
                                        <span>Registered File: </span>
                                        <?php if (!empty($model->registration_copy_upload) && strtolower(pathinfo($model->registration_copy_upload, PATHINFO_EXTENSION)) === 'pdf'){?>
                                            <button value="<?= Url::to(['file-view', 'filepath' => $model->registration_copy_upload]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                                    <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" style = "width : 40px ; height : 40px;">
                                            </button>
                                        <?php } else{ ?>
                                            <span class="text-muted" style="color: #6c757d !important;">No file uploaded</span>
                                        <?php } ?>
                                    </p>
                                    <p>
                                        <span>PanCard Number: </span><?= $model->pan_number ?? 'N/A'?>
                                    </p>                                      
                                    <p>
                                        <span>PanCard File: </span>
                                        <?php if (!empty($model->pan_upload)){?>
                                            <button value="<?= Url::to(['file-view', 'filepath' => $model->pan_upload]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                                <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" style = "width : 40px ; height : 40px;">
                                            </button>
                                        <?php } else{ ?>
                                            <span class="text-muted" style="color: #6c757d !important;">No file uploaded</span>
                                        <?php } ?>
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
                                        <span>Offers Other Wildlife Activities: </span><?= !empty($html) ? substr($html, 0, -2) : 'N/A' ?>
                                    </p>

                                    <p>
                                        <span>Operates in Parks : </span><?= !empty($html_park) ? substr($html_park, 0, -2) : 'N/A'?>
                                    </p>
                                    <p>
                                        <span>Billing Phone : </span><?= $model->billing_phone ?? 'N/A'?>
                                    </p> 
                                    <p>
                                        <span>Billing Mail : </span><?= $model->billing_mail ?? 'N/A' ?>
                                    </p> 
                                    <p>
                                        <span>GST Number : </span><?= $model->gstDetail->gst_number ?? 'N/A' ?>
                                    </p>

                                    <p>
                                        <span>State Name : </span><?= $model->gstDetail->stateRelation->state_name ?? 'N/A' ?>
                                    </p>
                                    <p>
                                        <span>GST Image : </span>
                                        <?php if (!empty($model->gstDetail->gst_upload_path)){?>
                                            <button value="<?= Url::to(['file-view', 'filepath' => $model->gstDetail->gst_upload_path]) ?>" class="file-view " style ="border: 0; background-color: transparent;">
                                                <img src="<?= Yii::getAlias('@web') ?>/img/pdf-file-logo.png" alt="PDF Icon" style = "width : 40px ; height : 40px;">
                                            </button>
                                        <?php } else{ ?>
                                            <span class="text-muted" style="color: #6c757d !important;">No file uploaded</span>
                                        <?php } ?>
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

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($followerlist as $follower) {
                                                if ($user = $follower->user) {
                                            ?>
                                                    <tr>
                                                        <td><img src="<?= $follower->user->avatar != '' ? $follower->user->avatar : '/img/dpmain.png' ?>" class="rounded profile-picture" style="width:28px;"> <?= $user->name ?></td>

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
    </div> -->
</div>

<!-- <style>
    .text-box p span {
        color: brown !important;
    }
</style> -->
<!-- 
<div class="modal fade _standard-text" id="logo-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Logo</h1>
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='logoContent'></div>
            </div>
        </div>
    </div>
</div> -->
<!-- 
<div class="modal fade" id="modalfileview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Document Preview
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div> -->

<?php
$script = <<< JS

function organizefunction() {
    $('.change-logo-popup').on('click', function () {
        $('#logo-modal').modal('show')
		.find('#logoContent')
		.load($(this).attr('value'));
	});
}
organizefunction();

    \$('.file-view').on('click', function () {
            \$('#modalfileview').modal('show')
    \t\t.find('#modalContent')
    \t\t.load(\$(this).attr('value'));
    \t});

JS;
$this->registerJs($script);
?>