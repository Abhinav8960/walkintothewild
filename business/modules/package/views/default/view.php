<?php

use business\assets\AppAsset;
use common\models\GeneralModel;
use frontend\assets\FrontAppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
FrontAppAsset::register($this);
AppAsset::register($this);

?>


<div class="d-flex justify-content-between align-items-center mt-5">
    <h3 class="mt-5">Package : <?= Html::encode($package->package_name) ?></h3>
    <div>
        <?= Html::a('<i class="fa-solid fa-copy" style="font-size:15px; margin-right:5px"></i>Copy', [Url::toRoute(['copy-package', 'id' => $package->id])], ['class' => 'btn mt-3', 'style' => 'background-color:#7B8191', 'title' => 'Copy']) ?>
        <?= Html::a('<i class="fa fa-edit" style="font-size:15px; margin-right:5px"></i>Edit', [Url::toRoute(['update', 'id' => $package->id])], ['class' => 'btn mt-3', 'style' => 'background-color:#F48270', 'title' => 'Edit']) ?>
    </div>
</div>


<?= $this->render('_upper_view', ['package' => $package]) ?>


<div class="row mb-5  mt-4 itenary_tabs">
    <div class="col-lg-9 col-xl-9 safartabs position-relative">
        <div class="tab-content accordion" id="myTabContent">
            <div class="tab-pane fade show active accordion-item mb-3" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                <h2 class="accordion-header d-lg-none" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">ITENARY</button>
                </h2>
                <div id="collapseOne" class="accordion-collapse bg-set collapse show  d-lg-block" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
                    <div class="accordion-body p-3">
                        <div class="col-lg-12 mb-3">
                            <div class="itenary-title">
                                <h6 class="fs-6 fw-bold pb-2">ABOUT TRIP / OVERVIEW</h6>
                            </div>
                            <div class="itenary_text">
                                <p><?= $package->package_description ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->render('_overview', ['package' => $package]) ?>
                <!-- Rendered on 2024-07-09 13:16:37 -->
            </div>

            <div class="tab-pane fade accordion-item mb-3" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <h2 class="accordion-header d-lg-none" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        INCLUSION
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse  bg-set d-lg-block" aria-labelledby="headingTwo" data-bs-parent="#myTabContent">
                    <div class="accordion-body height_set">
                        <?= $this->render('_inclusion', ['package' => $package]) ?>
                    </div>
                </div>
                <!-- Rendered on 2024-07-09 13:16:37 -->
            </div>
            <div class="tab-pane fade accordion-item mb-3" id="getting-there" role="tabpanel" aria-labelledby="howto-reach" tabindex="0">
                <h2 class="accordion-header d-lg-none" id="headingFour">
                    <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        GETTING THERE
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse bg-set collapse d-lg-block" aria-labelledby="headingFour" data-bs-parent="#myTabContent">
                    <div class="accordion-body height_set">
                        <?= $this->render('_getting_there', ['package' => $package]) ?>
                    </div>
                </div>
                <!-- Rendered on 2024-07-09 13:16:37 -->
            </div>
            <div class="tab-pane fade accordion-item mb-3" id="policy" role="tabpanel" aria-labelledby="howto-reach" tabindex="0">
                <h2 class="accordion-header d-lg-none" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        POLICY INFO
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse  bg-set collapse d-lg-block" aria-labelledby="headingFour" data-bs-parent="#myTabContent">
                    <div class="accordion-body height_set">
                        <?= $this->render('_policy', ['package' => $package]) ?>
                    </div>
                </div>
                <!-- Rendered on 2024-07-09 13:16:37 -->
            </div>

            <div class="tab-pane fade accordion-item mb-3" id="faq" role="tabpanel" aria-labelledby="howto-reach" tabindex="0">
                <h2 class="accordion-header d-lg-none" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        FAQs
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse  bg-set collapse d-lg-block" aria-labelledby="headingFive" data-bs-parent="#myTabContent">
                    <div class="accordion-body height_set">
                        <?= $this->render('_faqs', ['package' => $package, 'faqs' => $faqs]) ?>
                    </div>
                </div>
                <!-- Rendered on 2024-07-09 13:16:37 -->
            </div>

        </div>


    </div>

    <div class="col-lg-3 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4>Versions</h4>
                <hr>
                <div>
                    <?php if ($package->versions) {
                        foreach ($package->versions as $v) { ?>
                            <div><a href="<?= Url::toRoute(['view', 'id' => $v->id]) ?>">
                                    <?= $v->version ?>-<?= $v->statusLabel ?>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade _standard-text" id="organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail for Delete</h1>

            </div>
            <div class="modal-body px-2 pt-0">
                <div id='userstatusmodalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS

function organizefunction() {
	$('.btn_userarticle').on('click', function () {
        $('#organize-modal').modal('show')
		.find('#userstatusmodalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();
JS;
$this->registerJs($script);
?>
<style>
    .disclaimer {
        top: 2375px;
        left: 303px;
        width: 687px;
        height: 148px;
        text-align: left;
        font: normal normal normal 16px/25px Roboto;
        letter-spacing: 0px;
        color: #151C2C;
        opacity: 1;


    }
</style>