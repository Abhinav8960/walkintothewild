<?php

use backend\assets\AppAsset;
use frontend\assets\FrontAppAsset;

FrontAppAsset::register($this);
AppAsset::register($this);

$webasset = $this->assetManager->getBundle('\backend\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Fixed Departure';
$this->params['title'] = $this->title;

?>


<?= $this->render('_upper_view', ['share_safari' => $share_safari]) ?>

<div class="row mb-5  mt-4 itenary_tabs">
    <div class="col-lg-9 col-xl-9 safartabs position-relative">
        <div class="tab-content accordion" id="myTabContent">
            <div class="tab-pane fade show active" id="Overview" role="tabpanel"
                aria-labelledby="home-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 mb-4">

                                <h6 class="pb-3">About Trip / Overview</h6>
                                <p><?= $share_safari->safari_plan ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="Itinerary" role="tabpanel"
                aria-labelledby="itinerary-tab"><?= $this->render('_overview', ['share_safari' => $share_safari]) ?>
            </div>
            <div class="tab-pane fade" id="Inclusions" role="tabpanel"
                aria-labelledby="profile-tab"><?= $this->render('_inclusion', ['share_safari' => $share_safari]) ?></div>
            <div class="tab-pane fade" id="Exclusions" role="tabpanel"
                aria-labelledby="contact-tab"><?= $this->render('_getting_there', ['share_safari' => $share_safari]) ?>
            </div>
            <div class="tab-pane fade" id="common" role="tabpanel"
                aria-labelledby="contact-tab"> <?= $this->render('_policy', ['share_safari' => $share_safari]) ?></div>
            <div class="tab-pane fade" id="FAQ" role="tabpanel"
                aria-labelledby="contact-tab"><?= $this->render('_faq', ['share_safari' => $share_safari, 'faqs' => $faqs]) ?></div>
        </div>
    </div>
</div>

<!-- <div class="comment-wrapper" id="comment-wrapper-section">
    <?= $this->render('_comment', [
        'share_safari' => $share_safari,
        'dataProvider' => $fixedProvider,
        'searchModel' => $fixedsearchModel,
    ]) ?>
</div> -->

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

const textContainer = $(".profile-description .text");
    const showMoreButton = $(".profile-description .show-more");
    const lineHeight = parseFloat(textContainer.css('line-height'));
    const threeLinesHeight = lineHeight * 3;

    if (textContainer.prop('scrollHeight') > threeLinesHeight) {
        textContainer.css({ 'max-height': threeLinesHeight + 'px', 'visibility': 'visible' });
        showMoreButton.css('display', 'inline-block');  
    } else {
        textContainer.css('visibility', 'visible');  
    }
    showMoreButton.click(function () {
        if (textContainer.css('max-height') === threeLinesHeight + 'px') {
            textContainer.css('max-height', 'none'); 
            $(this).text("See Less");
        } else {
            textContainer.css('max-height', threeLinesHeight + 'px');  
            $(this).text("See More");
        }
    });
JS;
$this->registerJs($script);
?>
<style>
    .tab-content {
        >.tab-pane {
            display: none;
        }

        >.active {
            display: block;
        }
    }
</style>