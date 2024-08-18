<div class="row pt-lg-4 pt-4">
    <div class="col-12 inner_accordion">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <?php if ($package->packagedays) {
                $packagedays = $package->packagedays;
                foreach ($packagedays as $packageday) { ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading<?= $packageday->day ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $packageday->day ?>" aria-expanded="false" aria-controls="flush-collapse<?= $packageday->day ?>">
                                DAY <?= $packageday->day ?> - <?= $packageday->day_title ?>
                            </button>
                        </h2>
                        <div id="flush-collapse<?= $packageday->day ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $packageday->day ?>" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="wrap_days">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="text_wrapperite">
                                                <p><?= $packageday->day_description ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 mb-3">
                                            <div class="titles_locations">
                                                <h6 class="fs-5">Start Location</h6>
                                                <p><?= $packageday->start_location ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <div class="titles_locations">
                                                <h6 class="fs-5">End Location</h6>
                                                <p><?= $packageday->end_location ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <div class="titles_locations">
                                                <h6 class="fs-5">Hotel Stay Home</h6>
                                                <p><?= $packageday->hotel_name ?></p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="titles_locations">
                                                <h6 class="fs-5">Meals</h6>
                                                <div class="mealchecks d-flex gap-sm-4 gap-2 align-items-center flex-wrap">
                                                    <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                                        <input type="checkbox" id="check" <?= ($packageday->meal_breakfast == 1) ? 'checked' : '' ?> onclick="return false;">
                                                        <label for="check">Breackfast</label>
                                                    </div>
                                                    <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                                        <input type="checkbox" id="check2" <?= ($packageday->meal_lunch == 1) ? 'checked' : '' ?> onclick="return false;">
                                                        <label for="check2">Lunch</label>
                                                    </div>
                                                    <div class="inputsCheck mb-2 d-flex  align-items-center gap-2 ">
                                                        <input type="checkbox" id="check3" <?= ($packageday->meal_dinner == 1) ? 'checked' : '' ?> onclick="return false;">
                                                        <label for="check3">Dinner</label>
                                                    </div>
                                                    <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                                        <input type="checkbox" id="check4" <?= ($packageday->meal_breakfast == 1 && $packageday->meal_lunch == 1 && $packageday->meal_dinner == 1) ? 'checked' : '' ?> onclick="return false;">
                                                        <label for="check4">All</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="titles_locations pt-4">
                                        <h6 class="fs-5">Images</h6>
                                    </div>

                                    <div class="row pt-2">
                                        <div class="col-lg-4 mb-2">
                                            <div class="hotelImages">
                                                <img src="<?= isset($packageday->day_image) ? $packageday->imagepath : $this->params['baseurl'] . '/img/default_witw.png' ?>" alt="" class="w-100">
                                            </div>
                                        </div>
                                        <?php

                                        $latitude = $packageday->latitude;
                                        $longitude = $packageday->longitude;

                                        $mapUrl = "https://www.google.com/maps?q={$latitude},{$longitude}&hl=es;z=14&output=embed";

                                        if (!empty($latitude) && !empty($longitude)) {
                                        ?>
                                            <div class="col-lg-4 mb-2">
                                                <div class="hotelImages">

                                                    <iframe width="400" height="200" frameborder="0" style="border:0" src="<?= $mapUrl ?>" allowfullscreen>
                                                    </iframe>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>
</div>