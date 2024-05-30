<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Safari Park Map';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/park/modules/safari/views/profile/_profile_navbar', ['safari_park' => $model, 'map_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <?php

                $latitude = $model->latitude;
                $longitude = $model->longitude;

                $mapUrl = "https://www.google.com/maps?q={$latitude},{$longitude}&hl=es;z=14&output=embed";

                if (!empty($latitude) && !empty($longitude)) {
                ?>

                    <iframe width="1500" height="450" frameborder="0" style="border:0" src="<?= $mapUrl ?>" allowfullscreen>
                    </iframe>

                <?php } ?>
            </div>
        </div>
    </div>
</div>