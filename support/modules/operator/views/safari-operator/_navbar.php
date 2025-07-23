<?php

use yii\helpers\Url;
?>
<!-- div -->
<div class="card mg-b-20 bg-transparent border-0" id="tabs-style2">
    <div class="card-body">
        <div class="main-content-label mg-b-5">
            <?= $model->register_comapany_name ?>
        </div>

        <!-- <div class="btn-delet float-end py-2">
            <button class="btn_userarticle" style="background:#F7BF39 !important;color:black !important;padding: 10px 16px !important; border:0; border-radius:10px" value="<?= \yii\helpers\Url::toRoute(['/operator/safari-operator/delete', 'id' => $model->id]) ?>"><i class="fas fa-trash me-1"></i>Delete</button>
        </div> -->
        <div class="row mt-2">
            <div class="col-2">
                <div class="card">
                    <div class="ps-4 pt-4 pe-3 pb-4">
                        <div class="">
                            <h6 class="mb-2 tx-12 ">Shared Safari</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <h4 class="tx-20 font-weight-semibold mb-2">
                                    <?= isset($model->safaricount) ? $model->safaricount : ''; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="ps-4 pt-4 pe-3 pb-4">
                        <div class="">
                            <h6 class="mb-2 tx-12 ">Fixed Departure</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <h4 class="tx-20 font-weight-semibold mb-2">
                                    <?= isset($model->sharedsafaricount) ? $model->sharedsafaricount : ''; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <div class="card">
                    <div class="ps-4 pt-4 pe-3 pb-4">
                        <div class="">
                            <h6 class="mb-2 tx-12 ">Package</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <h4 class="tx-20 font-weight-semibold mb-2">
                                    <?= isset($model->packagecount) ? $model->packagecount : ''; ?>
                                </h4>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-2">
                <div class="card">
                    <div class="ps-4 pt-4 pe-3 pb-4">
                        <div class="">
                            <h6 class="mb-2 tx-12 ">Quotes</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <h4 class="tx-20 font-weight-semibold mb-2">
                                    <?= isset($model->quotescount) ? $model->quotescount : ''; ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 
    <div class=" tab-menu-heading">
        <div class="tabs-menu1">
          
            <ul class="nav panel-tabs main-nav-line">
                <li><a href="/operator/safari-operator/view?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'overview' ? 'active' : '' ?>">Overview</a></li>
                <li><a href="/operator/safari-operator/quote?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'quote' ? 'active' : '' ?>">Get a Free Quote</a></li>
                <li><a href="/operator/safari-operator/sharedsafari?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'sharedsafari' ? 'active' : '' ?>">Shared Safari</a></li>
                <li><a href="/operator/safari-operator/review?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'review' ? 'active' : '' ?>">User Review</a></li>
                <li><a href="/operator/safari-operator/follower?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'follower' ? 'active' : '' ?>">Follower</a></li>
                <li><a href="/operator/safari-operator/registration-details?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'registration-details' ? 'active' : '' ?>">Registration Details</a></li>
                <li><a href="/operator/safari-operator/business-details?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'business-details' ? 'active' : '' ?>">Business Details</a></li>
                <li><a href="/operator/safari-operator/bank-details?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'bank-details' ? 'active' : '' ?>">Bank Details</a></li>
                <li><a href="/operator/safari-operator/userkyc-details?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'userkyc-details' ? 'active' : '' ?>">User Kyc Details</a></li>

            </ul>
        </div>
    </div>
