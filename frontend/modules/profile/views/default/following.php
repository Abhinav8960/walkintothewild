<?php


use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Following';
$this->params['title'] = $this->title;
?>
<section class="profile-wrapper">
    <div class="container mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['profile' => 'active', 'user' => $user]) ?>
    </div>
</section>
<section>
    <div class="container">
    <div class="row justify-content-center mb-5">
                    <div class="col-xxl-11 mb-5">
                    <div class="row mt-3 mb-5">
            <div class="col-md-12">
                <h5>Following</h5>
            </div>
            <?php if ($userfollowers = $user->getUserfollowings()->where(['status' => 1])->all()) {
                foreach ($userfollowers as $userfollower) { ?>
                    <div class="col-md-3">

                        <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $userfollower->follower]);  ?>

                    </div>
            <?php  }
            } else {
                echo '<div class="col-md-12">
                    There is no following!
                </div>';
            } ?>
        </div>
                    </div>
                </div>
       
    </div>
</section>