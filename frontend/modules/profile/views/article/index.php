<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Article';
$this->params['title'] = $this->title;
?>
<section class="profile-wrapper">
    <div class="container mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['article' => 'active', 'user' => $user]) ?>
    </div>
</section>
<section>
    <div class="container ">
        <div class="row justify-content-center ">
            <div class="col-xxl-11 margin_bottomfooter">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card  card_bodyPadding">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;">Articles shared by <?= Yii::$app->user->identity->id == $user->id ? ' me' : $user->name ?></h6>
                                            <?php if (Yii::$app->user->identity->id == $user->id) { ?>
                                                <a class="follow_btn text-center mt-sm-0 " href="<?= Url::toRoute(['create']) ?>">Create Article</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if ($articles) {
                                        foreach ($articles as $article) {  ?>
                                            <div class="col-sm-6 col-lg-4 mb-5 " style="<?= $article->status == 1 ?: 'border: 2px solid red;' ?>">
                                                <div class="artical_cards h-100 position-relative">
                                                    <div class="image-box">
                                                        <?php if (Yii::$app->user->identity->id == $user->id) { ?>
                                                            <a class="join_btn updateBtn_artical text-center px-3 py-1" href="<?= Url::toRoute(['update', 'slug' => $article->slug]) ?>">Update</a>
                                                        <?php } ?>

                                                        <figure class="image"><a href="/article/<?= $article->slug ?>"><img src="<?= isset($article->banner_image) ? $article->bannerimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt=""></a>
                                                        </figure>
                                                    </div>
                                                    <div class="lower-content">
                                                        <h3><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $article->slug]) ?>"><?= $article->title ?> </a></h3>
                                                        <div class="artical-info justify-content-center">
                                                            <a href="<?= Url::toRoute(['/article/default/view', 'slug' => $article->slug, '#' => 'comment-wrapper-section']) ?>" style="color: #9C9C9C;"><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""> <?= $article->getArticlecomments()->where(['status' => 1])->count() ?> Comments</a>
                                                        </div>

                                                    </div>
                                                    <div class="link"><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $article->slug]) ?>"><i class="fa-solid fa-arrow-right"></i></a></div>
                                                </div>
                                            </div>
                                    <?php }
                                    } else {
                                        echo '<p class="px-3 mb-0">No Article Found!</p>';
                                    } ?>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>