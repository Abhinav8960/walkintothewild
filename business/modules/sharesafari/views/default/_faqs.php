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
                    } ?>
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