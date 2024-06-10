<?php
if ($operator_parks) {
    foreach ($operator_parks as $operator_park) {
        $park_detail = $operator_park->park;
?>
        <div class="searchSafari_parks mb-4">
            <div class="row">
                <div class="col-xl-3">
                    <div class="parksImg h-100">
                        <img src="<?= isset($park_detail->galleryimag) ? $park_detail->galleryimag->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">
                    </div>
                </div>
                <div class="col-xl-9 ">
                    <div class="parks_body">
                        <div class="safrititles pt-md-0 pt-3">
                            <h6 class=""><?= $park_detail->title ?></h6>
                        </div>
                        <div class="seelctes_text pt-2 pb-3 ">
                            <p><?= $park_detail->long_description ?></p>
                        </div>
                        <div class="row ">
                            <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                <div class="safridetails_form d-flex gap-3 align-items-center">
                                    <div class="iconImg">
                                        <img src="<?= $this->params['baseurl'] ?>/img/hotel_forest_location.png" alt="">
                                    </div>
                                    <div class="text-form">
                                        <p class="mb-0"><?= isset($park_detail->state) ? $park_detail->state->state_name . ',' : '' ?> <?= isset($park_detail->location) ? $park_detail->location->title : '' ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                <div class="safridetails_form d-flex gap-3 align-items-center">
                                    <div class="iconImg">
                                        <img src="<?= $this->params['baseurl'] ?>/img/gypsycanter.png" alt="">
                                    </div>
                                    <div class="text-form">
                                        <p class="mb-0">
                                            <?php if ($park_detail->vehicles) {

                                                foreach ($park_detail->vehicles as $vehicle) {
                                                    echo isset($vehicle->mastervehicle) ? $vehicle->mastervehicle->vehicle_name . ' ,' : '' ?>
                                            <?php }
                                            } ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                <div class="safridetails_form d-flex gap-3 align-items-center">
                                    <div class="iconImg">
                                        <img src="<?= $this->params['baseurl'] ?>/img/railway.png" alt="">
                                    </div>
                                    <div class="text-form">
                                        <p class="mb-0"><?= isset($park_detail->railwaystation) ? $park_detail->railwaystation->title . ' , ' : '' ?><?= isset($park_detail->railwaystationtwo) ? $park_detail->railwaystationtwo->title : '' ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                <div class="safridetails_form d-flex gap-3 align-items-center">
                                    <div class="iconImg">
                                        <img src="<?= $this->params['baseurl'] ?>/img/night-mode_9554519.png" alt="">
                                    </div>
                                    <div class="text-form">
                                        <p class="mb-0">
                                            <?php if ($park_detail->sessions) {

                                                foreach ($park_detail->sessions as $session) {
                                                    echo isset($session->metasession) ? $session->metasession->title . ',' : '' ?>
                                            <?php }
                                            } ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                <div class="safridetails_form d-flex gap-3 align-items-center">
                                    <div class="iconImg">
                                        <img src="<?= $this->params['baseurl'] ?>/img/airport.png" alt="">
                                    </div>
                                    <div class="text-form">
                                        <p class="mb-0"><?= isset($park_detail->airport) ? $park_detail->airport->name : '' ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4 col-lg-6 mb-3">
                                <div class="safridetails_form d-flex gap-3 align-items-center">
                                    <div class="iconImg">
                                        <img src="<?= $this->params['baseurl'] ?>/img/pawprint_3175935.png" alt="">
                                    </div>
                                    <div class="text-form">
                                        <p class="mb-0">
                                            <?php if ($park_detail->animals) {

                                                foreach ($park_detail->animals as $animal) {
                                                    echo $animal->animal_name . ',' ?>
                                            <?php }
                                            } ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
<?php }
} ?>