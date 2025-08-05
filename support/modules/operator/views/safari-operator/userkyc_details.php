<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Safari Tour Operator : ' . $model->business_name;
$this->params['breadcrumbs_home_url'] = '/operator/safari-operator';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;


?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@support/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'user_kyc']) ?>

    <div class="assign-tabs operatorTab">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="userKYC">
                    <div class="row">
                        <div class="col-xl-12">
                            <table class="table w-100 border-0 border_o d-inline-block pt-3 mb-0">
                                <tbody class="tbody-leads sighting-leads py-5 w-100">
                                    <tr>
                                        <td style="width: 10%;">owner / Partner / Director Name:
                                        </td>
                                        <td style="width: 50%;">
                                            <p><?= isset($model->owner_name) ? $model->owner_name : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Phone Number:</td>
                                        <td>
                                            <p><?= isset($model->kyc_phone) ? $model->kyc_phone : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>WhatsApp Number:</td>
                                        <td>
                                            <p><?= isset($model->kyc_whatsapp) ? $model->kyc_whatsapp : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Email ID:</td>
                                        <td>
                                            <p><?= isset($model->kyc_email) ? $model->kyc_email : '' ?></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div class="col-xl-3 pb-4">
                            <div class="ver-im sec-ver-im card cardMainImage">
                                <div class="ver-im-tx-title d-flex align-items-center gap-5 mb-2">
                                    <span>PAN Number:</span>
                                    <p class="mb-0"><?= isset($model->kyc_pan) ? $model->kyc_pan : '' ?></p>
                                </div>
                                <!-- <a href="" class="">
                                    <img src="<?= $this->params['baseurl'] ?>/images/prof.png" alt=""
                                        class="w-100 object-fit-cover">

                                </a> -->

                                <?php if (!empty($model->kyc_pan_upload)) {
                                    $thumbPath = preg_replace('/\.pdf$/i', '.jpg', $model->kyc_pan_upload); // assumes thumbnail has same path + .jpg
                                    // $thumbPath = $this->params['baseurl'] . '/images/pancard.png';
                                ?>
                                    <button type="button"
                                        value="<?= Url::to(['file-view', 'filepath' => $model->kyc_pan_upload]) ?>"
                                        class="file-view"
                                        style="border: 0; background-color: transparent; padding: 0;">
                                        <img src="<?= isset($thumbPath) ? $thumbPath : $this->params['baseurl'] . '/images/pancard.png' ?>"
                                            alt="PDF Preview"
                                            class="w-100 h-100 object-fit-cover">
                                    </button>
                                <?php } else { ?>
                                    <span class="text-muted">No file uploaded</span>
                                <?php } ?>

                            </div>
                        </div>
                        <div class="col-xl-6 pb-4">
                            <div class="ver-im sec-ver-im card cardMainImage">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="ver-im-tx-title d-flex align-items-center gap-5 mb-2">
                                            <span>Aadhar Card Number:</span>
                                            <p class="mb-0"><?= isset($model->aadhar_number) ? $model->aadhar_number : '' ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="ver-im sec-ver-im p-0">

                                            <!-- <a href="" class="">
                                                <img src="<?= $this->params['baseurl'] ?>/images/prof.png" alt=""
                                                    class="w-100 object-fit-cover">

                                            </a> -->

                                            <?php if (!empty($model->aadhar_front_upload)) {
                                                $thumbPath = preg_replace('/\.pdf$/i', '.jpg', $model->aadhar_front_upload); // assumes thumbnail has same path + .jpg
                                                // $thumbPath = $this->params['baseurl'] . '/images/prof.png';
                                            ?>
                                                <button type="button"
                                                    value="<?= Url::to(['file-view', 'filepath' => $model->aadhar_front_upload]) ?>"
                                                    class="file-view"
                                                    style="border: 0; background-color: transparent; padding: 0;">
                                                    <img src="<?= isset($thumbPath) ? $thumbPath : $this->params['baseurl'] . '/images/prof.png' ?>"
                                                        alt="PDF Preview"
                                                        class="w-100 h-100 object-fit-cover">
                                                </button>
                                            <?php } else { ?>
                                                <span class="text-muted">No file uploaded</span>
                                            <?php } ?>

                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="ver-im sec-ver-im p-0">

                                            <!-- <a href="" class="">
                                                <img src="<?= $this->params['baseurl'] ?>/images/prof.png" alt=""
                                                    class="w-100 object-fit-cover">

                                            </a> -->

                                            <?php if (!empty($model->aadhar_back_upload)) {
                                                $thumbPath = preg_replace('/\.pdf$/i', '.jpg', $model->aadhar_back_upload); // assumes thumbnail has same path + .jpg
                                                // $thumbPath = $this->params['baseurl'] . '/images/prof.png';
                                            ?>
                                                <button type="button"
                                                    value="<?= Url::to(['file-view', 'filepath' => $model->aadhar_back_upload]) ?>"
                                                    class="file-view"
                                                    style="border: 0; background-color: transparent; padding: 0;">
                                                    <img src="<?= isset($thumbPath) ? $thumbPath : $this->params['baseurl'] . '/images/prof.png' ?>"
                                                        alt="PDF Preview"
                                                        class="w-100 h-100 object-fit-cover">
                                                </button>
                                            <?php } else { ?>
                                                <span class="text-muted">No file uploaded</span>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
</div>


<?php
$script = <<< JS

    \$('.file-view').on('click', function () {
            \$('#modalfileview').modal('show')
    \t\t.find('#modalContent')
    \t\t.load(\$(this).attr('value'));
    \t});

JS;
$this->registerJs($script);
?>