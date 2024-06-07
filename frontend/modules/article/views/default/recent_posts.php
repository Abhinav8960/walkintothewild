<div class="recentpost_box mb-5 ">
    <div class="titlerescent pb-3">
        <h3>Recent Posts</h3>
    </div>
    <?php if ($recentposts) {
        foreach ($recentposts as $recentpost) { ?>
            <div class="recent-posts mb-4">
                <div class="row">
                    <div class="col-3">
                        <div class="postthumbnail">
                            <a href="/article/<?= $recentpost->slug ?>"><img src="<?= $this->params['baseurl'] ?>/img/Article1.jpg" alt="" class="w-100"></a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="posttitles">
                            <h6><a href="/article/<?= $recentpost->slug ?>"><?= $recentpost->title ?></a></h6>
                        </div>
                        <ul class="artical-info p-0 justify-content-start gap-1 mb-0">
                            <li class="d-flex align-items-center gap-2"><i class="far fa-comments"></i><a href="/article/<?= $recentpost->slug ?>"><?= count($recentpost->articlecomments) ?> Comments</a></li>
                        </ul>
                    </div>
                </div>
            </div>
    <?php }
    } ?>
</div>