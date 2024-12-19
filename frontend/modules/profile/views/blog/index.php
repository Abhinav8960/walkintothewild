<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Blog';
$this->params['title'] = $this->title;
?>
<section class="profile-wrapper">
    <div class="container-lg mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['blog' => 'active', 'user' => $user]) ?>
    </div>
</section>
<?php if (Yii::$app->user->identity) { ?>
    <section>
        <div class="container-lg " id="profile_container">
            <div class="row justify-content-center ">
                <div class="col-xxl-11 margin_bottomfooter">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card  card_bodyPadding">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between flex-wrap align-items-center mb-3">
                                                <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;"><?= isset($blogs) ? count($blogs) : '' ?> Blogs shared by <?= Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id ? ' me' : $user->name ?></h6>
                                                <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id) { ?>
                                                    <a class="parkrevieBtn text-center mt-sm-0 mt-2" href="<?= Url::toRoute(['create']) ?>">Create Blog</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php if ($blogs) {
                                            foreach ($blogs as $blog) {  ?>
                                                <div class="col-sm-6 col-lg-4 mb-5 ">
                                                    <div class="artical_cards h-100 position-relative" style="<?= $blog->status == 1 ?: 'border: 1px solid red;' ?>">
                                                        <div class="image-box">
                                                            <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id) { ?>
                                                                <a class="join_btn updateBtn_artical text-center px-3 py-1" href="<?= Url::toRoute(['update', 'slug' => $blog->slug]) ?>">Update</a>
                                                            <?php } ?>

                                                            <figure class="image"><a href="<?= Url::toRoute(['view', 'slug' => $blog->slug, 'user_handle' => $user->user_handle]) ?>"><img src="<?= isset($blog->banner_image) ? $blog->bannerimagepath : $this->params['baseurl'] . '/img/articalbig.png' ?>" alt=""></a>
                                                            </figure>
                                                        </div>
                                                        <div class="lower-content">
                                                            <ul class="artical-info ">
                                                                <li><i class="fa-solid fa-user"></i><a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user->user_handle]) ?>"><?= isset($blog->user) ? $blog->user->name : '' ?></a></li>

                                                            </ul>
                                                            <h3><a href="<?= Url::toRoute(['view', 'slug' => $blog->slug, 'user_handle' => $user->user_handle]) ?>"><?= $blog->title ?> </a></h3>
                                                            <div class="artical-info justify-content-center">
                                                                <a href="<?= Url::toRoute(['/profile/blog/view', 'slug' => $blog->slug, 'user_handle' => $user->user_handle, '#' => 'comment-wrapper-section']) ?>" style="color: #9C9C9C;"><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""> <?= $blog->getBlogcomments()->where(['parent_id' => null, 'status' => 1, 'is_deleted' => 0])->count() ?> Comments</a>

                                                                <span style="color: #9C9C9C;"><i class="fa-solid fa-calendar-days me-1" style="color:#f9d600;"></i><?= date('M d, Y', strtotime($blog->blog_date)) ?></span>
                                                            </div>


                                                        </div>
                                                        <div class="link"><a href="<?= Url::toRoute(['view', 'slug' => $blog->slug, 'user_handle' => $user->user_handle]) ?>"><i class="fa-solid fa-arrow-right"></i></a></div>
                                                    </div>
                                                </div>
                                        <?php }
                                        } else {
                                            echo '<p class="px-3 mb-0">No Blog Found!</p>';
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
<?php } else { ?>

    <div class="container-lg" id="profile_container">
        <div class="row justify-content-center">
            <div class="col-xxl-11 margin_bottomfooter">
                <div class="card position-relative" style="min-height: 350px;">
                    <div class="card-body">
                        <div class="withoutlogedin">
                            <h6 class="fs-6 fw-bold">Blogs</h6>
                        </div>

                        <div class="logininfo text-center">
                            <h6>Please log in to view the Blog <br>information.</h6>
                            <div class="viewAllreview">
                                <a href="/site/login?authclient=google&referrer=<?= Url::toRoute(['/profile/blog/index', 'user_handle' => $user->user_handle]) ?>">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php
$script = <<< JS
         var loc= window.location.href;
       
            $('html, body').animate({
                    'scrollTop' : $("#profile_container").position().top - 180
            });
           
 JS;
$this->registerJs($script);
?>