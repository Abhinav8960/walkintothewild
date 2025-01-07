<div class="row px-lg-0 px-3 pt-lg-0 pt-3">
    <div class="col-lg-4 col-md-4 col-xl-4 col-xxl-3  mb-lg-0 mb-3">
        <div class="safri_tour sticky-top border-0">
            <div class="topics_listing px-0 safariChanges pt-0">
                <ul id="tabList">
                    <li><a class="tab-items active_safri" data-tab="tab21">
                            <div class="numparks">Terms Condtition</div><i class="fa-solid fa-chevron-right"></i>
                        </a></li>
                    <!-- <li><a class="tab-items " data-tab="tab22">
                            <div class="numparks">Privacy Policy</div><i class="fa-solid fa-chevron-right"></i>
                        </a></li>
                    <li><a class="tab-items" data-tab="tab23">
                            <div class="numparks">Change Policy </div><i class="fa-solid fa-chevron-right"></i>
                        </a></li>
                    <li><a class="tab-items " data-tab="tab24">
                            <div class="numparks">What You Must Carry </div><i class="fa-solid fa-chevron-right"></i>
                        </a></li> -->
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
    <div class="col-lg-8 col-md-8 col-xxl-9 col-xl-8 pt-lg-0 pt-2 pb-md-0 pb-3">
        <div class="tab-content_tour active " id="tab21">
            <!-- Safari Parks content goes here -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="itenary-title">
                                <h6 class="fs-6 fw-bold pb-2">Terms & Condtition</h6>
                            </div>
                            <?php if ($share_safari->share_safari_terms_condtition) { ?>
                                <div class="itenary_text">
                                    <p><?= $share_safari->share_safari_terms_condtition ?></p>
                                </div>
                            <?php } else {  ?>
                                <div class="itenary_text">
                                    <p>The organizer has not provided any information.</p>
                                </div>
                            <?php } ?>
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
                            <?php if ($share_safari->privacy_policy) { ?>
                                <div class="itenary-title">
                                    <h6 class="fs-5 pb-2">Privacy Policy</h6>
                                </div>
                            <?php } ?>
                            <div class="itenary_text">
                                <p><?= $share_safari->privacy_policy ?></p>
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
                            <?php if ($share_safari->change_policy) { ?>
                                <div class="itenary-title">
                                    <h6 class="fs-5 pb-2">Change Policy</h6>
                                </div>
                            <?php } ?>
                            <div class="itenary_text">
                                <p><?= $share_safari->change_policy ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content_tour " id="tab24">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if ($share_safari->what_you_must_carry) { ?>
                                <div class="itenary-title">
                                    <h6 class="fs-5 pb-2">What You Must Carry</h6>
                                </div>
                            <?php } ?>
                            <div class="itenary_text">
                                <p><?= $share_safari->what_you_must_carry ?></p>
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
                            <div class="itenary-title">
                                <h6 class="fs-5 pb-2">Date Change Policy</h6>
                            </div>
                            <?php if ($share_safari->date_change_policy) { ?>
                                <div class="itenary_text">
                                    <p><?= $share_safari->date_change_policy ?></p>
                                </div>
                            <?php } else {  ?>
                                <div class="itenary_text">
                                    <p>The organizer has not provided any information.</p>
                                </div>
                            <?php } ?>
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
                            <div class="itenary-title">
                                <h6 class="fs-5 pb-2">Refund Policy</h6>
                            </div>
                            <?php if ($share_safari->refund_policy) { ?>
                                <div class="itenary_text">
                                    <p><?= $share_safari->refund_policy ?></p>
                                </div>
                            <?php } else {  ?>
                                <div class="itenary_text">
                                    <p>The organizer has not provided any information.</p>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>