<?php

use common\models\GeneralModel;
use common\models\park\SafariParkMonth;


$locked_months = \yii\helpers\ArrayHelper::map(SafariParkMonth::find()->where(['safari_park_id' => $model->id, 'status' => SafariParkMonth::STATUS_ACTIVE])->orderBy(['month_id' => SORT_ASC])->all(), 'month_id', 'mastermonth.month_name');


?>


<h2 class="accordion-header d-lg-none" id="headingOne">
    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Overview</button>
</h2>
<div id="collapseOne" class="accordion-collapse collapse show  d-lg-block" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
    <div class="accordion-body p-3">
        <div class="row">
            <div class="col-lg-4 col-sm-4 col-md-4 col-xl-3">
                <div class="slider_safariimg owl-carousel owl-theme position-relative">
                    <img src="<?= isset($model->logo) ? $model->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 mb-xl-0 mb-3">
                </div>
            </div>
            <div class="col-lg-8 col-sm-8 col-md-8 col-xl-9 position-relative">
                <div class="seelctes_text pb-4 ">
                    <p><?= $model->long_description ?></p>
                </div>
                <div class="row pt-3 desktop_postion border_top2">
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/hotel_forest_location.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Location">

                            </div>
                            <div class="text-form">
                                <p class="mb-0"><?= isset($model->state) ? $model->state->state_name . ', ' : '' ?> <?= isset($model->location) ? $model->location->title : '' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Vechile">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php if ($model->vehicles) {
                                        $vehicles_arr = [];
                                        foreach ($model->vehicles as $vehicle) {
                                            $vehicles_arr[] =  isset($vehicle->mastervehicle) ? $vehicle->mastervehicle->vehicle_name : '';
                                        }
                                        $vehicles_arr = array_filter($vehicles_arr, 'strlen');
                                        echo  implode(", ", $vehicles_arr);
                                    } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/railway.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Railway Station">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?= $model->railwaystationlist ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safari Seasion">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">

                                    <?php if ($model->sessions) {
                                        $sessions_arr = [];
                                        foreach ($model->sessions as $session) {
                                            $sessions_arr[] =  isset($session->metasession) ? $session->metasession->title : '';
                                        }
                                        $sessions_arr = array_filter($sessions_arr, 'strlen');
                                        echo  implode(", ", $sessions_arr);
                                    } ?>

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/airport.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Airport">
                            </div>
                            <div class="text-form">
                                <p class="mb-0"><?= $model->airportlist ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/pawprint_3175935.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Animals">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php if ($model->animal_text) {
                                        echo $model->animal_text ?>
                                    <?php
                                    } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/rupee_3104891.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cost">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php if (!empty($model->avg_safari_price_min) && !empty($model->avg_safari_price_max)) { ?>
                                        <?= isset($model->avg_safari_price_min) ? GeneralModel::numberformat($model->avg_safari_price_min) . ' - ' : '' ?><?= GeneralModel::numberformat($model->avg_safari_price_max) ?> Average Safari Price <?= isset($model->safri_cost_note) && $model->safri_cost_note <> '' ? '(' . $model->safri_cost_note . ')' : '' ?>

                                    <?php } ?> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/park_lock.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Month when park is closed">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php
                                    if ($locked_months) {
                                        echo implode(", ", array_values($locked_months));
                                    }
                                    ?>
                                    <?= isset($model->month_note) && $model->month_note <> '' ? '(' . $model->month_note . ')' : '' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-lg-none mobile">
                        <div class="btn_wrap pt-md-0 ">
                            <?php

                            if ($model->official_website) { ?>
                                <a href="<?= $model->official_website ?>" target="_blank" class="intested_btn">OFFICIAL WEBSITE </i></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile responsive icons -->
             <div class="col-12 ">
                <div class="row pt-3 desktop_hideDiv border_top2">
                    <div class="col-md-6 col-sm-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/hotel_forest_location.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Location">

                            </div>
                            <div class="text-form">
                                <p class="mb-0"><?= isset($model->state) ? $model->state->state_name . ', ' : '' ?> <?= isset($model->location) ? $model->location->title : '' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Vechile">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php if ($model->vehicles) {
                                        $vehicles_arr = [];
                                        foreach ($model->vehicles as $vehicle) {
                                            $vehicles_arr[] =  isset($vehicle->mastervehicle) ? $vehicle->mastervehicle->vehicle_name : '';
                                        }
                                        $vehicles_arr = array_filter($vehicles_arr, 'strlen');
                                        echo  implode(", ", $vehicles_arr);
                                    } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-3">
                        <div class="safridetails_form d-flex gap-3">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/railway.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Railway Station">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?= $model->railwaystationlist ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Safari Seasion">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">

                                    <?php if ($model->sessions) {
                                        $sessions_arr = [];
                                        foreach ($model->sessions as $session) {
                                            $sessions_arr[] =  isset($session->metasession) ? $session->metasession->title : '';
                                        }
                                        $sessions_arr = array_filter($sessions_arr, 'strlen');
                                        echo  implode(", ", $sessions_arr);
                                    } ?>

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/airport.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Airport">
                            </div>
                            <div class="text-form">
                                <p class="mb-0"><?= $model->airportlist ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/pawprint_3175935.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Animals">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php if ($model->animal_text) {
                                        echo $model->animal_text ?>
                                    <?php
                                    } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/rupee_3104891.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cost">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php if (!empty($model->avg_safari_price_min) && !empty($model->avg_safari_price_max)) { ?>
                                        <?= isset($model->avg_safari_price_min) ? GeneralModel::numberformat($model->avg_safari_price_min) . ' - ' : '' ?><?= GeneralModel::numberformat($model->avg_safari_price_max) ?> Average Safari Price <?= isset($model->safri_cost_note) && $model->safri_cost_note <> '' ? '(' . $model->safri_cost_note . ')' : '' ?>

                                    <?php } ?> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 ">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/park_lock.png" alt="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Month when park is closed">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php
                                    if ($locked_months) {
                                        echo implode(", ", array_values($locked_months));
                                    }
                                    ?>
                                    <?= isset($model->month_note) && $model->month_note <> '' ? '(' . $model->month_note . ')' : '' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-lg-none mobile">
                        <div class="btn_wrap pt-md-0 ">
                            <?php

                            if ($model->official_website) { ?>
                                <a href="<?= $model->official_website ?>" target="_blank" class="intested_btn">OFFICIAL WEBSITE </i></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
             <!-- mobile responsive icons end -->
        </div>
        <div class="row pt-2">
            <div class="col-lg-12 col-xl-6 mb-3 mb-xl-0">
                <div class="row gx-2 <?= in_array(GeneralModel::removeLeadingChar(date('m')), array_keys($locked_months)) ? 'inactive_core_zone' : '' ?>">
                    <div class="col-sm-3 mb-sm-0 mb-3 ">
                        <div class="coreZone h-100">
                            <h3>CORE ZONE</h3>
                        </div>
                    </div>
                    <div class="col-sm-9 mb-sm-0 mb-3">
                        <div class="tabledesigncore">
                            <table class="table w-100 mb-0">
                                <thead>
                                    <tr>
                                        <th>Zone Name</th>
                                        <th>Entry Gate</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php if ($model->corezones) {
                                        foreach ($model->corezones as $corezone) { ?>
                                            <tr>
                                                <td><?= $corezone->zone_name ?></td>
                                                <td><?= $corezone->entry_gate_name ?></td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-xl-6">
                <div class="row gx-2">
                    <div class="col-sm-3 mb-sm-0 mb-3">
                        <div class="bufferzone h-100">
                            <h3>BUFFER ZONE</h3>
                        </div>
                    </div>
                    <div class="col-sm-9 mb-sm-0 mb-3">
                        <div class="tabledesignbuffer">
                            <table class="table w-100 mb-0">
                                <thead>
                                    <tr>
                                        <th>Zone Name</th>
                                        <th>Entry Gate</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php if ($model->bufferzones) {
                                        foreach ($model->bufferzones as $bufferzone) { ?>
                                            <tr>
                                                <td><?= $bufferzone->zone_name ?></td>
                                                <td><?= $bufferzone->entry_gate_name ?></td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>