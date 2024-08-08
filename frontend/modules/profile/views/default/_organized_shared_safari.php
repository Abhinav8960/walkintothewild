<?php

use yii\helpers\Url;
use common\models\sharesafari\ShareSafari;

$model = ShareSafari::find()->where(['host_user_id' => $user->id])->orderby(['id' => SORT_DESC])->limit(2)->all();
$model_count = ShareSafari::find()->where(['host_user_id' => $user->id])->count();

?>

<?php if ($model) { ?>
    <div class="request_quote mt-4">
        <button class="intested_btn interestBtn d-flex justify-content-between" value="#" style="background-color: var(--background-primary) !important;">
            Organized Shared Safari <span><?= $model_count ?></span></button>
        <div class="interst_wrapper py-4 px-xxl-5 bg-white">
        <div class="row justify-content-center">
            <?php
            foreach ($model as $share_safari) {
            ?>
              
                    <div class="col-md-6 col-lg-4 col-xxl-12 col-xl-12 col-sm-6 mb-4 padding_righ">
                        <?= $this->render('@frontend/modules/sharedsafari/views/default/_shared_safari_card', ['share_safari' => $share_safari]) ?>
                    </div>
                
            <?php }
            ?>
        </div>
        </div>
    </div>
<?php } ?>