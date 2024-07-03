<?php


/* @var $this yii\web\View */

use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\GeneralModel;
use frontend\models\ArticleSearch;
use yii\helpers\Url;

$this->title = 'Share Safari';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::SHARE_SAFARI;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
$recentposts = ArticleSearch::recentpost();


?>

<section class="banner_section-inner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/banner-share.png" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/banner-share.png" class="d-block w-100 " alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1>Join or Organize a Sharing Safari</h1>
                        <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                            Their Adventures</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="articals_wrapper py-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-4">
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-lg-4 col-xl-3 col-xxl-2  mb-4">
                <?= $this->render('filter_search', ['searchModel' => $searchModel]) ?>
                <div class="advertisment pt-5 ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box-2">

                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9 col-xxl-10">
                <div class="row ">
                    <div class="col-12  mb-xl-5 mb-3">
                        <div class="row justify-content-between">
                            <div class="col-md-5">
                                <div class="left_search position-relative">
                                    <input type="text" class="form-control" placeholder="Search by name, date...">
                                    <div class="icons-serch">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-0 mt-3">
                                <div class="right_button float-md-end">
                                    <button class="btn_newsafari organizeBtn" value="<?= Url::toRoute(['/sharedsafari/default/organize-safari']) ?>">+ Organize a New
                                        Safari</button>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-12">
                        <div class="topfilter d-flex justify-content-between align-items-center flex-wrap w-100">
                            <div class="left_text">
                                <p>There are currently <strong>121</strong> active shared safaris created by individuals</p>
                            </div>
                            <div class="right-select">
                                <div class="input_check pb-0">

                                    <select class="form-select mb-3" aria-label="Default select example">
                                        <option selected>Sort By: Created Recently</option>
                                        <option value="1">January</option>
                                        <option value="2">Febraury</option>
                                        <option value="3">March</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-lg-3 gx-lg-4 gx-xxl-5">

                    <?php if ($models = $dataProvider->models) {
                        foreach ($models as $share_safari) {
                    ?>

                            <div class="col mb-4 padding_right">
                                <div class="sharesafri-card">
                                    <div class="flotingdate">
                                        <div class="icons text-center">
                                            <p class="mb-0"><?= date('M', strtotime($share_safari->start_date)) ?></p>
                                            <p class="mb-0"><?= date('d', strtotime($share_safari->start_date)) ?></p>
                                        </div>
                                    </div>
                                    <div class="shareimg">
                                        <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><img src="<?= isset($share_safari->park) && isset($share_safari->park->logo) ? $share_safari->park->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
                                    </div>
                                    <div class="card_body">
                                        <div class="top_seats">
                                            <div class="safari d-flex justify-content-between ">
                                                <div class="safarinum d-flex gap-2 align-items-center ">
                                                    <p class="text_safari">SAFARI</p>
                                                    <h6 class="number-safari"><?= $share_safari->no_of_safari ?></h6>
                                                </div>
                                                <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                                                    <p class="text_safari">SEATS</p>
                                                    <h6 class="number-safari"><?= $share_safari->total_seat ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="titleDate">
                                            <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><?= $share_safari->park->title ?></a></h6>
                                            <div class="orgnizer">
                                                <p>Organized by: <strong><?= $share_safari->user->name ?></strong></p>
                                            </div>
                                        </div>
                                        <div class="footer_card row pb-2 px-2 align-items-center">
                                            <div class="col-6">
                                                <div class="users">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/dpmain.png" alt="">
                                                    <div class="roundes_countuser">
                                                        15+
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="safari text-center">
                                                    <div class="joinsafari">
                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/join', 'slug' => $share_safari->slug]) ?>">Join Safari</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>

    </div>

</section>

<section class="safariduring_sesons innerpage">
    <?= \frontend\widgets\FeatureParkWidget::widget() ?>
</section>



<div class="modal fade _standard-text" id="organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Organize a New Safari</h1>
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
function organizefunction() {
	$('.organizeBtn').on('click', function () {
        $('#organize-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();
             
JS;
$this->registerJs($script);
?>