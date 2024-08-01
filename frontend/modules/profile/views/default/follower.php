<?php


use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Followers';
$this->params['title'] = $this->title;
?>

<section class="profile-wrapper">
    <div class="container mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['profile' => 'active', 'user' => $user]) ?>
    </div>
</section>

<section class="margin_bottomfooter">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-xxl-11 mb-5">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h6 class="fs-5 fw-bold">Followers</h5>
                    </div>
                    <?php if ($userfollowers = $user->getUserfollowers()->where(['status' => 1])->all()) {
                        foreach ($userfollowers as $userfollower) { ?>
                            <div class="col-md-3">
                                <section class="mx-auto" style="max-width: 23rem;">
                                    <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $userfollower->user]);  ?>
                                </section>
                            </div>
                    <?php  }
                    } else {
                        echo '<div class="col-md-12">
                    There is no follower!
                </div>';
                    } ?>
                </div>
            </div>
        </div>

    </div>
</section>