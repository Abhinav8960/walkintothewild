<?php
$active_url = "/" . Yii::$app->requestedRoute;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<nav class="side_bar sidebar-offcanvas d-flex justify-content-start collapsed-sidebar">
    <ul class="nav">
        <li class="nav-item-profile d-flex justify-content-between align-items-center nav-item mb-5">
            <div class="profile-ditails d-flex justify-content-around align-items-center">
                <div class="pro-img me-3">
                    <a href="/">
                        <img src="<?= $this->params['baseurl'] ?>/images/partner.jpg" alt="">
                        <span class="success-online"></span>
                    </a>
                </div>
            </div>
            <button class="navbar-toggler navbar-toggler align-self-center d-lg-block d-none" type="button"
                data-toggle="minimize" id="hider-sidebar">
                <span class="mdi mdi-menu"></span>
            </button>
        </li>
        <li class="navItems mb-2">
            <a href="/" class="navLinks d-flex align-items-center <?= in_array($active_url, ["/"]) ? "active" : "" ?>" data-toggle="tooltip" data-placement="top" title="Dashboard">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/",
                                                                                                )) ? 'Home2.svg' : 'home.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Dashboard</span>
            </a>
        </li>
        <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                "/leads/default/index",
                                                                "/leads/default/create",
                                                                "/leads/default/view",
                                                            )) ? "active" : "" ?>" href="/leads/default/index" data-toggle="tooltip" data-placement="top" title="Leads">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/leads/default/index",
                                                                                                    "/leads/default/create",
                                                                                                    "/leads/default/view",
                                                                                                )) ? 'Frame_new.svg' : 'Frame.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Leads</span>
            </a>
        </li>

        <!-- <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                "/fixeddeparturechat/default/index",
                                                            )) ? "active" : "" ?>" href="/fixeddeparturechat/default/index">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/fixeddeparturechat/default/index",
                                                                                                )) ? 'Frame_new.svg' : 'Frame.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu">Fixed Departure Chat</span>
            </a>
        </li> -->

        <li class="navItems mb-2">
            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                "/package/default/index",
                                                                "/package/default/create",
                                                                "/package/default/view",
                                                                "/package/default/update",
                                                                "/package/default/itinerary",
                                                                "/package/default/inclusion",
                                                                "/package/default/policy-info",
                                                                "/package/default/faq",
                                                                "/package/default/getting-there",
                                                            )) ? "active" : "" ?>" href="/package/default/index" data-toggle="tooltip" data-placement="top" title="Package">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/package/default/index",
                                                                                                    "/package/default/create",
                                                                                                    "/package/default/view",
                                                                                                    "/package/default/update",
                                                                                                    "/package/default/itinerary",
                                                                                                    "/package/default/inclusion",
                                                                                                    "/package/default/policy-info",
                                                                                                    "/package/default/faq",
                                                                                                    "/package/default/getting-there",
                                                                                                )) ? 'package_active.svg' : 'package.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu" style="    white-space: nowrap;">Packages</span>
            </a>
        </li>

        <li class="navItems mb-2">
            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                "/sharesafari/default/index",
                                                                "/sharesafari/default/create",
                                                                "/sharesafari/default/update",
                                                                "/sharesafari/default/itinerary",
                                                                "/sharesafari/default/inclusion",
                                                                "/sharesafari/default/getting-there",
                                                                "/sharesafari/default/policy-info",
                                                                "/sharesafari/default/faq",
                                                                "/sharesafari/default/chat-view",
                                                                "/sharesafari/default/booked-user",
                                                                "/sharesafari/default/booked-user-chat",
                                                            )) ? "active" : "" ?>" href="/sharesafari/default/index" data-toggle="tooltip" data-placement="top" title="My Fixed Departures">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/sharesafari/default/index",
                                                                                                    "/sharesafari/default/create",
                                                                                                    "/sharesafari/default/itinerary",
                                                                                                    "/sharesafari/default/inclusion",
                                                                                                    "/sharesafari/default/getting-there",
                                                                                                    "/sharesafari/default/policy-info",
                                                                                                    "/sharesafari/default/faq",
                                                                                                    "/sharesafari/default/update",
                                                                                                    "/sharesafari/default/chat-view",
                                                                                                    "/sharesafari/default/boked-user",
                                                                                                    "/sharesafari/default/booked-user-chat",
                                                                                                )) ? 'fd_active.svg' : 'fd.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu">My Fixed Departures</span>
            </a>
        </li>
        <li class="navItems mb-2">
            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                "/booking/default/index",
                                                            )) ? "active" : "" ?>" href="/booking/default/index" data-toggle="tooltip" data-placement="top" title="Booking">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/booking/default/index",
                                                                                                )) ? 'transaction_active.png' : 'transaction.png' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu">Booking</span>
            </a>
        </li>


        <!-- <li class="navItems mb-2">
            <a href="" class="navLinks  d-flex align-items-center">
                <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
                <span class="hide-slide-menu"> My Fixed Departures</span>
            </a>
        </li> -->
        <!-- <li class="navItems mb-2">
            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                "/sightings/default/index",
                                                                "/sightings/default/create",
                                                            )) ? "active" : "" ?>" href="/sightings/default/index">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/sightings/default/index",
                                                                                                    "/sightings/default/create",
                                                                                                )) ? 'Sighting_active.svg' : 'Sighting.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Sightings</span>
            </a>
        </li>
        <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                "/posts/default/index",
                                                                "/posts/default/create",

                                                            )) ? "active" : "" ?>" href="/posts/default/index">
                <span class="nav-icon me-1"> <img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/posts/default/index",
                                                                                                    "/posts/default/create",
                                                                                                )) ? 'Post_active.svg' : 'Post.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Posts</span>
            </a>
        </li> -->

        <!-- <li class="navItems mb-2">
            <a href="" class="navLinks d-flex align-items-center">
                <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
                <span class="hide-slide-menu"> Reports</span>
            </a>
        </li>
        <li class="navItems mb-2">
            <a href="" class="navLinks  d-flex align-items-center">
                <span class="nav-icon me-1"> <i class="fa-solid fa-house-chimney"></i></span>
                <span class="hide-slide-menu"> Settings</span>
            </a>
        </li> -->
        <!-- <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                "/sightings/default/index",
                                                                "/sightings/default/create",

                                                            )) ? "active" : "" ?>" href="/sightings/default/index">
                <span class="nav-icon me-1"> <img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/sightings/default/index",
                                                                                                    "/sightings/default/create",
                                                                                                )) ? 'Frame.svg' : 'Frame.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Sightings</span>
            </a>
        </li>
         <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                "/posts/default/index",
                                                                "/posts/default/create",

                                                            )) ? "active" : "" ?>" href="/posts/default/index">
                <span class="nav-icon me-1"> <img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/posts/default/index",
                                                                                                    "/posts/default/create",
                                                                                                )) ? 'Frame.svg' : 'Frame.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Posts</span>
            </a>
        </li> -->
        <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                "/gallery/default/approved",
                                                                "/gallery/default/create",
                                                                "/gallery/default/index",
                                                                "/gallery/default/pending-for-approval",
                                                                "/gallery/default/view",
                                                                "/gallery/default/approved-view",

                                                            )) ? "active" : "" ?>" href="/gallery/default/approved" data-toggle="tooltip" data-placement="top" title="Gallery">
                <span class="nav-icon me-1"> <img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/gallery/default/approved",
                                                                                                    "/gallery/default/create",
                                                                                                    "/gallery/default/index",
                                                                                                    "/gallery/default/pending-for-approval",
                                                                                                    "/gallery/default/view",
                                                                                                    "/gallery/default/approved-view",

                                                                                                )) ? 'Gallery_active.svg' : 'Gallery.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Gallery</span>
            </a>
        </li>



        <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                "/faqs/default/index",
                                                                "/faqs/default/create",
                                                                "/faqs/default/update",

                                                            )) ? "active" : "" ?>" href="/faqs/default/index" data-toggle="tooltip" data-placement="top" title="Faqs">
                <span class="nav-icon me-1"> <img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/faqs/default/index",
                                                                                                    "/faqs/default/create",
                                                                                                    "/faqs/default/update",
                                                                                                )) ? 'Frame_new.svg' : 'Frame.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Faqs</span>
            </a>
        </li>

        <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                "/mybusinessprofile/default/index",
                                                            )) ? "active" : "" ?>" href="/mybusinessprofile/default/index" data-toggle="tooltip" data-placement="top" title="My Business Profile">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/mybusinessprofile/default/index",
                                                                                                )) ? 'dpmain.png' : 'dpmain.png' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu">My Business Profile</span>
            </a>
        </li>


        <li class="navItems navitemLogout mb-2 ms-0">
            <a class="navLinks  d-flex align-items-center" href="<?= \yii\helpers\Url::to('/site/logout') ?>" data-method="post">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/Icon_material-twotone-logout.svg" alt="" width="25" height="25"></span>
                <span class="hide-slide-menu"> Logout</span>
            </a>
        </li>
    </ul>
</nav>