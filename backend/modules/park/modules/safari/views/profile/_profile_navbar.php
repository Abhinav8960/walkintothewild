<?php

use yii\helpers\Url;
?>
<!-- div -->
<div class="card mg-b-20" id="tabs-style2">
    <div class="card-body">
        <div class="main-content-label mg-b-5">
            <?= $safari_park->title ?>
        </div>
    </div>

</div>

<div class=" tab-menu-heading">
    <div class="tabs-menu1">
        <!-- Tabs -->
        <ul class="nav panel-tabs main-nav-line">
            <li><a href="/park/safari/profile?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($about_active) ? $about_active : '' ?>">Overview</a></li>
            <li><a href="/park/safari/profile/media?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($media_active) ? $media_active : '' ?>">Park Media</a></li>
            <li><a href="/park/safari/profile/zone?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($zone_active) ? $zone_active : '' ?>">Park Zone/Gate</a></li>
            <li><a href="/park/safari/profile/flora-fauna?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($flora_fauna_active) ? $flora_fauna_active : '' ?>">Flora & Fauna</a></li>
            <li><a href="/park/safari/profile/how-to-reach?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($howtoreach_active) ? $howtoreach_active : '' ?>">How to Reach</a></li>
            <li><a href="/park/safari/profile/map?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($map_active) ? $map_active : '' ?>">Map</a></li>
            <li><a href="/park/safari/profile/meta?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($meta_active) ? $meta_active : '' ?>">Meta</a></li>
            <li><a href="/park/safari/profile/suggestions?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($suggestions_active) ? $suggestions_active : '' ?>">Suggestions</a></li>
            <li><a href="/park/safari/profile/reviews?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($reviews_active) ? $reviews_active : '' ?>">Reviews</a></li>
            <li><a href="/park/safari/profile/operatorlist?safari_park_id=<?= $safari_park->id ?>" class="nav-link <?= isset($operator_list) ? $operator_list : '' ?>">Operator List</a></li>
            <li><a href="<?= Url::toRoute(['/park/safari/profile/park-stay-list', 'safari_park_id' => $safari_park->id]) ?>" class="nav-link <?= isset($park_stay_category_list) ? $park_stay_category_list : '' ?>">Stay Category</a></li>
        </ul>
    </div>
</div>