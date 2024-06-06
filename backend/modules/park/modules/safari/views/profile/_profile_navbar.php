    <!-- div -->
    <div class="card mg-b-20" id="tabs-style2">
        <div class="card-body">
            <div class="main-content-label mg-b-5">
                <?= $safari_park->title ?>
            </div>
            <?php

            use yii\helpers\Html;

            echo Html::a('<img src="/img/delete.png" alt="" width="25" height="25">', ['/park/safari/default/delete', 'id' => $safari_park->id], [
                'class' => 'btn btn-sm p-0 change-menuicon  col-md-2 float-end mb-3',
                'title' => 'Delete',
                'data' => [
                    'confirm' => 'Are you sure you want to delete ' . $safari_park->title . '?',
                    'method' => 'post',
                ],
            ]); ?>
        </div>

    </div>

    <div class=" tab-menu-heading">
        <div class="tabs-menu1">
            <!-- Tabs -->
            <ul class="nav panel-tabs main-nav-line">
                <li><a href="/park/safari/profile?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($about_active) ? $about_active : '' ?>">About Park</a></li>
                <li><a href="/park/safari/profile/gallery?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($gallery_active) ? $gallery_active : '' ?>">Park Gallery</a></li>
                <li><a href="/park/safari/profile/animal?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($animal_active) ? $animal_active : '' ?>">Park Animal</a></li>
                <li><a href="/park/safari/profile/zone?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($zone_active) ? $zone_active : '' ?>">Park Zone</a></li>
                <li><a href="/park/safari/profile/vehicle?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($vehicle_active) ? $vehicle_active : '' ?>">Park Vehicle</a></li>
                <li><a href="/park/safari/profile/flora-fauna?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($flora_fauna_active) ? $flora_fauna_active : '' ?>">Flora & Fauna</a></li>
                <li><a href="/park/safari/profile/how-to-reach?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($howtoreach_active) ? $howtoreach_active : '' ?>">How to Reach</a></li>
                <li><a href="/park/safari/profile/map?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($map_active) ? $map_active : '' ?>">Map</a></li>
                <li><a href="/park/safari/profile/suggestions?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($suggestions_active) ? $suggestions_active : '' ?>">Suggestions</a></li>
            </ul>
        </div>
    </div>