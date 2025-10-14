<?php

use common\models\GeneralModel;
use frontend\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\backend\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
// FrontAppAsset::register($this);
AppAsset::register($this);

$this->title = 'Package : ' . $package->package_name;
$this->params['title'] = $this->title;

if ($package->is_best_deal != 1) {
    $this->params['buttons'][] = Html::a(
        '<img src="' . $this->params['baseurl'] . '/img/best-deal.png" alt="Deal" height="20px" class="me-2"> Set As Best Deal',
        Url::toRoute(['set-as-best-deal', 'id' => $package->id]),
        [
            'class' => 'btn mt-2 btn-info',
            'style' => 'margin-right:5px',
            'data-confirm' => 'Are you sure you want to set this package as best deal?',
            'data-method' => 'post',
            'title' => 'Set As Best Deal'
        ]
    );
}

$this->params['buttons'][] =  Html::button(
    'Template',
    [
        'value' => Url::toRoute(['set-template', 'id' => $package->id]),
        'class' => 'btn mt-2 btn-success btn_template',
        'style' => 'margin-right:5px',
        'title' => 'Delete'
    ]
);

$this->params['buttons'][] =  Html::button(
    'Delete',
    [
        'value' => Url::toRoute(['delete', 'id' => $package->id]),
        'class' => 'btn mt-2 btn-danger btn_userarticle',
        'style' => 'margin-right:5px',
        'title' => 'Delete'
    ]
);

// $this->params['buttons'][] =  Html::button(
//     '<span class="fa-stack fa-sm">
//                 <i class="fa fa-certificate fa-stack-2x"></i>
//                 <i class="fa fa-tag fa-stack-1x fa-inverse"></i>
//             </span> Platform Discount',
//     [
//         'value' => Url::toRoute(['platform-discount', 'id' => $package->id]),
//         'class' => 'btn mt-2 discountPopup',
//         'style' => 'background-color:#f7f5b2; color:#ed8739; margin-right:5px',
//         'title' => 'Platform Discount'
//     ]
// );

if ($package->popular_package != 1) {
    $this->params['buttons'][] = Html::a('Mark As Popular', [Url::toRoute(['mark-as-popular', 'id' => $package->id])], ['class' => 'btn mt-2 btn-orange', 'title' => 'Mark as Popular']);
} else {
    $this->params['buttons'][] = Html::a('Remove As Popular', [Url::toRoute(['remove-popular', 'id' => $package->id])], ['class' => 'btn mt-2 btn-danger', 'title' => 'Remove Popular']);
}


?>


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
            <div class="tab-pane fade accordion-item mb-3" id="faq-tab-pane" role="tabpanel" aria-labelledby="faq-tab" tabindex="0">
                <h2 class="accordion-header d-lg-none" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        FAQ
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse bg-set collapse d-lg-block" aria-labelledby="headingFive" data-bs-parent="#myTabContent">
                    <div class="accordion-body height_set">
                        <?= $this->render('_faq', ['faqs' => $faqs, 'package' => $package]) ?>
                    </div>
                </div>
                <!-- Rendered on 2024-07-09 13:16:37 -->
            </div>
        </div>


    </div>
    <?php if ($package->packagegallery) {
        $galleries = $package->packagegallery;
    ?>
        <div class="col-xl-3 col-lg-3 mb-5 pb-4">
            <div class="request_quote">
                <div class="request_quote mt-4">
                    <button class="intested_btn interestBtn d-flex justify-content-between" value="#" style="background-color: var(--background-primary) !important;">
                        Photo Gallery <span>10</span></button>
                    <div class="interst_wrapper p-0 bg-white">
                        <div class="photoSlider owl-carousel owl-theme">
                            <?php foreach ($galleries as $gallery) { ?>
                                <div class="items_img">
                                    <img src="<?= isset($gallery->image) ? $gallery->imagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" width="100%">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="col-12 mt-0">
        <?= $this->render('_comment', [
            'package' => $package,
            'dataProvider' => $commentProvider,
            'searchModel' => $commentsearchModel,
        ]) ?>
    </div>
</div>

<div class="modal fade _standard-text" id="organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail for Delete</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='userstatusmodalContent'></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade _standard-text" id="discount-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Platform Discount</h1>
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='discountContent'></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade _standard-text" id="template-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Template</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='templatemodalContent'></div>
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

function discount() {
	$('.discountPopup').on('click', function () {
        $('#discount-modal').modal('show')
		.find('#discountContent')
		.load($(this).attr('value'));
	});
}
discount();


function templatefunction() {
	$('.btn_template').on('click', function () {
        $('#template-modal').modal('show')
		.find('#templatemodalContent')
		.load($(this).attr('value'));
	});
}
templatefunction();

JS;
$this->registerJs($script);
?>
<style>
    .disclaimer {
        top: 2375px;
        left: 303px;
        width: 687px;
        height: 148px;
        /* UI Properties */
        text-align: left;
        font: normal normal normal 16px/25px Roboto;
        letter-spacing: 0px;
        color: #151C2C;
        opacity: 1;


    }
</style>