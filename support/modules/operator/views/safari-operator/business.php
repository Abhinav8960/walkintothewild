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
    <?= $this->render('@support/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'business']) ?>

    <div class="assign-tabs operatorTab">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="businessMainParent">
                    <table class="table w-100 border-0 border_o d-inline-block py-3 bg-white">
                        <tbody class="tbody-leads sighting-leads py-5 w-100">
                            <tr>
                                <td style="width: 17%;">Operated Park:</td>
                                <td style="width: 83%;">
                                    <p>
                                        <?php
                                        $html_park = '';
                                        $park = GeneralModel::operatorpark($model->id);
                                        foreach ($park as $key => $role) {
                                            if (isset(GeneralModel::safariparkoption()[$key])) {
                                                $html_park .= GeneralModel::safariparkoption()[$key] . ', ';
                                            }
                                        }

                                        echo !empty($html_park) ? substr($html_park, 0, -2) : 'N/A';
                                        ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>About Business:</td>
                                <td>
                                    <p><?= isset($model->about_business) ? $model->about_business : '' ?></p>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-xl-3 pb-4">
                            <div class="card cardMainImage h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3 cardText">
                                    <span>State :</span>
                                    <p class="mb-0"><?= isset($model->gstDetail->stateRelation->state_name) ? $model->gstDetail->stateRelation->state_name : '' ?></p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 cardText">
                                    <span>GST Number:</span>
                                    <p class="mb-0"><?= isset($model->gstDetail->gst_number) ? $model->gstDetail->gst_number : '' ?></p>
                                </div>
                                <!-- <img src="<?= $this->params['baseurl'] ?>/images/prof.png"
                                    class="card-img-top object-fit-cover w-100" alt=""> -->

                                <?php if (!empty($model->gstDetail->gst_upload_path)) {
                                    $thumbPath = preg_replace('/\.pdf$/i', '.jpg', $model->gstDetail->gst_upload_path); // assumes thumbnail has same path + .jpg
                                    // $thumbPath = $this->params['baseurl'] . '/images/prof.png';
                                ?>
                                    <button type="button"
                                        value="<?= Url::to(['file-view', 'filepath' => $model->gstDetail->gst_upload_path]) ?>"
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