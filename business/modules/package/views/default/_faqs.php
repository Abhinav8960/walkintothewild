<div class="card mt-2">
    <div class="card-body">
        <div class="row pt-0">
            <div class="col-12">
                <div class="accordion" id="accordionExample">
                    <?php if ($faqs) {
                        foreach ($faqs as $i => $faq) { ?>
                            <div class="accordion-item faq_item mt-2">
                                <h2 class="accordion-header" id="heading<?= $i ?>">
                                    <div class="accordion-button <?= $i === 0 ? '' : 'collapsed' ?> custom-header" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse<?= $i ?>"
                                        aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>"
                                        aria-controls="collapse<?= $i ?>">
                                        <?= ($i + 1) . '. ' . htmlspecialchars($faq->question) ?>
                                    </div>
                                </h2>
                                <div id="collapse<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>"
                                    aria-labelledby="heading<?= $i ?>" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p><?= nl2br(htmlspecialchars($faq->answer)) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else {  ?>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item faq_item mt-2">
                                <h2 class="accordion-header" id="headingTwo">
                                    <div class="accordion-button collapsed  custom-header" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Are meals included in the Package?
                                    </div>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php if ($package->meals == 'Included') {  ?>
                                            <p> Yes: Meals are included and will be provided as per the itinerary.</p>
                                        <?php } else { ?>
                                            <p> No: Meals are not included; it will be charged additionally.</p>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item faq_item mt-2">
                                <h2 class="accordion-header" id="headingThree">
                                    <div class="accordion-button collapsed  custom-header" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Does the Package include transport to and from the resort?
                                    </div>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php

                                        if ($package->pickanddrop == 'Included') {
                                        ?>
                                            <p>Yes: Transport to and from the resort is included in the Package.
                                            </p>
                                            <?php } else {
                                            if ($package->template_code == 1) { ?>
                                                <p> No: Transport is not included; you will need to arrange your own.</p>
                                            <?php } else { ?>
                                                <p> No: Arrange your own or pick & drop additional from operator.</p>

                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item faq_item mt-2">
                                <h2 class="accordion-header" id="headingFour">
                                    <div class="accordion-button collapsed  custom-header" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Are accommodation arrangements included in the Package?
                                    </div>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php

                                        if ($package->accomodationIncludes == 'Included') {
                                        ?>
                                            <p>Yes: Accomodation is included.
                                            </p>
                                        <?php } else { ?>
                                            <p>No: Accomodation is not included.</p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .faq_item .accordion-button {
        background-color: #D7D7D8 !important;
        padding: 13px;
    }
</style>