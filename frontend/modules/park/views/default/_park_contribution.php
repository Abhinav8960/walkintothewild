<?php

use common\models\GeneralModel;
use common\models\suggestions\SafariSuggestions;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$suggestions = SafariSuggestions::find()->where(['park_id' => $safari_model->id, 'status' => 1])->all();
?>



<?php if ($suggestions) { ?>
    <div class="filter-wrapper custoM-inputs d-lg-block d-none">
        <div class="title_top">
            <h4>Contribution</h4>
        </div>
        <?php if (Yii::$app->user->id) {  ?>

            <div class="title_filter mb-3">
                <button value="<?= Url::toRoute(['/park/default/suggestion', 'park_id' => $safari_model->id]) ?>" class="parkrevieBtn writeSuggestionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal3">Suggest Correction </button>
            </div>
        <?php } else {
            echo 'Please <a href="/site/auth?authclient=google" class="sign_intext">Sign in</a> for giving your contribution';
        } ?>
        <div class="title_filter mb-2">
            <div class="">
                <?php
                if ($suggestions) {
                    foreach ($suggestions as $suggestion) {
                ?>
                        <div class="comments-persons mb-2">
                            <div class="postcomment">
                                <div class="googlerating names">
                                    <h6 class=" mb-0 fs-6 pb-2"><?= isset($suggestion->name) ? $suggestion->name : '' ?></h6>
                                </div>
                                <div class="itenary_text boldsText">
                                    <h6><?= isset($suggestion->master_suggestion_id) ? GeneralModel::suggestioncategory()[$suggestion->master_suggestion_id] : '' ?>
                                    </h6>
                                    <p class="mb-0"> <?= isset($suggestion->details) ? $suggestion->details : '' ?></p>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
        <?php if (count($suggestions) >= 1) { ?>

            <div class="col-12">
                <div class="safari text-center">
                    <div class="joinsafari">
                        <a href="/park/contributionlist/<?= $safari_model->slug ?>">View All</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>