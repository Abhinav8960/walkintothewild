<ul class="nav nav-tabs d-none d-lg-flex gap-2" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="/package/profile/<?= $package->id ?>" class="nav-link <?= isset($overview_active) ? $overview_active : '' ?>" id="home-tab">OVERVIEW</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/package/profile/itinerary/<?= $package->id ?>/1" class="nav-link <?= isset($itinerary_active) ? $itinerary_active : '' ?>" id="profile-tab">Itinerary</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/package/profile/inclusion/<?= $package->id ?>" class="nav-link <?= isset($inclusions_active) ? $inclusions_active : '' ?>" id="contact-tab">Inclusions</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/package/profile/getting-there/<?= $package->id ?>" class="nav-link <?= isset($getting_there_active) ? $getting_there_active : '' ?>" id="howto-reach">Getting There</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/package/profile/policy-info/<?= $package->id ?>" class="nav-link <?= isset($policy_info_active) ? $policy_info_active : '' ?>" id="map-tab">Policy Info</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/package/profile/faq/<?= $package->id ?>" class="nav-link <?= isset($faq_active) ? $faq_active : '' ?>" id="map-tab">FAQ</a>
    </li>
</ul>