</div> -->

    <!-- <div class=" tab-menu-heading">
    <div class="tabs-menu1">
        Tabs
        <ul class="nav panel-tabs main-nav-line">
            <li><a href="/operator/safari-operator/view?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'overview' ? 'active' : '' ?>">Overview</a></li>
            <li><a href="/operator/safari-operator/quote?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'quote' ? 'active' : '' ?>">Get a Free Quote</a></li>
            <li><a href="/operator/safari-operator/sharedsafari?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'sharedsafari' ? 'active' : '' ?>">Shared Safari</a></li>
            <li><a href="/operator/safari-operator/review?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'review' ? 'active' : '' ?>">User Review</a></li>
            <li><a href="/operator/safari-operator/follower?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'follower' ? 'active' : '' ?>">Follower</a></li>
            <li><a href="<?= Url::toRoute(['/operator/safari-operator/operator-parks', 'id' => $model->id]) ?>" class="nav-link <?= $active_navbar == 'operator-parks' ? 'active' : '' ?>">Operator Parks</a></li>
            <li><a href="<?= Url::toRoute(['/operator/safari-operator/bank-and-kyc-details', 'id' => $model->id]) ?>" class="nav-link <?= $active_navbar == 'bank-and-kyc-details' ? 'active' : '' ?>">Bank and Kyc Details</a></li>

        </ul>
    </div>
</div> -->

    <!-- <div class="modal fade _standard-text" id="organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail for Delete</h1>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='userstatusmodalContent'></div>
            </div>
        </div>
    </div>
