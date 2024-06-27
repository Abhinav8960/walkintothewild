<h2 class="accordion-header d-lg-none" id="headingTwo">
    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        About Park
    </button>
</h2>
<div id="collapseTwo" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingTwo" data-bs-parent="#myTabContent">
    <div class="accordion-body height_set">
        <div class="about_content">
            <div class="safrititles pt-3 pb-0">
                <h5 class="">About <?= $model->title ?></h5>
            </div>
            <p>
                <?= $model->about_description ?>
            </p>
        </div>
    </div>
</div>