<div class="row pt-4">
    <div class="col-12 inner_accordion">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <?php if ($share_safari->sharesafaridays) {
                $share_safaridays = $share_safari->sharesafaridays;
                foreach ($share_safaridays as $share_safariday) { ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading<?= $share_safariday->day ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $share_safariday->day ?>" aria-expanded="false" aria-controls="flush-collapse<?= $share_safariday->day ?>">
                                DAY <?= $share_safariday->day ?> - <?= $share_safariday->day_title ?>
                            </button>
                        </h2>
                        <div id="flush-collapse<?= $share_safariday->day ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $share_safariday->day ?>" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="wrap_days">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="days_title">
                                                <h4 class="fs-5">Nights jim corbett tiger</h4>
                                            </div>
                                            <div class="text_wrapperite">
                                                <p><?= $share_safariday->day_description ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 mb-3">
                                            <div class="titles_locations">
                                                <h6 class="fs-5">Start Location</h6>
                                                <p><?= $share_safariday->start_location ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <div class="titles_locations">
                                                <h6 class="fs-5">End Location</h6>
                                                <p><?= $share_safariday->end_location ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mb-3">
                                            <div class="titles_locations">
                                                <h6 class="fs-5">Hotel Stay Home</h6>
                                                <p><?= $share_safariday->hotel_name ?></p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="titles_locations">
                                                <h6 class="fs-5">Meal</h6>
                                                <div class="mealchecks d-flex gap-4 align-items-center">
                                                    <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                                        <input type="checkbox" id="check" <?= ($share_safariday->meal_breakfast == 1) ? 'checked' : '' ?> onclick="return false;">
                                                        <label for="check">Breackfast</label>
                                                    </div>
                                                    <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                                        <input type="checkbox" id="check2" <?= ($share_safariday->meal_lunch == 1) ? 'checked' : '' ?> onclick="return false;">
                                                        <label for="check2">Lunch</label>
                                                    </div>
                                                    <div class="inputsCheck mb-2 d-flex  align-items-center gap-2 ">
                                                        <input type="checkbox" id="check3" <?= ($share_safariday->meal_dinner == 1) ? 'checked' : '' ?> onclick="return false;">
                                                        <label for="check3">Dinner</label>
                                                    </div>
                                                    <div class="inputsCheck mb-2 d-flex align-items-center gap-2 ">
                                                        <input type="checkbox" id="check4" <?= ($share_safariday->meal_breakfast == 1 && $share_safariday->meal_lunch == 1 && $share_safariday->meal_dinner == 1) ? 'checked' : '' ?> onclick="return false;">
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
                                                <img src="<?= isset($share_safariday->day_image) ? $share_safariday->imagepath : $this->params['baseurl'] . '/img/FESHwr.jpg' ?>" alt="" class="w-100">
                                            </div>
                                        </div>
                                        <?php

                                        $latitude = $share_safariday->latitude;
                                        $longitude = $share_safariday->longitude;

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