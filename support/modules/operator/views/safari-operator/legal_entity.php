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
    <?= $this->render('@support/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'legal_entity']) ?>

    <div class="assign-tabs operatorTab">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-xl-9">
                        <div class="overviewDataParent">
                            <table class="table w-100 border-0 border_o d-inline-block py-3 bg-white">
                                <tbody class="tbody-leads sighting-leads py-5 w-100">
                                    <tr>
                                        <td style="width: 10%;">Legal entity Type:</td>
                                        <td style="width: 50%;">
                                            <p>
                                                <?php
                                                if ($model->legal_entity_type) {
                                                    echo $model->legal_entity_type ? GeneralModel::operatortype($model->legal_entity_type) : '' ;
                                                } ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Legal entity Name</td>
                                        <td>
                                            <p><?= isset($model->operator_name) ? $model->operator_name : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Legal entity Phone Number:</td>
                                        <td>
                                            <p><?= isset($model->operator_phone_no) ? $model->operator_phone_no : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Legal entity Email:</td>
                                        <td>
                                            <p><?= isset($model->operator_email) ? $model->operator_email : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Legal entity WhatsApp Number </td>
                                        <td>
                                            <p><?= isset($model->legal_entity_whatsapp) ? $model->legal_entity_whatsapp : '' ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PAN Number:</td>
                                        <td>
                                            <p><?= isset($model->pan_number) ? $model->pan_number : '' ?></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="identification-photo">
                            <p class="mb-1">Pan Photo: </p>
                            <a href="/">
                                <img src="<?= $this->params['baseurl'] ?>/images/pancard.png" alt=""
                                    class="w-100 h-100 object-fit-cover">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>