</div> -->



    <!-- STATIC TABS NEW START HERE  -->
    <div class="">
        <div class="assign-tabs operatorTab">

            <ul class="nav nav-tabs flex-row flex-wrap" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                        type="button" role="tab" aria-controls="home" aria-selected="true">Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">Legal entity
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                        type="button" role="tab" aria-controls="contact" aria-selected="false">Registration proof
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#con" type="button"
                        role="tab" aria-controls="contact" aria-selected="false">Business </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#fivcont"
                        type="button" role="tab" aria-controls="contact" aria-selected="false">Bank Details </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#svencont"
                        type="button" role="tab" aria-controls="contact" aria-selected="false">User KYC</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#eighttcont"
                        type="button" role="tab" aria-controls="contact" aria-selected="false">User Review</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#ninetcont"
                        type="button" role="tab" aria-controls="contact" aria-selected="false">Operator Park</button>
                </li>
            </ul>


            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="overviewDataParent">
                                <table class="table w-100 border-0 border_o d-inline-block py-3 bg-white">
                                    <tbody class="tbody-leads sighting-leads py-5 w-100">
                                        <tr>
                                            <td style="width: 60%;">Business Name:</td>
                                            <td style="width: 50%;">
                                                <p>Shivsakti</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address:</td>
                                            <td>
                                                <p>Noida sector 62</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number: </td>
                                            <td>
                                                <p>8825317553</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Legal entity Email:</td>
                                            <td>
                                                <p>annu@gmail.com</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Category:</td>
                                            <td>
                                                <p>Safari Tour Operator</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PAN Number:</td>
                                            <td>
                                                <p>DFY1533SF</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Approved Status:</td>
                                            <td>
                                                <p>Yes</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="identification-photo">
                                <p class="mb-1">Pan Photo: </p>
                                <a href="/">
                                    <img src="<?= $this->params['baseurl'] ?>/images/pancard.png" alt=""
                                        class="w-100 h-100 object-fit-cover">
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="overviewDataParent">
                                <table class="table w-100 border-0 border_o d-inline-block py-3 bg-white">
                                    <tbody class="tbody-leads sighting-leads py-5 w-100">
                                        <tr>
                                            <td style="width: 60%;">Business Name:</td>
                                            <td style="width: 50%;">
                                                <p>Shivsakti</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address:</td>
                                            <td>
                                                <p>Noida sector 62</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number: </td>
                                            <td>
                                                <p>8825317553</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Legal entity Email:</td>
                                            <td>
                                                <p>annu@gmail.com</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Category:</td>
                                            <td>
                                                <p>Safari Tour Operator</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PAN Number:</td>
                                            <td>
                                                <p>DFY1533SF</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Approved Status:</td>
                                            <td>
                                                <p>Yes</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="identification-photo">
                                <p class="mb-1">Pan Photo: </p>
                                <a href="/">
                                    <img src="<?= $this->params['baseurl'] ?>/images/pancard.png" alt=""
                                        class="w-100 h-100 object-fit-cover">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
                        <div class="col-xl-3 pb-4">

                            <div class="card cardMainImage h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2 cardText">
                                    <span>Registration Number:</span>
                                    <p class="mb-0">HDH6545</p>
                                </div>
                                <img src="<?= $this->params['baseurl'] ?>/images/prof.png"
                                    class="card-img-top object-fit-cover w-100" alt="">


                            </div>
                        </div>
                        <div class="col-xl-3 pb-4">

                            <div class="card cardMainImage h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2 cardText">
                                    <span>PAN Number:</span>
                                    <p class="mb-0">HDH6545</p>
                                </div>
                                <img src="<?= $this->params['baseurl'] ?>/images/prof.png"
                                    class="card-img-top object-fit-cover w-100" alt="">


                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="con" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="businessMainParent">
                        <table class="table w-100 border-0 border_o d-inline-block py-3 bg-white">
                            <tbody class="tbody-leads sighting-leads py-5 w-100">
                                <tr>
                                    <td style="width: 17%;">Operated Park:</td>
                                    <td style="width: 83%;">
                                        <p>oindrila.pharma</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>About Business:</td>
                                    <td>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                            Lorem Ipsum has been the industry's standard dummy text ever since the
                                            1500s, when an unknown printer took a galley of type and scrambled it to
                                            make a type specimen book. It has survived not only five centuries, </p>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-xl-3 pb-4">

                                <div class="card cardMainImage h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-3 cardText">
                                        <span>Registration Number:</span>
                                        <p class="mb-0">HDH6545</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2 cardText">
                                        <span>PAN Number:</span>
                                        <p class="mb-0">HDH6545</p>
                                    </div>
                                    <img src="<?= $this->params['baseurl'] ?>/images/prof.png"
                                        class="card-img-top object-fit-cover w-100" alt="">


                                </div>
                            </div>
                            <div class="col-xl-3 pb-4">

                                <div class="card cardMainImage h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-3 cardText">
                                        <span>PAN Number:</span>
                                        <p class="mb-0">HDH6545</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2 cardText">
                                        <span>PAN Number:</span>
                                        <p class="mb-0">HDH6545</p>
                                    </div>
                                    <img src="<?= $this->params['baseurl'] ?>/images/prof.png"
                                        class="card-img-top object-fit-cover w-100" alt="">


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="fivcont" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="overviewDataParent">
                                <table class="table w-100 border-0 border_o d-inline-block py-3 bg-white">
                                    <tbody class="tbody-leads sighting-leads py-5 w-100">
                                        <tr>
                                            <td style="width: 60%;">Business Name:</td>
                                            <td style="width: 50%;">
                                                <p>Shivsakti</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Address:</td>
                                            <td>
                                                <p>Noida sector 62</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number: </td>
                                            <td>
                                                <p>8825317553</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Legal entity Email:</td>
                                            <td>
                                                <p>annu@gmail.com</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Category:</td>
                                            <td>
                                                <p>Safari Tour Operator</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>PAN Number:</td>
                                            <td>
                                                <p>DFY1533SF</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Approved Status:</td>
                                            <td>
                                                <p>Yes</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="identification-photo">
                                <p class="mb-1">Pan Photo: </p>
                                <a href="/">
                                    <img src="<?= $this->params['baseurl'] ?>/images/pancard.png" alt=""
                                        class="w-100 h-100 object-fit-cover">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="svencont" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="userKYC">
                        <div class="row">
                            <div class="col-xl-12">
                                <table class="table w-100 border-0 border_o d-inline-block pt-3 mb-0">
                                    <tbody class="tbody-leads sighting-leads py-5 w-100">
                                        <tr>
                                            <td style="width: 60%;">owner / Partner / Director Name:
                                            </td>
                                            <td style="width: 50%;">
                                                <p>oindrila.pharma</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number:</td>
                                            <td>
                                                <p>9090909090</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>WhatsApp Number:</td>
                                            <td>
                                                <p>9090909090</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email ID:</td>
                                            <td>
                                                <p>business@gmail.com</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email ID:</td>
                                            <td>
                                                <p>business@gmail.com</p>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>

                            <div class="col-xl-3 pb-4">
                                <div class="ver-im sec-ver-im card cardMainImage">
                                    <div class="ver-im-tx-title d-flex align-items-center gap-5 mb-2">
                                        <span>PAN Number:</span>
                                        <p class="mb-0">HDH6545</p>
                                    </div>
                                    <a href="" class="">
                                        <img src="<?= $this->params['baseurl'] ?>/images/prof.png" alt=""
                                            class="w-100 object-fit-cover">

                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-6 pb-4">
                                <div class="ver-im sec-ver-im card cardMainImage">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="ver-im-tx-title d-flex align-items-center gap-5 mb-2">
                                                <span>Aadhar Card Number:</span>
                                                <p class="mb-0">3415685654</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="ver-im sec-ver-im p-0">

                                                <a href="" class="">
                                                    <img src="<?= $this->params['baseurl'] ?>/images/prof.png" alt=""
                                                        class="w-100 object-fit-cover">

                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="ver-im sec-ver-im p-0">

                                                <a href="" class="">
                                                    <img src="<?= $this->params['baseurl'] ?>/images/prof.png" alt=""
                                                        class="w-100 object-fit-cover">

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="eighttcont" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="table-wrapper shadow-none rounded-0 pb-4">
                        <div class="table-responsive">
                            <div class="min-width-table">
                                <div id="w0" class="grid-view">
                                    <table class="table tablecustoms table-striped align-middle w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%;">#</th>
                                                <th>User Name</th>
                                                <th>Safari Operator</th>
                                                <th>Park</th>
                                                <th>Rating</th>
                                                <th>Review</th>
                                                <th>Flaged</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-key="838">
                                                <td>1</td>
                                                <td><img class="rounded profile-picture"
                                                        src="https://d2oqzs36p95tb4.cloudfront.net/user/profile/7498_google_avatar.jpg"
                                                        alt="" style="width:28px;"> Sahil Modi</td>
                                                <td>Kanha National Park</td>
                                                <td>Lorem ipsum is a dummy</td>
                                                <td>2</td>
                                                <td>Lorem ipsum is a dummy</td>
                                                <td>Lorem ipsum</td>
                                            </tr>
                                            <tr data-key="838">
                                                <td>1</td>
                                                <td><img class="rounded profile-picture"
                                                        src="https://d2oqzs36p95tb4.cloudfront.net/user/profile/7498_google_avatar.jpg"
                                                        alt="" style="width:28px;"> Sahil Modi</td>
                                                <td>Kanha National Park</td>
                                                <td>Lorem ipsum is a dummy</td>
                                                <td>2</td>
                                                <td>Lorem ipsum is a dummy</td>
                                                <td>Lorem ipsum</td>
                                            </tr>
                                            <tr data-key="838">
                                                <td>1</td>
                                                <td><img class="rounded profile-picture"
                                                        src="https://d2oqzs36p95tb4.cloudfront.net/user/profile/7498_google_avatar.jpg"
                                                        alt="" style="width:28px;"> Sahil Modi</td>
                                                <td>Kanha National Park</td>
                                                <td>Lorem ipsum is a dummy</td>
                                                <td>2</td>
                                                <td>Lorem ipsum is a dummy</td>
                                                <td>Lorem ipsum</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="ninetcont" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="table-wrapper shadow-none rounded-0 pb-4">
                        <div class="table-responsive">
                            <div class="min-width-table">
                                <div id="w0" class="grid-view">
                                    <table class="table tablecustoms table-striped align-middle w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%;">#</th>
                                                <th>Park</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr data-key="838">
                                                <td>1</td>
                                                <td>Lorem ipsum is a dummy</td>
                                                <td>
                                                    <div class="active-btn">
                                                        <a href="">ACTIVE</a>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- STATIC TABS NEW END HERE  -->








    <?php
$script = <<< JS

function organizefunction() {
	$('.btn_userarticle').on('click', function () {
        $('#organize-modal').modal('show')
		.find('#userstatusmodalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();
JS;
$this->registerJs($script);
?>