<?php

use common\models\GeneralModel;

$this->title = 'Safari Tour Operator : ' . $model->business_name;
$this->params['breadcrumbs_home_url'] = '/operator/safari-operator';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = 'Business Details';
$this->params['title'] = $this->title;

$budget = [];
if ($model->is_offer_premium_budget == 1) {
    $budget[] = "Premium";
}
if ($model->is_offer_standard_budget == 1) {
    $budget[] = "Standard";
}
if ($model->is_offer_economical_budget == 1) {
    $budget[] = "Economical";
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
    <?= $this->render('@backend/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'business-details']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="<?= $model->Imagepath ?>">
                            </div>
                            <div class="col-md-3">
                                <div class="text-box">
                                    <p>
                                        <span>Operated Park:</span>
                                        <?php
                                            $park_names = [];
                                            foreach ($model->partner_model->parkList as $parkList) {
                                            $park_names[] = $parkList->park->title;
                                            }
                                            echo implode(', ', $park_names);
                                        ?>
                                    </p>
                                    <p>
                                        <span>About Business : </span><?= $model->about_business ?>
                                       
                                    </p>
                                    <p>
                                        <span>Billing Mail : </span><?= $model->billing_mail ?>
                                    </p>
                                    <p>
                                        <span>Billing Phone : </span><?= $model->billing_phone ?>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-box p span {
        color: brown !important;
    }
</style>