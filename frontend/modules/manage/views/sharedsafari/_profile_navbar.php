<ul class="nav nav-tabs slider_addmobile2 text-lg-left text-center d-flex gap-2 ps-3 mb-4 border-bottom " id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="/manage/sharedsafari/update-fixed-departure/<?= $sharedsafari->slug ?>" class="nav-link <?= isset($overview_active) ? $overview_active : '' ?>" id="home-tab">Overview</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/manage/sharedsafari/itinerary/<?= $sharedsafari->slug ?>/1" class="nav-link <?= isset($itinerary_active) ? $itinerary_active : '' ?>" id="profile-tab">Itinerary</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/manage/sharedsafari/inclusion/<?= $sharedsafari->slug ?>" class="nav-link <?= isset($inclusions_active) ? $inclusions_active : '' ?>" id="contact-tab">Inclusions</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/manage/sharedsafari/getting-there/<?= $sharedsafari->slug ?>" class="nav-link <?= isset($getting_there_active) ? $getting_there_active : '' ?>" id="howto-reach">Getting There</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/manage/sharedsafari/policy-info/<?= $sharedsafari->slug ?>" class="nav-link <?= isset($policy_info_active) ? $policy_info_active : '' ?>" id="map-tab">Policy Info</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/manage/sharedsafari/faq/<?= $sharedsafari->slug ?>" class="nav-link <?= isset($faq_active) ? $faq_active : '' ?>" slug="map-tab">FAQ</a>
    </li>
    <!-- <li class="nav-item" role="presentation">
        <a href="/manage/sharedsafari/gallery/<?= $sharedsafari->slug ?>" class="nav-link <?= isset($gallery_active) ? $gallery_active : '' ?>" id="map-tab">Gallery</a>
    </li> -->
</ul>