<?php

use business\assets\AppAsset;
use common\models\GeneralModel;
use Google\Service\Docs\Background;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
AppAsset::register($this);

$this->title = 'Leads';
?>
<div class="wrapper_inner">
    <div class="row">
        <div class="col-lg-5">
            <div class="details-packages mb-3">
                <table class="table w-100 border-0 border_o">
                    <thead class="thead-details">
                        <tr>
                            <th style="<?= $model->DisplayColor ?>">
                                <p>Source</p>
                                <p><?= $model->sourceLabel ?></p>
                            </th>
                            <th style="<?= $model->DisplayColor ?>">
                                <p><?= $model->sourceLabel . ' ' . 'Name' ?></p>
                                <p><?= $model->displayLabel ?></p>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="tbody-leads py-3">
                        <tr>
                            <td>Lead Date</td>
                            <td>
                                <p><?= date('d M, Y h:i A', $model->created_at) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>Travel Date</td>
                            <td>
                                <p> <?php
                                    $str =  date('d M, Y', strtotime($model->from_date));
                                    if (!empty($model->to_date)) {
                                        $str .=  '- ' . date('d M, Y', strtotime($model->to_date));
                                    }
                                    echo $str;
                                    ?></p>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td>Park Name</td>
                            <td>
                                <p>Pench Tiger Reserve</p>
                            </td>
                        </tr> -->
                        <?php if ($model->safaris) { ?>
                            <tr>
                                <td>Safaris</td>
                                <td>
                                    <p><?= !empty($model->safaris) ? $model->safaris : ''; ?></p>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($model->travelers) { ?>

                            <tr>
                                <td>Travelers</td>
                                <td>
                                    <p><?= !empty($model->travelers) ? $model->travelers : '' ?></p>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($model->staycatgory) { ?>

                            <tr>
                                <td>Accomodation</td>
                                <td>
                                    <p><?= !empty($model->staycatgory) ? $model->staycatgory->title : '' ?></p>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($model->user_notes) { ?>

                            <tr>
                                <td>User Notes</td>
                                <td>
                                    <p><?= !empty($model->user_notes) ? $model->user_notes : '' ?></p>
                                </td>
                            </tr>
                        <?php } ?>

                        <!-- <tr>
                            <td>Days</td>
                            <td>
                                <p>5</p>
                            </td>
                        </tr> -->
                        <!-- <tr>
                            <td>Payment Info</td>
                            <td>
                                <span class="badge badge-paid">PAID</span>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
            <div class="details-packages p-3">
                <div class="safari_dtails">
                    <h5 class="titles_s"><?= $model->displayLabel ?></h5>
                </div>
                <div class="row pt-3">
                    <div class="col-lg-4">
                        <div class="images-safari">
                            <img src="<?= $model->displayImage ?>" alt="" class="w-100">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="text-wrpas">
                            <h6>Overview</h6>
                            <p><?= $model->displayOverview ?></p>
                        </div>
                    </div>
                </div>
                <?php if ($model->sourceLabel == 'Package') { ?>
                    <div class="row pt-3">
                        <div class="col-12 mb-2 col-sm-6">
                            <div class="safridetails_form d-flex gap-2 ">
                                <div class="iconImage">
                                    <img
                                        alt="Night Mode"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-title="Trip Duration"
                                        src="<?= $this->params['baseurl'] ?>/images/night-mode_9554519.png">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $model->package ? $model->package->no_of_night : '' ?> Nights , <?= $model->package ? $model->package->no_of_day : '' ?> Days</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2 col-sm-6">
                            <div class="safridetails_form d-flex gap-2 ">
                                <div class="iconImage">
                                    <img
                                        alt="Night Mode"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-title="Trip Duration"
                                        src="<?= $this->params['baseurl'] ?>/images/Icon fa-solid-taxi.png">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $model->package ? $model->package->pickanddrop : '' ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2 col-sm-6">
                            <div class="safridetails_form d-flex gap-2 ">
                                <div class="iconImage">
                                    <img
                                        alt="Night Mode"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-title="Trip Duration"
                                        src="<?= $this->params['baseurl'] ?>/images/newicon.png">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $model->package ? $model->package->no_of_safari : '' ?> Shared Gypsy Safari</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2 col-sm-6">
                            <div class="safridetails_form d-flex gap-2 ">
                                <div class="iconImage">
                                    <img
                                        alt="Night Mode"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-title="Trip Duration"
                                        src="<?= $this->params['baseurl'] ?>/images/path.png">
                                </div>
                                <div class="text-form">
                                    <p class="mb-0"><?= $model->package ? $model->package->meals : '' ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2 col-sm-6">
                            <div class="safridetails_form d-flex gap-2 ">
                                <?php if ($package = $model->package) { ?>
                                    <div class="iconImage">
                                        <?php if ($package->package_agenda_id && $package->package_agenda_id == 1) { ?>
                                            <img src="<?= $this->params['baseurl'] ?>/images/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                        <?php } else if ($package->package_agenda_id && $package->package_agenda_id == 3) { ?>
                                            <img src="<?= $this->params['baseurl'] ?>/images/elephant.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                        <?php } else { ?>
                                            <img src="<?= $this->params['baseurl'] ?>/images/camera.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Theme">
                                        <?php } ?>
                                    </div>
                                    <div class="text-form">
                                        <p class="mb-0"> <?= isset(GeneralModel::agendaoption()[$package->package_agenda_id]) ? GeneralModel::agendaoption()[$package->package_agenda_id] : 'Not Included' ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-12 mb-2 col-sm-6">
                            <div class="safridetails_form d-flex gap-2 ">
                                <div class="iconImage">
                                    <img
                                        alt="Night Mode"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-title="Trip Duration"
                                        src="<?= $this->params['baseurl'] ?>/images/Icon fa-solid-hotel.png">
                                </div>
                                <div class="text-form">
                                    <?php if ($model->package) { ?>
                                        <p class="mb-0"><?= isset(GeneralModel::packagemetastaycategory()[$model->package->stay_category_id]) ? GeneralModel::packagemetastaycategory()[$model->package->stay_category_id] : 'Not Included' ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-end pb-2 pt-3">
                            <h5 class="cost_price">Rs. <?= $model->package ? GeneralModel::formatIndianCurrency($model->package->cost_per_person) : '' ?>/Per Person</h5>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="chats_wrapper">
                <?= $this->render('_partner_lead_chat', ['model' => $model, 'chat' => $chat]) ?>
                <div class="row">
                    <?= $this->render('_send_message', ['model' => $chat_message_model]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 
<div class="card">
    <div class="card-body" id="quotation-form-div" value="/leads/default/quotation?id=<?= $model->id ?>">

    </div>
</div> -->

<!-- <div class="col-lg-3 col-xl-3">
        <div class="card">

            <div class="card-body">
                <h4>Quatations</h4>
                <?php

                if (count($quotations) > 0) {
                ?>
                    <ol class="list-group list-group-flush border-1">
                        <?php
                        foreach ($quotations as $quotation) {
                        ?>
                            <li class="list-group-item border-1 <?= $quotation->is_approved_by_admin == $quotation::IS_APPROVED_BY_ADMIN_APPROVED ? 'text-success' : '' ?>  <?= $quotation->is_approved_by_admin == $quotation::IS_APPROVED_BY_ADMIN_REJECT ? 'text-danger' : '' ?>" <?= $quotation->is_approved_by_admin == $quotation::IS_APPROVED_BY_ADMIN_REJECT ? 'title=' . $quotation->rejection_reason : '' ?>>Net Price: <?= $quotation->net_payment_price ?>, Raise: <?= date('d M, Y h:i A', $quotation->created_at) ?></li>

                        <?php
                        }
                        ?>
                    </ol>

                <?php
                }
                ?>

                </ul>
            </div>

        </div>
    </div> -->

<?php
$script = <<< JS
    
		$('#quotation-form-div').load($('#quotation-form-div').attr('value'));

JS;
$this->registerJs($script);
?>