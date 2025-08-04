<?php

use common\models\GeneralModel;
use yii\grid\GridView;

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
                                    <span>Registration Number:</span>
                                    <p class="mb-0"><?= isset($model->registration_number) ? $model->registration_number : '' ?></p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 cardText">
                                    <span>PAN Number:</span>
                                    <p class="mb-0"><?= isset($model->pan_number) ? $model->pan_number : '' ?></p>
                                </div>
                                <img src="<?= $this->params['baseurl'] ?>/images/prof.png"
                                    class="card-img-top object-fit-cover w-100" alt="">
                            </div>
                        </div>
                        <div class="col-xl-3 pb-4">

                            <div class="card cardMainImage h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3 cardText">
                                    <span>PAN Number:</span>
                                    <p class="mb-0"><?= isset($model->registration_number) ? $model->registration_number : '' ?></p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 cardText">
                                    <span>PAN Number:</span>
                                    <p class="mb-0"><?= isset($model->pan_number) ? $model->pan_number : '' ?></p>
                                </div>
                                <img src="<?= $this->params['baseurl'] ?>/images/prof.png"
                                    class="card-img-top object-fit-cover w-100" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>