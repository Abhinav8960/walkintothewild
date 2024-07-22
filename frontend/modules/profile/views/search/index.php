<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Search Profile';
$this->params['title'] = $this->title;
?>


<div class="container">
    <div class="row mt-2">
        <h3>Search Profile</h3>
    </div>
    <div class="row">
        <?php foreach ($user_list as $user) { ?>
            <div class="col-md-3">
                <section class="mx-auto my-5" style="max-width: 23rem;">
                    <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $user]);  ?>
                </section>
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