<style>
    .accordion-item {
        margin-bottom: 1rem; /* Add space between each accordion item */
    }
</style>

<div class="accordion" id="faqAccordion">
    <?php if ($faqs) : ?>
        <?php $i = 0; ?>
        <?php foreach ($faqs as $faq) : ?>
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
        <?php endforeach; ?>
    <?php endif; ?>
</div>
