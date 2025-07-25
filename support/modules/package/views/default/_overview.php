<div class="card mt-2">
    <div class="card-body">
        <div class="row pt-0">
            <div class="col-12">
                <div class="accordion" id="accordionExample">
                    <?php if ($package->packagedays) {
                        $packagedays = $package->packagedays;
                        foreach ($packagedays as $packageday) { ?>
                            <div class="accordion-item itinerary_item faq_item mt-2">
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

                                        <?php if ($packageday->partner_gallery_id && !empty($packageday->gallery_json)) {
                                            $gallery_images = json_decode($packageday->gallery_json, true);
                                            $images = $gallery_images['images'];
                                        ?>
                                            <h6>Accomodation Images</h6>
                                            <div id="carouselExampleIndicators<?= $packageday->day ?>" class="carousel slide" data-bs-ride="carousel">
                                                <!-- <div class="carousel-indicators<?= $packageday->day ?>">
                                                            <?php foreach ($images as $index => $image) { ?>
                                                                <button type="button" data-bs-target="#carouselExampleIndicators<?= $packageday->day ?>" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
                                                            <?php } ?>
                                                        </div> -->
                                                <div class="carousel-inner">
                                                    <?php foreach ($images as $index => $image) { ?>
                                                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                                            <img class="d-block w-100 rounded carousel-img" src="<?= $image['gallery_image_path'] ?>" alt="<?= htmlspecialchars($image['title']) ?>">
                                                            <div class="carousel-caption d-none d-md-block">
                                                                <h5><?= $image['title'] ?></h5>
                                                                <p><?= $image['caption'] ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>

                                                <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators<?= $packageday->day ?>" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators<?= $packageday->day ?>" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button> -->
                                            </div>
                                        <?php } ?>

                                        <?php if (false) { ?>
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