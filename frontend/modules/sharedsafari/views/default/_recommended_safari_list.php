<?php

use yii\helpers\Url;
use common\models\sharesafari\ShareSafari;

$shared_safaries = ShareSafari::find()->select("*,(SELECT count(1) FROM `share_safari_intrested` WHERE share_safari_id=share_safari.id and share_safari_intrested.status=1) AS `instreted_user_count`")->where(['status' => ShareSafari::STATUS_ACTIVE])->andWhere(['>=', 'start_date', date("Y-m-d")])->limit(10)->orderby(['instreted_user_count' => SORT_DESC])->all();

?>

<?php if ($shared_safaries) { ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="title_web">
                    <h2>Sharing Safari <br>You Might be Interested</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $safari_printed = 0;
            foreach ($shared_safaries as $share_safari) {
                if ($safari_printed >= 4) {
                    continue;
                }

                // if (Yii::$app->user->identity) {
                //     if ($share_safari->type == 2) { // Fixed  Safai
                //         if ($safarioperator = $share_safari->safarioperator) {
                //             if ($safarioperator->user_id == Yii::$app->user->identity->id) {
                //                 continue;
                //             }
                //         }
                //     } else {
                //         if ($share_safari->host_user_id == Yii::$app->user->identity->id) {
                //             continue;
                //         }
                //     }
                // }
            ?>
                <div class="col-lg-3 col-sm-6 col-xxl-3 col-md-3 mb-4">
                    <?= $this->render('@frontend/modules/sharedsafari/views/default/_shared_safari_card', ['share_safari' => $share_safari]) ?>
                </div>

            <?php $safari_printed++;
            } ?>

            <?php if ($safari_park) { ?>
                <div class="col-md-12 mt-5 mb-5">
                    <div class="tour_logosliders">
                        <div class="taglines">
                            <p>Top Safari Operators in <b><?= $safari_park->title ?></b></p>
                        </div>
                        <div class="touroprators">
                            <div class="opratios-slider owl-carousel owl-theme">
                                <?php if ($operator_list = $safari_park->getSafarioperatorlist()->joinwith(['operator' => function ($operator_park_query) {
                                    $operator_park_query->where(['safari_operator.status' => 1]);
                                }])->where(['safari_operator_park.status' => 1])->all()) {
                                    foreach ($operator_list as $operator_park) { ?>
                                        <div class="slidesImg">
                                            <a href="<?= Url::toRoute(['/operator/default/sharedsafari', 'slug' => $operator_park->operator->slug]) ?>" data-pjax="0">
                                                <img src="<?= isset($operator_park->operator->logo) ? $operator_park->operator->imagepath : $this->params['baseurl'] . '/img/Pugdundee.jpg' ?>" alt="" class="w-100">
                                            </a>
                                        </div>
                                    <?php  }
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>