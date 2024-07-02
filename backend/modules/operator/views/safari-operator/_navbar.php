    <!-- div -->
    <div class="card mg-b-20" id="tabs-style2">
        <div class="card-body">
            <div class="main-content-label mg-b-5">
                <?= $model->register_comapany_name ?>
            </div>
        </div>

    </div>

    <div class=" tab-menu-heading">
        <div class="tabs-menu1">
            <!-- Tabs -->
            <ul class="nav panel-tabs main-nav-line">
                <li><a href="/operator/safari-operator/view?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'overview' ? 'active' : '' ?>">Overview</a></li>
                <li><a href="/operator/safari-operator/quote?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'quote' ? 'active' : '' ?>">Get a Free Quote</a></li>
                <li><a href="/operator/safari-operator/sharedsafari?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'sharedsafari' ? 'active' : '' ?>">Shared Safari</a></li>
                <li><a href="/operator/safari-operator/review?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'review' ? 'active' : '' ?>">User Review</a></li>
                <li><a href="/operator/safari-operator/follower?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'follower' ? 'active' : '' ?>">Follower</a></li>
            </ul>
        </div>
    </div>