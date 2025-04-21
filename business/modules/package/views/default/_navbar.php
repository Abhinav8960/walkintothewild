<div class=" tab-menu-heading">
    <div class="tabs-menu1">
        <!-- Tabs -->
        <ul class="nav panel-tabs main-nav-line">
            <li><a href="/package/default/update?id=<?= $package->id ?>" class="nav-link <?= isset($overview_active) ? $overview_active : '' ?>">Overview</a></li>
            <li><a href="/package/default/itinerary?id=<?= $package->id ?>" class="nav-link <?= isset($itinerary_active) ? $itinerary_active : '' ?>">Itinerary</a></li>
            <li><a href="/package/default/inclusion?id=<?= $package->id ?>" class="nav-link <?= isset($inclusions_active) ? $inclusions_active : '' ?>">Inclusions</a></li>
            <li><a href="/package/default/getting-there?id=<?= $package->id ?>" class="nav-link <?= isset($getting_there_active) ? $getting_there_active : '' ?>">Getting There</a></li>
            <li><a href="/package/default/policy-info?id=<?= $package->id ?>" class="nav-link <?= isset($policy_info_active) ? $policy_info_active : '' ?>">Policy Info</a></li>
            <li><a href="/package/default/faq?id=<?= $package->id ?>" class="nav-link <?= isset($faq_active) ? $faq_active : '' ?>">FAQ</a></li>
        </ul>
    </div>
</div>