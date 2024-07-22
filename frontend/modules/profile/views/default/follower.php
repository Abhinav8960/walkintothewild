<?php


use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Followers';
$this->params['title'] = $this->title;
?>

<div class="container">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['profile' => 'active', 'user' => $user]) ?>
    <div class="row mt-3 mb-5">
        <div class="col-md-12">
            <h5>Followers</h5>
        </div>
        <?php if ($userfollowers = $user->getUserfollowers()->where(['status' => 1])->all()) {
            foreach ($userfollowers as $userfollower) { ?>
                <div class="col-md-3">
                    <section class="mx-auto" style="max-width: 23rem;">
                        <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $userfollower->follower]);  ?>
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