
<div id="collapseFive" class="accordion-collapse " aria-labelledby="headingFive" data-bs-parent="#myTabContent">
    <div class="accordion-body p-0 overflow-hiden border-radious">
        <?php

        $latitude = $model->latitude;
        $longitude = $model->longitude;

        $mapUrl = "https://www.google.com/maps?q={$latitude},{$longitude}&hl=es&z=13&output=embed";

        if (!empty($latitude) && !empty($longitude)) {
        ?>

            <iframe width="100%" height="480" frameborder="0" style="border:0" src="<?= $mapUrl ?>" allowfullscreen>
            </iframe>

        <?php } ?>
    </div>
</div>