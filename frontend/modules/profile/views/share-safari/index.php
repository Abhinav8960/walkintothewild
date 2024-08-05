<?php

use common\models\sharesafari\ShareSafariIntrested;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Shared Safari';
$this->params['title'] = $this->title;
?>

<section class="profile-wrapper">
    <div class="container-lg mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['share_safari' => 'active', 'user' => $user]) ?>

    </div>
</section>

<section>
    <div class="container ">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">
                <div class="row justify-content-center ">
                    <div class="col-xxl-11 margin_bottomfooter">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card_bodyPadding">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;">Shared Safari Organized by <?= Yii::$app->user->identity->id == $user->id ? 'me' : $user->name ?> </h6>

                                        </div>

                                        <div class="row gx-5">
                                            <?php if ($dataProvider->models) {
                                                foreach ($dataProvider->models as $share_safari) {
                                            ?>
                                                    <div class="col-md-4 mb-4">
                                                        <?= $this->render('@frontend/modules/sharedsafari/views/default/_shared_safari_card', ['share_safari' => $share_safari]) ?>
                                                    </div>
                                            <?php }
                                            } ?>
                                            <div class="d-flex justify-content-between mb-4">
                                                <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;">Shared Safari Joined by <?= Yii::$app->user->identity->id == $user->id ? 'me' : $user->name ?> </h6>

                                            </div>
                                            <?php if ($joindedProvider->models) {
                                                foreach ($joindedProvider->models as $shared_safari) {
                                                    if ($share_safari = $shared_safari->sharesafari) {

                                            ?>
                                                        <div class="col-md-4 mb-4">
                                                            <?= $this->render('@frontend/modules/sharedsafari/views/default/_shared_safari_card', ['share_safari' => $share_safari]) ?>
                                                        </div>
                                            <?php }
                                                }
                                            } ?>
                                        </div>
                                        <?php
                                        echo \yii\widgets\LinkPager::widget([
                                            'pagination' => $dataProvider->pagination,
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>