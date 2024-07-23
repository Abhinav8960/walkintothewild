<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Contribution';
$this->params['title'] = $this->title;
?>

<div class="container mb-5">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['contribution' => 'active', 'user' => $user]) ?>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">
            <div class="card mt-2 mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            No Contribution Found!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>