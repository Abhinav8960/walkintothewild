<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Activity';
$this->params['title'] = $this->title;
?>

<section class="profile-wrapper">
    <div class="container mb-5">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['activity' => 'active', 'user' => $user]) ?>

    </div>
</section>
<section>
<div class="container ">
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">
        <div class="row justify-content-center ">
            <div class="col-xxl-11 margin_bottomfooter">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card_bodyPadding">
                        <div class="card-body">
                            No Activity Found!
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <?= $this->render('@frontend/modules/profile/views/default/_following_card', ['user' => $user]) ?>
                </div>
            </div>
            </div>
        </div>
           

        </div>
    </div>
</div>
</section>
