    <!-- div -->
    <div class="card mg-b-20" id="tabs-style2">
        <div class="card-body">
            <div class="main-content-label mg-b-5">
                <?= $package->package_name ?>
            </div>
        </div>

    </div>

    <div class=" tab-menu-heading">
        <div class="tabs-menu1">
            <!-- Tabs -->
            <ul class="nav panel-tabs main-nav-line">
                <li><a href="/package/profile?package_id=<?= $package->id ?>" class="nav-link <?= isset($overview_active) ? $overview_active : '' ?>">Overview</a></li>
                <li><a href="/package/profile/itinerary?package_id=<?= $package->id ?>" class="nav-link <?= isset($itinerary_active) ? $itinerary_active : '' ?>">Itinerary</a></li>
                <li><a href="/package/profile/inclusion?package_id=<?= $package->id ?>" class="nav-link <?= isset($inclusions_active) ? $inclusions_active : '' ?>">Inclusions</a></li>
                <li><a href="/package/profile/policy-info?package_id=<?= $package->id ?>" class="nav-link <?= isset($policy_info_active) ? $policy_info_active : '' ?>">Policy Info</a></li>
                <li><a href="/package/profile/faq?package_id=<?= $package->id ?>" class="nav-link <?= isset($faq_active) ? $faq_active : '' ?>">FAQ</a></li>
            </ul>
        </div>
    </div>