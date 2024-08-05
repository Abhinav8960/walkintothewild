<?php

use common\models\package\Package;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\UserWishlist;
use yii\helpers\Url;

$this->title = 'Your Wishlist';
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="container mt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12  ">
            <h6 class="fs-3 fw-bold mb-4">Wishlist</h6>
        </div>
        <div class="col-12">
            <div class="card account-settingside mb-5 itenary_tabs">
                <div class="card-body card-body p-4 safartabs">
                    <div class="row ">
                        <div class="col-md-12">
                            <?= $this->render('@frontend/modules/account/views/wishlist/_navbar', ['shared_safari' => 'active']) ?>
                            <div class="tab-content " id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-shared-safari" role="tabpanel" aria-labelledby="pills-shared-safari-tab">
                                    <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 g-lg-3 gx-lg-4 gx-xxl-5">

                                        <?php if ($wishlist_items) {
                                            foreach ($wishlist_items as $wishlist_item) {
                                                $share_safari_model = ShareSafari::find()->where(['id' => $wishlist_item->item_id])->limit(1)->one();
                                                if (!$share_safari_model) {
                                                    continue;
                                                }

                                        ?>
                                                <div class="col mb-4 padding_righ pt-4">
                                                <?= $this->render('@frontend/modules/sharedsafari/views/default/_shared_safari_card', ['share_safari' => $share_safari_model]) ?>
                                                </div>
                                        <?php }
                                        } else {
                                            echo '<p class="px-4">No Shared Safari found in wishlist</p>';
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>