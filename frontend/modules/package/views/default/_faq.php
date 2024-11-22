<div class="accordion inner_accordion" id="faqAccordion">
    <?php if ($faqs) {  ?>
        <?php $i = 0; ?>
        <?php foreach ($faqs as $faq) {  ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?= $i ?>">
                    <button class="accordion-button <?= $i === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $i ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $i ?>">
                        <?= ($i + 1) . '. ' . htmlspecialchars($faq->question) ?>
                    </button>
                </h2>
                <div id="collapse<?= $i ?>" class="accordion-collapse collapse <?= $i === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $i ?>" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p><?= nl2br(htmlspecialchars($faq->answer)) ?></p>
                    </div>
                </div>
            </div>
            <?php $i++; ?>

        <?php }
    } else {  ?>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Are meals included in the Package?
                    </button>
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
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Does the Package include transport to and from the resort?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?php

                        if ($package->pickanddrop == 'Included') {
                        ?>
                            <p>Yes: Transport to and from the resort is included in the Package.
                            </p>
                        <?php } else { ?>
                            <p> No: Transport is not included; you will need to arrange your own.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Are accommodation arrangements included in the Package?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <p>For checking these things go to the inclusion tab.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<style>
    .accordion-item {
        margin-bottom: 1rem;
        /* Add space between each accordion item */
    }
</style>