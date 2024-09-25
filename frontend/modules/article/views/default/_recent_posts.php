<div class="recentpost_box mb-5 ">
    <div class="titlerescent pb-3">
        <h3>Recent Posts</h3>
    </div>
    <div class="row">
        <?php

        use yii\helpers\Url;

        if ($recentposts) {
            foreach ($recentposts as $recentpost) { ?>
                <div class="col-lg-12 col-sm-6">
                    <div class="recent-posts mb-4">
                        <div class="row">
                            <div class="col-3  col-md-3 col-lg-4">
                                <div class="postthumbnail">
                                    <a href="<?= Url::toRoute(['/article/default/view', 'slug' => $recentpost->slug]) ?>"><img src="<?= isset($recentpost->banner_image) ? $recentpost->bannerimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt="" class="w-100"></a>
                                </div>
                            </div>
                            <div class="col-9 col-md-9 col-lg-8">
                                <div class="posttitles">
                                    <h6><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $recentpost->slug]) ?>"><?= $recentpost->title ?></a></h6>
                                </div>
                                <ul class="artical-info p-0 justify-content-start gap-1 mb-0">
                                    <li class="d-flex align-items-center gap-2"><i class="far fa-comments"></i><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $recentpost->slug]) ?>"><?= $recentpost->getArticlecomments()->where(['parent_id' => null, 'status' => 1, 'is_deleted' => 0])->count() ?> Comments</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

        <?php }
        } ?>
    </div>

</div>