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
                                        <td style="width: 60%;">owner / Partner / Director Name:
                                        </td>
                                        <td style="width: 50%;">
                                            <p>oindrila.pharma</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Phone Number:</td>
                                        <td>
                                            <p>9090909090</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>WhatsApp Number:</td>
                                        <td>
                                            <p>9090909090</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Email ID:</td>
                                        <td>
                                            <p>business@gmail.com</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Email ID:</td>
                                        <td>
                                            <p>business@gmail.com</p>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>

                        <div class="col-xl-3 pb-4">
                            <div class="ver-im sec-ver-im card cardMainImage">
                                <div class="ver-im-tx-title d-flex align-items-center gap-5 mb-2">
                                    <span>PAN Number:</span>
                                    <p class="mb-0">HDH6545</p>
                                </div>
                                <a href="" class="">
                                    <img src="<?= $this->params['baseurl'] ?>/images/prof.png" alt=""
                                        class="w-100 object-fit-cover">

                                </a>
                            </div>
                        </div>
                        <div class="col-xl-6 pb-4">
                            <div class="ver-im sec-ver-im card cardMainImage">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="ver-im-tx-title d-flex align-items-center gap-5 mb-2">
                                            <span>Aadhar Card Number:</span>
                                            <p class="mb-0">3415685654</p>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="ver-im sec-ver-im p-0">

                                            <a href="" class="">
                                                <img src="<?= $this->params['baseurl'] ?>/images/prof.png" alt=""
                                                    class="w-100 object-fit-cover">

                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="ver-im sec-ver-im p-0">

                                            <a href="" class="">
                                                <img src="<?= $this->params['baseurl'] ?>/images/prof.png" alt=""
                                                    class="w-100 object-fit-cover">

                                            </a>
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