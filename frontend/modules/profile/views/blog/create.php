<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | New Blog ';
$this->params['title'] = $this->title;
?>
<section class="profile-wrapper">
    <div class="container-lg mb-5">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['blog' => 'active', 'user' => $user]) ?>
    </div>
</section>
<section>
<div class="container margin_bottomfooter">
    <div class="row mt-3  justify-content-center">
        <div class="col-xxl-11 ">
            <h6 class="mb-4 fs-6 fw-bold">Create New Blog</h5>
            <?= $this->render('_form', ['model' => $model]) ?>
        </div>
       
    </div>
</div>
</section>
