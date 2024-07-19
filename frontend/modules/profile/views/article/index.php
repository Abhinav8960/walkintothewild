<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Article';
$this->params['title'] = $this->title;
?>
<div class="container">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['article' => 'article', 'user' => $user]) ?>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">

            <div class="row">
                <div class="col-8">
                    <div class="card mt-2">
                        <div class="card-body">
                            <?php if (Yii::$app->user->identity->id == $user->id) { ?>
                                <button class="join_btn text-center mt-sm-0 mt-2 articleBtn" value="<?= Url::toRoute(['create']) ?>">Create Article</button>
                            <?php } ?>

                            <div class="row">
                                <?php if ($articles) {
                                    foreach ($articles as $article) {  ?>
                                        <div class="col-4 mb-5 mt-4">
                                            <div class="artical_cards h-100">
                                                <div class="image-box">
                                                    <button class="join_btn text-center mt-sm-0 mt-2 articleBtn" value="<?= Url::toRoute(['update', 'id' => $article->id]) ?>">Update</button>
                                                    <figure class="image"><a href="/article/<?= $article->slug ?>"><img src="<?= isset($article->banner_image) ? $article->bannerimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt=""></a>
                                                    </figure>
                                                </div>
                                                <div class="lower-content">
                                                    <h3><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $article->slug]) ?>"><?= $article->title ?> </a></h3>
                                                    <div class="artical-info justify-content-center">
                                                        <a href="<?= Url::toRoute(['/article/default/view', 'slug' => $article->slug, '#' => 'comment-wrapper-section']) ?>" style="color: #9C9C9C;"><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""> <?= $article->getArticlecomments()->where(['status' => 1])->count() ?> Comments</a>
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

                <div class="col-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mt-2">
                                <div class="card-body">
                                    <h5>Following</h5>
                                    <?php if ($followings = $user->userfollowings) {
                                        foreach ($followings as $following) { ?>
                                            <img src="<?= $following->user->profile_image <> '' ?  $following->user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle" width="25" height="25">
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mt-2">
                                <div class="card-body">
                                    <h5>Advertisement</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card mt-2">
                                <div class="card-body">
                                    <h5>Instagram</h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card mt-2 mb-2">
                                <div class="card-body">
                                    <h5>Organized Shared Safari <?= count($model) ?></h5>
                                    <?php if ($model) {
                                        foreach ($model as $share_safari) {
                                    ?>
                                            <div class="col-6 mb-4 padding_righ">
                                                <div class="sharesafri-card">
                                                    <div class="flotingdate">
                                                        <div class="icons text-center">
                                                            <p class="mb-0"><?= date('M', strtotime($share_safari->start_date)) ?></p>
                                                            <p class="mb-0"><?= date('d', strtotime($share_safari->start_date)) ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="shareimg">
                                                        <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug]) ?>"><img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
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
                                                                    <h6 class="number-safari"><?= $share_safari->share_seat ?></h6>
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
                                                                    <?php if ($interests = $share_safari->getIntrested()->where(['status' => 1])->limit(3)->all()) {
                                                                        $count = $share_safari->getIntrested()->count();
                                                                        $avatar_count = 3;
                                                                        foreach ($interests as $interest) {
                                                                    ?>
                                                                            <img src="<?= $interest->user && $interest->user->avatar <> '' ? $interest->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                                        <?php
                                                                        };
                                                                        $count = $share_safari->getIntrested()->count();
                                                                        $avatar_count = 3;
                                                                        $data = $count - $avatar_count;
                                                                        if ($data > 3) {  ?>
                                                                            <div class="roundes_countuser">
                                                                                <?= $data ?>+
                                                                            </div>
                                                                        <?php }
                                                                    } else { ?>
                                                                        <img src="<?= $share_safari->user && $share_safari->user->avatar <> '' ? $share_safari->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle">
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="safari text-center">
                                                                    <div class="joinsafari">

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

                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade _standard-text" id="article-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create Article</h1>
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
function articlefunction() {
	$('.articleBtn').on('click', function () {
        $('#article-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
articlefunction();
             
JS;
$this->registerJs($script);
?>