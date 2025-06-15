<?php

use business\assets\AppAsset;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
AppAsset::register($this);

?>
<div class="wrapper_inner">
    <div class="row">
        <div class="col-lg-5">
            <div class="details-packages mb-3">
                <table class="table w-100 border-0 border_o">
                    <thead class="thead-details">
                        <tr>
                            <th style="width: 40%;">
                                <p>Source</p>
                                <p><?= $model->sourceLabel ?></p>
                            </th>
                            <th>
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
                        <tr>
                            <td>Park Name</td>
                            <td>
                                <p>Pench Tiger Reserve</p>
                            </td>
                        </tr>
                        <tr>
                            <td>Safaris</td>
                            <td>
                                <p><?= !empty($model->safaris) ? $model->safaris : ''; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>Travelers</td>
                            <td>
                                <p><?= !empty($model->travelers) ? $model->travelers : '' ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>Accomodation</td>
                            <td>
                                <p><?= !empty($model->staycatgory) ? $model->staycatgory->title : '' ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td>User Notes</td>
                            <td>
                                <p><?= !empty($model->user_notes) ? $model->user_notes : '' ?></p>
                            </td>
                        </tr>
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
                            <img src="<?= $this->params['baseurl'] ?>images/safraiimg.jpg" alt="" class="w-100">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="text-wrpas">
                            <h6>Overview</h6>
                            <p>Corbett is the only major national park in India offering options to stay miles inside the deep dense forest in govt run guest houses aka the Forest Rest Houses. Packages for Dhikala Forest Rest Houses comes all inclusive with gypsy & guide as your personal vehicle is not allowed inside the national park. Often known as the Mecca of Indian wildlife, Dhikala FRH consists of the following...</p>
                        </div>
                    </div>
                </div>
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
                                <p class="mb-0">2 Nights , 3 Days</p>
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
                                <p class="mb-0">Pick & Drop</p>
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
                                <p class="mb-0">4 Shared Gypsy Safari</p>
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
                                <p class="mb-0">All Meals</p>
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
                                    src="<?= $this->params['baseurl'] ?>/images/camera.png">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">Photography Special</p>
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
                                    src="<?= $this->params['baseurl'] ?>/images/Icon fa-solid-hotel.png">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">Premium</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end pb-2 pt-3">
                        <h5 class="cost_price">Rs. 90,000/Per Person</h5>
                    </div>
                </div>
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