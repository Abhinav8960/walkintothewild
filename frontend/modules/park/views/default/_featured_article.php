<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="title_web">
                <h2>ARTICLES AND TIPS</h2>
            </div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-4  gx-xxl-5 gx-lg-4">
        <?php if ($featured_articles) {
            foreach ($featured_articles as $featured_article) { ?>
                <div class="col mb-5">
                    <div class="artical_cards h-100">
                        <div class="image-box">
                            <figure class="image"><a href="/article/<?= $featured_article->slug ?>"><img src="<?= isset($featured_article->feature_image) ? $featured_article->featureimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt=""></a>
                            </figure>
                        </div>
                        <div class="lower-content">
                            <ul class="artical-info ">
                                <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href=""><?= isset($featured_article->articleAuthor) ? $featured_article->articleAuthor->author_name : '' ?></a></li>
                                <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href=""><?= count($featured_article->articlecomments) ?> Comments</a></li>
                            </ul>
                            <h3><a href="/article/<?= $featured_article->slug ?>"><?= $featured_article->title ?> </a></h3>

                        </div>
                        <div class="link"><a href="/article/<?= $featured_article->slug ?>"><i class="fa-solid fa-arrow-right"></i></a></div>
                    </div>
                </div>
        <?php  }
        } ?>
    </div>
</div>