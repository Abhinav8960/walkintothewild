    <!-- div -->
    <div class="card mg-b-20" id="tabs-style2">
        <div class="card-body">
            <div class="main-content-label mg-b-5">
                <?= $model->register_comapany_name ?>
            </div>

            <div class="btn-delet float-end py-2">
                <button class="btn_userarticle" style="background:#F7BF39 !important;color:black !important;padding: 10px 16px !important; border:0; border-radius:10px" value="<?= \yii\helpers\Url::toRoute(['/operator/safari-operator/delete', 'id' => $model->id]) ?>"><i class="fas fa-trash me-1"></i>Delete</button>
            </div>
            <div class="row mt-2">
                <div class="col-2">
                    <div class="card">
                        <div class="ps-4 pt-4 pe-3 pb-4">
                            <div class="">
                                <h6 class="mb-2 tx-12 ">Shared Safari</h6>
                            </div>
                            <div class="pb-0 mt-0">
                                <div class="d-flex">
                                    <h4 class="tx-20 font-weight-semibold mb-2"><?= isset($model->safaricount) ? $model->safaricount : ''; ?></h4>
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
                                    <h4 class="tx-20 font-weight-semibold mb-2"><?= isset($model->sharedsafaricount) ? $model->sharedsafaricount : ''; ?></h4>
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
                                    <h4 class="tx-20 font-weight-semibold mb-2"> <?= isset($model->packagecount) ? $model->packagecount : ''; ?></h4>
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
                                    <h4 class="tx-20 font-weight-semibold mb-2"><?= isset($model->quotescount) ? $model->quotescount : ''; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class=" tab-menu-heading">
        <div class="tabs-menu1">
            <!-- Tabs -->
            <ul class="nav panel-tabs main-nav-line">
                <li><a href="/operator/safari-operator/view?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'overview' ? 'active' : '' ?>">Overview</a></li>
                <li><a href="/operator/safari-operator/quote?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'quote' ? 'active' : '' ?>">Get a Free Quote</a></li>
                <!-- <li><a href="/operator/safari-operator/sharedsafari?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'sharedsafari' ? 'active' : '' ?>">Shared Safari</a></li> -->
                <li><a href="/operator/safari-operator/review?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'review' ? 'active' : '' ?>">User Review</a></li>
                <!-- <li><a href="/operator/safari-operator/follower?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'follower' ? 'active' : '' ?>">Follower</a></li> -->
                <li><a href="/operator/safari-operator/registration-details?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'registration-details' ? 'active' : '' ?>">Registration Details</a></li>
                <li><a href="/operator/safari-operator/business-details?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'business-details' ? 'active' : '' ?>">Business Details</a></li>
                <li><a href="/operator/safari-operator/bank-details?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'bank-details' ? 'active' : '' ?>">Bank Details</a></li>
                <li><a href="/operator/safari-operator/userkyc-details?id=<?= $model->id ?>" class="nav-link <?= $active_navbar == 'userkyc-details' ? 'active' : '' ?>">User Kyc Details</a></li>

            </ul>
        </div>
    </div>

    <div class="modal fade _standard-text" id="organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail for Delete</h1>
                    <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
                </div>
                <div class="modal-body px-2 pt-0">
                    <div id='userstatusmodalContent'></div>
                </div>
            </div>
        </div>
    </div>

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