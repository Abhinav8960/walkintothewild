<div class="accordion" id="faqAccordion">
    <?php if ($faqs) {
        foreach ($faqs as $i => $faq) { ?>
            <div class="accordion-item faq_item m-2 p-2">
                <h2 class="accordion-header" id="heading<?= $i ?>">
                    <button class="accordion-button <?= $i === 0 ? '' : 'collapsed' ?>" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse<?= $i ?>"
                        aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>"
                        aria-controls="collapse<?= $i ?>">
                        <?= ($i + 1) . '. ' . htmlspecialchars($faq->question) ?>
                    </button>
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

<style>
   .faq_item .accordion-button {
    background-color: #CED2E0 !important;
}
</style>