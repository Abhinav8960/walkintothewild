<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->business_name;
$this->params['breadcrumbs_home_url'] = '/operator/safari-operator';
$this->params['breadcrumbs'][] = ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;

$budget = [];
if ($model->is_offer_premium_budget == 1) {
    $budget[] = 'Premium';
}
if ($model->is_offer_standard_budget == 1) {
    $budget[] = 'Standard';
}
if ($model->is_offer_economical_budget == 1) {
    $budget[] = 'Economical';
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
    <div class="assign-tabs operatorTab">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-xl-9">
                        <div class="overviewDataParent">
                            <table class="table w-100 border-0 border_o d-inline-block py-3 bg-white">
                                <tbody class="tbody-leads sighting-leads py-5 w-100">
                                    <tr>
                                        <td style="width: 10%;">Business Name:</td>
                                        <td style="width: 50%;">
                                            <p><?= isset($model->business_name) ? $model->business_name : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td>
                                            <p><?= isset($model->address) ? $model->address : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Phone Number: </td>
                                        <td>
                                            <p><?= isset($model->phone_no) ? $model->phone_no : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Legal entity Email:</td>
                                        <td>
                                            <p><?= isset($model->email) ? $model->email : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Category:</td>
                                        <td>
                                            <p>
                                                <?php
                                                if ($model->category_id) {
                                                    echo isset(GeneralModel::operatorcategory()[$model->category_id]) ? GeneralModel::operatorcategory()[$model->category_id] : '';
                                                }
                                                ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PAN Number:</td>
                                        <td>
                                            <p><?= isset($model->pan_number) ? $model->pan_number : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Approved Status:</td>
                                        <td>
                                            <p>
                                                <?php
                                                if ($model->is_approved) {
                                                    echo isset(GeneralModel::yesnooption()[$model->is_approved]) ? GeneralModel::yesnooption()[$model->is_approved] : '';
                                                } else {
                                                    echo 'No';
                                                }
                                                ?>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <!-- <div class="identification-photo">
                            <p class="mb-1">Pan Photo: </p> -->
                        <!-- <a href="/"> -->
                        <!-- <img src="<?= $this->params['baseurl'] ?>/images/pancard.png" alt=""
                                    class="w-100 h-100 object-fit-cover"> -->
                        <!-- </a> -->
                        <!-- </div> -->

                        <div class="identification-photo">
                            <p class="mb-1">Pan Photo: </p>

                            <?php if (!empty($model->pan_upload)) {
                                $thumbPath = preg_replace('/\.pdf$/i', '.jpg', $model->pan_upload); // assumes thumbnail has same path + .jpg
                                // $thumbPath = $this->params['baseurl'] . '/images/pancard.png';
                            ?>
                                <button type="button"
                                    value="<?= Url::to(['file-view', 'filepath' => $model->pan_upload]) ?>"
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