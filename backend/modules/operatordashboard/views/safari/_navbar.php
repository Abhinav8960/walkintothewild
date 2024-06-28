    <!-- div -->
    <div class="card mg-b-20" id="tabs-style2">
        <div class="card-body">
            <div class="main-content-label mg-b-5">
                <?= $safari_operator->register_comapany_name ?>
            </div>
        </div>

    </div>

    <div class=" tab-menu-heading">
        <div class="tabs-menu1">
            <!-- Tabs -->
            <ul class="nav panel-tabs main-nav-line">
                <li><a href="/operatordashboard/safari/index" class="nav-link <?= $active_navbar == 'overview' ? 'active' : '' ?>">Overview</a></li>
                <!-- <li><a href="/operatordashboard/safari/parklist" class="nav-link <?= $active_navbar == 'parklist' ? 'active' : '' ?>">Park List</a></li> -->
                <li><a href="/operatordashboard/safari/quote" class="nav-link <?= $active_navbar == 'quote' ? 'active' : '' ?>">Get a Free Quote</a></li>
                <li><a href="/operatordashboard/safari/sharedsafari" class="nav-link <?= $active_navbar == 'sharedsafari' ? 'active' : '' ?>">Shared Safari</a></li>
                <li><a href="/operatordashboard/safari/review" class="nav-link <?= $active_navbar == 'review' ? 'active' : '' ?>">User Review</a></li>
                <li><a href="/operatordashboard/safari/follower" class="nav-link <?= $active_navbar == 'follower' ? 'active' : '' ?>">Follower</a></li>
            </ul>
        </div>
    </div>