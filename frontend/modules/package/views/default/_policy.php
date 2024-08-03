<div class="row px-lg-0 px-3">
    <div class="col-lg-4 col-md-4 col-xl-4 col-xxl-3  mb-lg-0 mb-3">
        <div class="safri_tour sticky-top border-0">
            <div class="topics_listing px-0 safariChanges ">
                <ul id="tabList">
                    <li><a class="tab-items active_safri" data-tab="tab21">
                            <div class="numparks">Terms Condtition</div><i class="fa-solid fa-chevron-right"></i>
                        </a></li>
                    <li><a class="tab-items " data-tab="tab22">
                            <div class="numparks">Privacy Policy</div><i class="fa-solid fa-chevron-right"></i>
                        </a></li>
                    <li><a class="tab-items" data-tab="tab23">
                            <div class="numparks">Change Policy </div><i class="fa-solid fa-chevron-right"></i>
                        </a></li>
                    <li><a class="tab-items " data-tab="tab24">
                            <div class="numparks">What You Must Carry </div><i class="fa-solid fa-chevron-right"></i>
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
    <div class="col-lg-8 col-md-8 col-xxl-9 col-xl-9 pt-lg-0 pt-2 pb-md-0 pb-3">
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
        <div class="tab-content_tour" id="tab22">
            <!-- Safari Parks content goes here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($package->privacy_policy) { ?>
                                <div class="itenary-title">
                                    <h6 class="fs-5 pb-2">Privacy Policy</h6>
                                </div>
                            <?php } ?>
                            <div class="itenary_text">
                                <p><?= $package->privacy_policy ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content_tour" id="tab23">
            <!-- Safari Parks content goes here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($package->change_policy) { ?>
                                <div class="itenary-title">
                                    <h6 class="fs-5 pb-2">Change Policy</h6>
                                </div>
                            <?php } ?>
                            <div class="itenary_text">
                                <p><?= $package->change_policy ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content_tour " id="tab24">
            <div class="searchSafari_parks mb-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <?php if ($package->what_you_must_carry) { ?>
                                    <div class="itenary-title">
                                        <h6 class="fs-5 pb-2">What You Must Carry</h6>
                                    </div>
                                <?php } ?>
                                <div class="itenary_text">
                                    <p><?= $package->what_you_must_carry ?></p>
                                </div>
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