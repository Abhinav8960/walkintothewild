<div class="card mt-2">
    <div class="card-body">
        <div class="row pt-4">
            <div class="col-12">
                <div class="accordion" id="accordionExample">
                    <?php if ($share_safari->sharesafaridays) {
                        $share_safaridays = $share_safari->sharesafaridays;
                        foreach ($share_safaridays as $share_safariday) { ?>
                            <div class="accordion-item itinerary_item mt-2">
                                <h2 class="accordion-header" id="heading<?= $share_safariday->day ?>">
                                    <div class="accordion-button custom-header" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $share_safariday->day ?>" aria-expanded="true" aria-controls="collapse<?= $share_safariday->day ?>">
                                        DAY <?= $share_safariday->day ?> - <?= $share_safariday->day_title ?>
                                    </div>
                                </h2>
                                <div id="collapse<?= $share_safariday->day ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $share_safariday->day ?>" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="text_wrapperite">
                                                    <p><?= $share_safariday->day_description ?></p>
                                                </div>
                                            </div>
                                        </div>
                                         <?php if ($share_safariday->partner_gallery_id && !empty($share_safariday->gallery_json)) {
                                            $gallery_images = json_decode($share_safariday->gallery_json, true);
                                            $images = $gallery_images['images'];
                                        ?>
                                            <h6>Accomodation Images</h6>
                                            <div id="carouselExampleIndicators<?= $share_safariday->day ?>" class="carousel slide" data-bs-ride="carousel">
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
                                            </div>
                                        <?php } ?>
                                        <?php if (false) { ?>
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
                                            </div>

                                            <div class="titles_locations pt-4">
                                                <h6 class="fs-5">Map</h6>
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