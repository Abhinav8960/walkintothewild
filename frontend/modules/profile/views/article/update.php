<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | New Article ';
$this->params['title'] = $this->title;
?>
<section class="profile-wrapper">
    <div class="container mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['article' => 'active', 'user' => $user]) ?>
    </div>
</section>
<section>

    <div class="container ">
        <div class="row justify-content-center ">
            <div class="col-xxl-11 margin_bottomfooter">
                <div class="row ">
                    <div class="col-md-12 ">
                        <h6 class="fs-6 fw-bold mb-3">Update Article</h6>
                    </div>
                    <?= $this->render('_form', ['model' => $model]) ?>
                </div>
            </div>
        </div>
    </div>

</section>