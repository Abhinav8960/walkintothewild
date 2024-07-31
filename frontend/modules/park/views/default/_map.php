<h2 class="accordion-header d-lg-none" id="headingFive">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
        MAP
    </button>
</h2>
<div id="collapseFive" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingFive" data-bs-parent="#myTabContent">
    <div class="accordion-body height_set w-100">
        <?php

        $latitude = $model->latitude;
        $longitude = $model->longitude;

        $mapUrl = "https://www.google.com/maps?q={$latitude},{$longitude}&hl=es&z=13&output=embed";

        if (!empty($latitude) && !empty($longitude)) {
        ?>

            <iframe width="100%" height="450" frameborder="0" style="border:0" src="<?= $mapUrl ?>" allowfullscreen>
            </iframe>

        <?php } ?>
    </div>
</div>