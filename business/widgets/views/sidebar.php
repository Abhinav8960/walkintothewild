<!-- BEGIN #sidebar -->
<?php
$active_url = "/" . Yii::$app->requestedRoute;
?>

<!-- main-sidebar -->
<div class="sticky">
    <aside class="app-sidebar ">
        <div class="main-sidebar-header active" style="background: #09422D !important;">
            <a class="header-logo active" href="/">
                <img src="<?= $this->params['baseurl'] ?>/img/logo.png" class="main-logo  desktop-logo" alt="logo">
                <img src="<?= $this->params['baseurl'] ?>/img/logo.png" class="main-logo  desktop-dark" alt="logo">
                <img src="<?= $this->params['baseurl'] ?>/img/sidebar_logo.png" class="main-logo  mobile-logo" alt="logo">
                <img src="<?= $this->params['baseurl'] ?>/img/logo.png" class="main-logo  mobile-dark" alt="logo">
            </a>
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left"><img src="<?= $this->params['baseurl'] ?>/img/material-symbols_logout-sharp.png" alt="" width="25" height="25" class="navhover_icon"></div>
            <ul class="side-menu">

                <li class="slide">
                    <a class="side-menu__item" href="/"><img src="<?= $this->params['baseurl'] ?>/img/material-symbols-light_home-outline.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Dashboard</span></a>
                </li>


                <li class="slide <?= in_array($active_url, array(
                                        "/package/default/index",
                                        "/package/default/create",
                                    )) ? "is-expanded" : "" ?>">
                    <a class="side-menu__item <?= in_array($active_url, array(
                                                    "/package/default/index",
                                                    "/package/default/create",
                                                )) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/ri_progress-2-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">My Packages</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Packages</a></li>
                        <li><a class="slide-item <?= in_array($active_url, array(
                                                        "/package/default/index",
                                                        "/package/default/create",

                                                    )) ? "active" : "" ?>" href="/package/default/index">Packages</a></li>
                    </ul>
                </li>

                <!-- <li class="slide <?= in_array($active_url, array(
                                        "/sharesafari/default/index",
                                        "/sharesafari/default/create",
                                    )) ? "is-expanded" : "" ?>">
                    <a class="side-menu__item <?= in_array($active_url, array(
                                                    "/sharesafari/default/index",
                                                    "/sharesafari/default/create",
                                                )) ? "active" : "" ?>" data-bs-toggle="slide" href="javascript:void(0);"><img src="<?= $this->params['baseurl'] ?>/img/ri_progress-2-line.png" alt="" width="25" height="25" class="navhover_icon"><span class="side-menu__label">Share Safari</span><i class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Package</a></li>
                        <li><a class="slide-item <?= in_array($active_url, array(
                                                         "/sharesafari/default/index",
                                                         "/sharesafari/default/create",

                                                    )) ? "active" : "" ?>" href="/sharesafari/default/index">Share Safari (Fixed Departure)</a></li>
                    </ul>
                </li> -->

                <li class="slide">
                    <a class="side-menu__item" href="<?= \yii\helpers\Url::to('/site/logout') ?>" data-method="post"> <img src="<?= $this->params['baseurl'] ?>/img/material-symbols_logout-sharp.png" alt="" width="25" height="25" class="navhover_icon">
                        <span class="side-menu__label">Logout</span></a>
                </li>

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </aside>
</div>
<!-- main-sidebar -->
<!-- END #sidebar -->