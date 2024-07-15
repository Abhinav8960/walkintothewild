<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Profile';
$this->params['title'] = $this->title;
?>


<!-- <img src="<?= $this->params['baseurl'] ?>/img/slideeee.png" class="rounded-circle mb-3" style="width: 150px;" alt="Avatar" />

<h5 class="mb-2"><strong>John Doe</strong></h5>
<p class="text-muted">Web designer <span class="badge bg-primary">PRO</span></p>

<div class="panel panel-primary tabs-style-2">
    <?= $this->render('tablist', ['profile' => 'active']) ?>
    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <?= $this->render('profile') ?>
            </div>
        </div>
    </div>
</div> -->


<div class="container">
    <div class="card overflow-hidden">
        <div class="card-body p-0">
            <img src="https://www.bootdey.com/image/1352x300/FF00FF/000000" alt="" class="img-fluid">
            <div class="row align-items-center">
                <div class="col-lg-4 order-lg-1 order-2">
                    <div class="d-flex align-items-center justify-content-around m-4">
                        <div class="text-center">
                            <i class="fa fa-user fs-6 d-block mb-2"></i>
                            <p class="mb-0 fs-4">Followers</p>
                        </div>
                        <div class="text-center">
                            <i class="fa fa-check fs-6 d-block mb-2"></i>
                            <p class="mb-0 fs-4">Following</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-n3 order-lg-2 order-1">
                    <div class="mt-n5">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <div class="linear-gradient d-flex align-items-center justify-content-center rounded-circle" style="width: 110px; height: 110px;" ;="">
                                <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden" style="width: 100px; height: 100px;" ;="">
                                    <img src="<?= Yii::$app->user->identity && Yii::$app->user->identity->avatar <> '' ? Yii::$app->user->identity->avatar : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="w-100 h-100">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="fs-5 mb-0 fw-semibold"><?= Yii::$app->user->identity->name ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-last">
                    <div class="sociel_icons ps-3">
                        <?php
                        $shared_url = urlencode(Url::to('', true));
                        ?>
                        <ul>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                            </li>
                            <li><a href="https://wa.me/?text=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                            </li>
                            <li><a href="https://twitter.com/intent/tweet?url=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-x-twitter"></i></a>
                            </li>
                            <li><a href="https://www.instagram.com/?url=<?= urlencode($shared_url) ?>" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <?= $this->render('tablist', ['profile' => 'active']) ?>
        </div>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">
            <div class="card">
                <div class="card-body">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                    Perspiciatis maxime sunt mollitia modi voluptatum laboriosam aut quas beatae ratione illum repellendus,
                    dolores voluptas labore doloribus obcaecati temporibus?
                    Aspernatur excepturi tenetur quidem id.
                    Harum maiores cupiditate exercitationem non laudantium soluta, animi veniam officia!
                    Necessitatibus iure doloribus sed quam, quae mollitia possimus id aspernatur repudiandae veritatis deleniti eum eius laboriosam ad illo cumque, unde reiciendis veniam accusamus tenetur facere hic.
                    Quasi deleniti quibusdam iusto aspernatur harum odio unde repudiandae cupiditate, accusantium porro soluta temporibus dolorum eos cum itaque expedita voluptates dolore maxime deserunt rerum.
                    Culpa odit et quam natus qui cumque dolor laboriosam atque provident, laudantium tenetur dignissimos, consequatur minima tempore dolores.
                    Officiis quia quibusdam enim autem, corporis accusamus tempore sed temporibus optio delectus cupiditate vel voluptas!
                </div>
            </div>
        </div>
    </div>
</div>