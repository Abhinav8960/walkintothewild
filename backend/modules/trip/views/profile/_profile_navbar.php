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
                <li><a href="/trip/profile?package_id=<?= $package->id ?>" class="nav-link <?= isset($overview_active) ? $overview_active : '' ?>">Overview</a></li>
                <li><a href="/trip/profile/itinerary?package_id=<?= $package->id ?>" class="nav-link <?= isset($itinerary_active) ? $itinerary_active : '' ?>">Itinerary</a></li>
                <li><a href="/trip/profile/inclusion?package_id=<?= $package->id ?>" class="nav-link <?= isset($inclusions_active) ? $inclusions_active : '' ?>">Inclusions</a></li>
                <li><a href="/trip/profile/exclusion?package_id=<?= $package->id ?>" class="nav-link <?= isset($exclusion_active) ? $exclusion_active : '' ?>">Exclusion</a></li>
                <li><a href="/trip/profile/term-condition?package_id=<?= $package->id ?>" class="nav-link <?= isset($term_condition_active) ? $term_condition_active : '' ?>">Terms & Conditions</a></li>
                <li><a href="/trip/profile/faq?package_id=<?= $package->id ?>" class="nav-link <?= isset($faq_active) ? $faq_active : '' ?>">FAQ</a></li>
            </ul>
        </div>
    </div>