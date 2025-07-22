<?php
$active_url = '/' . Yii::$app->requestedRoute;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<nav class="side_bar sidebar-offcanvas d-flex justify-content-center">
    <ul class="nav">
        <li class="nav-item-profile d-flex justify-content-between align-items-center nav-item mb-5">
            <div class="profile-ditails d-flex justify-content-around align-items-center">
                <div class="pro-img me-3">
                    <a href="/">
                        <img src="<?= $this->params['baseurl'] ?>/images/sp.jpg" alt="">
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
            <a href="/" class="navLinks d-flex align-items-center <?= in_array($active_url, ['/']) ? 'active' : '' ?>">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/',
                                                                                                )) ? 'Home2.svg' : 'home.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Dashboard</span>
            </a>
        </li>
        <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                '/leads/default/index',
                                                                '/leads/default/create',
                                                                '/leads/default/view',
                                                            )) ? 'active' : '' ?>" href="/leads/default/index">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/leads/default/index',
                                                                                                    '/leads/default/create',
                                                                                                    '/leads/default/view',
                                                                                                )) ? 'Frame_new.svg' : 'Frame.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Leads</span>
            </a>
        </li>


        <li class="navItems mb-2">
            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                '/sightings/default/index',
                                                                '/sightings/default/create',
                                                            )) ? 'active' : '' ?>" href="/sightings/default/index">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/sightings/default/index',
                                                                                                    '/sightings/default/create',
                                                                                                    '/sightings/default/view',
                                                                                                )) ? 'Sighting_active.svg' : 'Sighting.svg' ?>" alt="" width="17" height="20"></span> <span class="hide-slide-menu"> Sightings</span>
            </a>
        </li>
        <li class="navItems mb-2">
            <a class="navLinks  d-flex align-items-center <?= in_array($active_url, array(
                                                                '/posts/default/index',
                                                                '/posts/default/create',
                                                            )) ? 'active' : '' ?>" href="/posts/default/index">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/posts/default/index',
                                                                                                    '/posts/default/create',
                                                                                                    '/posts/default/view',
                                                                                                )) ? 'Post_active.svg' : 'Post.svg' ?>" alt="" width="17" height="20"></span> <span class="hide-slide-menu"> Posts</span>
            </a>
        </li>

        <li class="navItems mb-2 position-relative <?= in_array($active_url, array(
                                        "/operator/safari-operator/index",
                                        "/operator/safari-operator/view",
                                        "/operator/safari-operator/index/view",
                                        "/operator/birding-operator/index",
                                        "/operator/birding-operator/view",
                                        "/gallery/default/index",
                                        "/galleryapproval/default/index",
                                        "/gallery/default/view",
                                        "/operatorapproval/default/index",
                                        "/operatorapproval/default/view"
                                    )) ? "is-expanded" : "" ?>">

            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                "/operator/safari-operator/index",
                                                                "/operator/safari-operator/view"
                                                            )) ? "active" : "" ?>"
                data-bs-toggle="collapse"
                href="#operatorMenu"
                role="button"
                aria-expanded="<?= in_array($active_url, array(
                                    "/operator/safari-operator/index",
                                    "/operator/safari-operator/view",
                                    "/operator/safari-operator/index/view",
                                    "/operator/birding-operator/index",
                                    "/operator/birding-operator/view",
                                    "/gallery/default/index",
                                    "/galleryapproval/default/index",
                                    "/gallery/default/view",
                                    "/operatorapproval/default/index",
                                    "/operatorapproval/default/view"
                                )) ? "true" : "false" ?>"
                aria-controls="operatorMenu">
                
                <span class="nav-icon me-1 "><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/operator/safari-operator/index',
                                                                                                    '/operator/safari-operator/create',
                                                                                                    '/operator/safari-operator/view',
                                                                                                )) ? 'package_active.svg' : 'operator.png' ?>" alt="" width="17" height="20"></span> <span class="side-menu__label hide-slide-menu">Operator <a href="" class="drop_imagesCC">
                    <img src="<?= $this->params['baseurl'] ?>/images/dropdownicon.png" class="card-img-top" alt="">
            </a></span>
                <!-- <i class="angle fe fe-chevron-right"></i> -->
             
            </a>

            <ul class="slide-menu collapse pt-2 <?= in_array($active_url, array(
                                                "/operator/safari-operator/index",
                                                "/operator/safari-operator/view",
                                                "/operator/safari-operator/index/view",
                                                "/operator/birding-operator/index",
                                                "/operator/birding-operator/view",
                                                "/gallery/default/index",
                                                "/galleryapproval/default/index",
                                                "/gallery/default/view",
                                                "/operatorapproval/default/index",
                                                "/operatorapproval/default/view"
                                            )) ? "show" : "" ?>" id="operatorMenu">

                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                        "/gallery/default/index",
                                                                        "/galleryapproval/default/index",
                                                                        "/gallery/default/view"
                                                                    )) ? "active" : "" ?>" href="/gallery/default/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                        "/gallery/default/index",
                                                                        "/galleryapproval/default/index",
                                                                        "/gallery/default/view"
                                                                    )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Gallery List</span></a>
                </li>

                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                        "/operatorapproval/default/index",
                                                                        "/operatorapproval/default/view"
                                                                    )) ? "active" : "" ?>" href="/operatorapproval/default/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                        "/operatorapproval/default/index",
                                                                        
                                                                        "/operatorapproval/default/view"
                                                                    )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Operator Approval List</span></a>
                </li>

                <li class="navItems mb-2">
                    <a class="navLinks navinnerLink d-flex align-items-center <?= in_array($active_url, array(
                                                                        "/operator/safari-operator/index",
                                                                        "/operator/safari-operator/index/view"
                                                                    )) ? "active" : "" ?>" href="/operator/safari-operator/index"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                         "/operator/safari-operator/index",
                                                                        "/operator/safari-operator/index/view",                                                            
                                                                    )) ? 'dropdowncircleicons.png' : 'dropdowncircleicons.png' ?>" alt="" class="me-2 circleImages-sidebar"><span class="hide-slide-menu">Safari Tour Operator</span></a>
                </li>
            </ul>
            
        </li>




        <li class="navItems mb-2">
            <a class="navLinks d-flex align-items-center <?= in_array($active_url, array(
                                                                '/package/default/index',
                                                                '/package/default/create',
                                                            )) ? 'active' : '' ?>" href="/package/default/index">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    '/package/default/index',
                                                                                                    '/package/default/create',
                                                                                                    '/package/default/view',
                                                                                                )) ? 'package_active.svg' : 'package.svg' ?>" alt="" width="17" height="20"></span> <span class="hide-slide-menu">Packages</span>
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