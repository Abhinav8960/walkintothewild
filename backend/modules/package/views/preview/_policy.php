<div class="row">
    <div class="col-lg-4 col-xl-4 col-xxl-3  mb-lg-0 mb-3">
        <div class="safri_tour safariChanges">
            <div class="topics_listing">
                <ul id="tabList">
                    <li><a class="tab-items active_safri" data-tab="tab21">
                            <div class="numparks">Terms Condtition</div><i class="fa-solid fa-chevron-right"></i>
                        </a></li>
                    <li><a class="tab-items " data-tab="tab25">
                            <div class="numparks">Date Change Policy </div><i class="fa-solid fa-chevron-right"></i>
                        </a></li>
                    <li><a class="tab-items " data-tab="tab26">
                            <div class="numparks">Refund Policy </div><i class="fa-solid fa-chevron-right"></i>
                        </a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xxl-9 col-xl-9">
        <div class="tab-content_tour active " id="tab21">
            <!-- Safari Parks content goes here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($package->package_terms_condtition) { ?>
                                <div class="itenary-title">
                                    <h6 class="fs-6 fw-bold pb-2">Terms & Condtition</h6>
                                </div>
                            <?php } ?>
                            <div class="itenary_text">
                                <p><?= $package->package_terms_condtition ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="tab-content_tour" id="tab25">
            <!-- Shared Safari content goes here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($package->date_change_policy) { ?>
                                <div class="itenary-title">
                                    <h6 class="fs-5 pb-2">Date Change Policy</h6>
                                </div>
                            <?php } ?>
                            <div class="itenary_text">
                                <p><?= $package->date_change_policy ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content_tour mb-4" id="tab26">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($package->refund_policy) { ?>
                                <div class="itenary-title">
                                    <h6 class="fs-5 pb-2">Refund Policy</h6>
                                </div>
                            <?php } ?>
                            <div class="itenary_text">
                                <p><?= $package->refund_policy ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>