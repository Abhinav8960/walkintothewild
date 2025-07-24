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
    <?= $this->render('@support/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'registration_proof']) ?>

        <div class="tab-content" id="myTabContent">

    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="row">
            <div class="col-xl-3 pb-4">
                <div class="card cardMainImage h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2 cardText">
                        <span>Registration Number:</span>
                        <p class="mb-0">HDH6545</p>
                    </div>
                    <img src="<?= $this->params['baseurl'] ?>/images/prof.png"
                        class="card-img-top object-fit-cover w-100" alt="">


                </div>
            </div>
            <div class="col-xl-3 pb-4">

                <div class="card cardMainImage h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2 cardText">
                        <span>PAN Number:</span>
                        <p class="mb-0">HDH6545</p>
                    </div>
                    <img src="<?= $this->params['baseurl'] ?>/images/prof.png"
                        class="card-img-top object-fit-cover w-100" alt="">


                </div>
            </div>
        </div>
    </div>
</div>
</div>