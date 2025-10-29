<?php
$active_url = "/" . Yii::$app->requestedRoute;

$webasset = $this->assetManager->getBundle('\accounts\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>
<nav class="side_bar sidebar-offcanvas d-flex justify-content-start collapsed-sidebar">
    <ul class="nav">
        <li class="nav-item-profile d-flex justify-content-between align-items-center nav-item mb-5">
            <div class="profile-ditails d-flex justify-content-around align-items-center">
                <div class="pro-img me-3">
                    <a href="/">
                        <img src="<?= $this->params['baseurl'] ?>/images/accounts.png" alt="">
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
            <a href="/" class="navLinks d-flex align-items-center <?= in_array($active_url, ["/"]) ? "active" : "" ?>">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/",
                                                                                                )) ? 'Home2.svg' : 'home.svg' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu"> Dashboard</span>
            </a>
        </li>

        <li class="navItems mb-2">
            <a href="/transactioninfo/default/index" class="navLinks d-flex align-items-center <?= in_array($active_url, ["/transactioninfo/default/index"]) ? "active" : "" ?>">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/transactioninfo/default/index",
                                                                                                )) ? 'transaction_active.png' : 'transaction.png' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu">Transaction</span>
            </a>
        </li>

        <li class="navItems mb-2">
            <a href="/booking/fixed-departure/index" class="navLinks d-flex align-items-center <?= in_array($active_url, ["/booking/fixed-departure/index"]) ? "active" : "" ?>">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/booking/fixed-departure/index",
                                                                                                )) ? 'transaction.png' : 'transaction.png' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu" style="text-wrap-mode: nowrap">Fixed Departure Booking</span>
            </a>
        </li>

        <li class="navItems mb-2">
            <a href="/operator/default/index" class="navLinks d-flex align-items-center <?= in_array($active_url, ["/operator/default/index"]) ? "active" : "" ?>">
                <span class="nav-icon me-1"><img src="<?= $this->params['baseurl'] ?>/images/<?= in_array($active_url, array(
                                                                                                    "/operator/default/index",
                                                                                                )) ? 'transaction_active.png' : 'transaction.png' ?>" alt="" width="17" height="20"></span>
                <span class="hide-slide-menu" style="text-wrap-mode: nowrap">Operator</span>
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