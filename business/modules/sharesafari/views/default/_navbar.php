<ul class="mynav nav-tabs flex-row mt-4">
    <li class="nav-item" role="presentation">
        <a href="/sharesafari/default/update?id=<?= $shared_safari_departure_version_model->id ?>" class="nav-link <?= isset($overview_active) ? $overview_active : '' ?>">Overview</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/sharesafari/default/itinerary?id=<?= $shared_safari_departure_version_model->id ?>" class="nav-link <?= isset($itinerary_active) ? $itinerary_active : '' ?>">Itinerary</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/sharesafari/default/inclusion?id=<?= $shared_safari_departure_version_model->id ?>" class="nav-link <?= isset($inclusions_active) ? $inclusions_active : '' ?>">Inclusions</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/sharesafari/default/getting-there?id=<?= $shared_safari_departure_version_model->id ?>" class="nav-link <?= isset($getting_there_active) ? $getting_there_active : '' ?>">Getting There</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/sharesafari/default/policy-info?id=<?= $shared_safari_departure_version_model->id ?>" class="nav-link <?= isset($policy_info_active) ? $policy_info_active : '' ?>">Policy Info</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="/sharesafari/default/faq?id=<?= $shared_safari_departure_version_model->id ?>" class="nav-link <?= isset($faq_active) ? $faq_active : '' ?>">FAQ</a>
    </li>
</ul>