<h2 class="accordion-header d-lg-none" id="headingOne">
    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Overview</button>
</h2>
<div id="collapseOne" class="accordion-collapse collapse show  d-lg-block" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
    <div class="accordion-body py-4">
        <div class="row">
            <div class="col-lg-12 col-xl-3">
                <?php

                use common\models\GeneralModel;

                if ($model->gallery) { ?>
                    <div class="slider_safariimg owl-carousel owl-theme position-relative">
                        <?php foreach ($model->gallery as $gallery) { ?>
                            <img src="<?= isset($gallery->image) ? $gallery->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100">
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-12 col-xl-9 position-relative">
                <div class="safrititles pt-xl-0 pt-3 d-sm-flex justify-content-between align-items-center">
                    <h5 class=""><a href=""><?= $model->title ?></a></h5>
                    <div class="btn_wrap pt-md-0 pt-3">
                        <?php if ($model->official_website) { ?>
                            <a href="<?= $model->official_website ?>" target="_blank" class="intested_btn"><i class="fa-solid fa-user-group"></i> OFFICIAL WEBSITE</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="seelctes_text pt-3 pb-4 ">
                    <p><?= $model->long_description ?></p>
                </div>
                <div class="row pt-3 desktop_postion border_top2">
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 align-items-center">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/hotel_forest_location.png" alt="">
                            </div>
                            <div class="text-form">
                                <p class="mb-0"><?= isset($model->state) ? $model->state->state_name . ',' : '' ?> <?= isset($model->location) ? $model->location->title : '' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 align-items-center">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php if ($model->vehicles) {

                                        foreach ($model->vehicles as $vehicle) {
                                            echo isset($vehicle->mastervehicle) ? $vehicle->mastervehicle->vehicle_name . ' ,' : '' ?>
                                    <?php }
                                    } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 align-items-center">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/railway.png" alt="">
                            </div>
                            <div class="text-form">
                                <p class="mb-0"><?= isset($model->railwaystation) ? $model->railwaystation->title . ' , ' : '' ?><?= isset($model->railwaystationtwo) ? $model->railwaystationtwo->title : '' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 align-items-center">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php if ($model->sessions) {

                                        foreach ($model->sessions as $session) {
                                            echo isset($session->metasession) ? $session->metasession->title . ',' : '' ?>
                                    <?php }
                                    } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 align-items-center">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/airport.png" alt="">
                            </div>
                            <div class="text-form">
                                <p class="mb-0"><?= isset($model->airport) ? $model->airport->name : '' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 align-items-center">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/pawprint_3175935.png" alt="">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php if ($model->animals) {

                                        foreach ($model->animals as $animal) {
                                            echo $animal->animal_name . ',' ?>
                                    <?php }
                                    } ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 align-items-center">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/rupee_3104891.png" alt="">
                            </div>
                            <div class="text-form">
                                <p class="mb-0">
                                    <?php if (!empty($model->avg_safari_price_min) && !empty($model->avg_safari_price_max)) { ?>
                                        <?= isset($model->avg_safari_price_min) ? GeneralModel::numberformat($model->avg_safari_price_min) . ' - ' : '' ?><?= GeneralModel::numberformat($model->avg_safari_price_max) ?> Average Safari Price

                                    <?php } ?> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="safridetails_form d-flex gap-3 align-items-center">
                            <div class="iconImg">
                                <img src="<?= $this->params['baseurl'] ?>/img/park_lock.png" alt="">
                            </div>
                            <div class="text-form">
                                <p class="mb-0"><?= isset($first_month) ? $first_month->mastermonth->month_name . ' - ' : '' ?><?= isset($last_month) ? $last_month->mastermonth->month_name : '' ?> <?= isset($model->month_note) ? '(' . $model->month_note . ')' : '' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-lg-12 col-xl-6 mb-3">
                <div class="row gx-2">
                    <div class="col-sm-3 mb-sm-0 mb-3">
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