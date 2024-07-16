<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Profile';
$this->params['title'] = $this->title;
?>


<div class="container">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['profile' => 'active', 'user' => $user]) ?>
    <div class="row">
        <div class="col-8">
            <div class="card mt-2 mb-4">
                <div class="card-body">
                    <h6>About</h6>
                    <?php if ($user->about) { ?>
                        <p><?= $user->about ?></p>
                    <?php } ?>
                    <h6>Social Media</h6>
                    <?php if ($user->facebook_url) { ?>
                        <a href="<?= $user->facebook_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                        <p><?= $user->facebook_url; ?></p>
                    <?php } ?>
                    <?php if ($user->whatsapp_url) { ?>
                        <a href="<?= $user->whatsapp_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                        <p><?= $user->whatsapp_url; ?></p>
                    <?php } ?>
                    <?php if ($user->x_url) { ?>
                        <a href="<?= $user->x_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-x-twitter"></i></a>
                        <p><?= $user->x_url; ?></p>
                    <?php } ?>
                    <?php if ($user->insta_url) { ?>
                        <a href="<?= $user->insta_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i></a>
                        <p><?= $user->insta_url; ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>