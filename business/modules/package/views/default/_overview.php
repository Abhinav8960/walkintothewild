<div class="card mt-2">
    <div class="card-body">
        <div class="row pt-4">
            <div class="col-12">
                <div class="accordion" id="accordionExample">
                    <?php if ($package->packagedays) {
                        $packagedays = $package->packagedays;
                        foreach ($packagedays as $packageday) { ?>
                            <div class="accordion-item itinerary_item mt-2">
                                <h2 class="accordion-header" id="heading<?= $packageday->day ?>">
                                    <div class="accordion-button custom-header" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $packageday->day ?>" aria-expanded="true" aria-controls="collapse<?= $packageday->day ?>">
                                        DAY <?= $packageday->day ?> - <?= $packageday->day_title ?>
                                    </div>
                                </h2>
                                <div id="collapse<?= $packageday->day ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $packageday->day ?>" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
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
                                        </div>

                                        <div class="titles_locations pt-4">
                                            <h6 class="fs-5">Images</h6>
                                        </div>

                                        <div class="row pt-2">
                                            <div class="col-lg-4 mb-2">
                                                <div class="hotelImages">
                                                    <img src="<?= isset($packageday->day_image) ? $packageday->imagepath : $this->params['baseurl'] . '/img/FESHwr.jpg' ?>" alt="" class="w-100">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="titles_locations pt-4">
                                            <h6 class="fs-5">Map</h6>
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
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
    .itinerary_item .accordion-button {
        background-color: #CED2E0 !important;
    }
</style>