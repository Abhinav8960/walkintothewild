<div class="recentpost_box mb-5 ">
    <div class="titlerescent pb-3">
        <h3>Recent Posts</h3>
    </div>
    <?php if ($recentposts) {
        foreach ($recentposts as $recentpost) { ?>
            <div class="recent-posts mb-4">
                <div class="row">
                    <div class="col-4">
                        <div class="postthumbnail">
                            <a href="#"><img src="<?= isset($recentpost->feature_image) ? $recentpost->featureimagepath : $this->params['baseurl'] . '/img/Blog1.jpg' ?>" alt="" class="w-100"></a>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="posttitles">
                            <h6><a href="#"><?= $recentpost->title ?></a></h6>
                        </div>
                        <ul class="artical-info p-0 justify-content-start gap-1 mb-0">
                            <li class="d-flex align-items-center gap-2"><i class="far fa-comments"></i><a href="#"><?= count($recentpost->blogcomments) ?> Comments</a></li>
                        </ul>
                    </div>
                </div>
            </div>
    <?php }
    } ?>
</div>