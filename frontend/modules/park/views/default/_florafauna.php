<h2 class="accordion-header d-lg-none" id="headingThree">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        FLORA & FAUNA
    </button>
</h2>
<div id="collapseThree" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingThree" data-bs-parent="#myTabContent">
    <div class="accordion-body">
        <div class="about_content">
            <?php if ($model->florafauns) {
                foreach ($model->florafauns as $florafaun) { ?>
                    <div class="safrititles py-3">
                        <h5 class=""><?= $florafaun->title ?></h5>
                    </div>
                    <p>
                        <?= $florafaun->description ?>
                    </p>
            <?php }
            } ?>
        </div>
    </div>
</div>