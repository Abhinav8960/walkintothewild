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
    <?= $this->render('@support/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'bank_details']) ?>

    <div class="assign-tabs operatorTab">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-xl-9">
                        <div class="overviewDataParent">
                            <table class="table w-100 border-0 border_o d-inline-block py-3 bg-white">
                                <tbody class="tbody-leads sighting-leads py-5 w-100">
                                    <tr>
                                        <td style="width: 60%;">Bank Name:</td>
                                        <td style="width: 50%;">
                                            <p><?= isset($model->bank_name) ? $model->bank_name : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Account Holder Name:</td>
                                        <td>
                                            <p><?= isset($model->account_holder_name) ? $model->account_holder_name : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>IFSC Code: </td>
                                        <td>
                                            <p><?= isset($model->ifsc_number) ? $model->ifsc_number : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PAN Number:</td>
                                        <td>
                                            <p>DFY1533SF</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="identification-photo">
                            <p class="mb-1">Cancel Check Copy: </p>
                            <!-- <a href="/"> -->
                                <!-- <img src="<?= $this->params['baseurl'] ?>/images/pancard.png" alt=""
                                    class="w-100 h-100 object-fit-cover"> -->
                            <!-- </a> -->

                            <?php if (!empty($model->cancel_check_upload)) {
                                $thumbPath = preg_replace('/\.pdf$/i', '.jpg', $model->cancel_check_upload); // assumes thumbnail has same path + .jpg
                                // $thumbPath = $this->params['baseurl'] . '/images/prof.png';
                            ?>
                                <button type="button"
                                    value="<?= Url::to(['file-view', 'filepath' => $model->cancel_check_upload]) ?>"
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