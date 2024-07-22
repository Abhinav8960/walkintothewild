<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | New Article ';
$this->params['title'] = $this->title;
?>

<div class="container mb-5">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['article' => 'active', 'user' => $user]) ?>

    <div class="row mt-3">
        <div class="col-md-12">
            <h5>Create New Article</h5>
        </div>
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
</div>