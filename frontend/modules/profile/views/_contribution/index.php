<?php

use common\models\GeneralModel;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Contribution';
$this->params['title'] = $this->title;
?>
<section class="profile-wrapper">
    <div class="container-lg mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['contribution' => 'active', 'user' => $user]) ?>

    </div>
</section>

<section>
    <div class="container-lg ">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">
                <div class="row justify-content-center mb-5">
                    <div class="col-xxl-11 margin_bottomfooter">
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card  mb-4 card_bodyPadding">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php
                                            if ($suggestions) {
                                                foreach ($suggestions as $suggestion) { ?>
                                                    <div class="col-12">
                                                        <div class="comments-persons mb-2">
                                                            <div class="postcomment">
                                                                <div class="googlerating names">
                                                                    <h6 class=" mb-0 fs-6 pb-2"><?= isset($suggestion->master_suggestion_id) ? GeneralModel::suggestioncategory()[$suggestion->master_suggestion_id] : '' ?></h6>
                                                                </div>
                                                                <div class="itenary_text boldsText">
                                                                    <h6><?= isset($suggestion->park_id) ? GeneralModel::safariparkoption()[$suggestion->park_id] : '' ?>
                                                                    </h6>
                                                                    <p class="mb-0"> <?= isset($suggestion->details) ? $suggestion->details : '' ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                <?php }
                                            } else { ?>
                                                <div class="col-6">
                                                    <p>No Contribution Found</p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <?= $this->render('@frontend/modules/profile/views/default/_following_card', ['user' => $user]) ?>

                                <?= $this->render('@frontend/modules/profile/views/default/_instagram', ['user' => $user]) ?>

                                <?= $this->render('@frontend/modules/profile/views/default/_organized_shared_safari', ['user' => $user]) ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>