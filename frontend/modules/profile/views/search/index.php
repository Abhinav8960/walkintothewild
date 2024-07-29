<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Search Profile';
$this->params['title'] = $this->title;
?>

<div class="container pt-5 mt-5">
    <div class="row mt-2">
        <div class="col-12">
            <h6 class="fs-3 fw-bold mb-4">Search Profile</h6>
        </div>
    </div>
    <div class="row margin_bottomfooter">
        <?php foreach ($user_list as $user) { ?>
            <div class="col-md-3 mb-4">
                <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $user]);  ?>
            </div>
        <?php } ?>
    </div>
</div>

<style>
    .testimonial-card .card-up {
        height: 120px;
        overflow: hidden;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
    }

    .testimonial-card .avatar {
        width: 120px;
        margin-top: -60px;
        overflow: hidden;
        border: 5px solid #fff;
        border-radius: 50%;
    }
</style>