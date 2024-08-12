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

<div class="container-lg mt-5 pt-5" style="min-height: 600px;">
    <div class="row margin_bottomfooter">
        <div class="col-md-12  ">
            <h6 class="fs-3 fw-bold mb-4">Wishlist</h6>
        </div>
        <div class="col-12">
            <div class="card account-settingside mb-5 itenary_tabs">
                <div class="card-body p-md-4 safartabs">
                            <?= $this->render('@frontend/modules/account/views/wishlist/_navbar', ['package' => 'active']) ?>
                            <div class="tab-content m-0 m-md-3" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-packages" role="tabpanel" aria-labelledby="pills-packages-tab">
                                    <div class="row row-cols-1 row-cols-sm-2  row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-3 g-lg-3 gx-lg-4 gx-xxl-5">
                                        <?php if ($wishlist_items) {
                                            foreach ($wishlist_items as $wishlist_item) {
                                                $package_model = Package::find()->where(['id' => $wishlist_item->item_id])->limit(1)->one();
                                                if (!$package_model) {
                                                    continue;
                                                }
                                        ?>
                                                <div class="col padding_righ pt-4">
                                                    <?= $this->render('@frontend/modules/package/views/default/_package_card', ['model' => $package_model]) ?>
                                                </div>
                                        <?php }
                                        } else {
                                            echo '<p class="mb-0 px-2">No Shared Safari found in wishlist</p>';
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>

</div>