<?php

use yii\helpers\Url;
use common\models\GeneralModel;
use common\models\operator\SafariOperatorFollow;

?>

<div class="row justify-content-center pt-4">
    <div class="col-xxl-8 col-xl-10 col-lg-12">
        <div class="top_opratorsBox logedin">
            <div class="row gx-lg-2">
                <div class="col-lg-3 col-md-4">
                    <div class="tourLogoes ">
                        <div class="images_tour">
                            <img src="<?= isset($operator->logo) ? $operator->imagepath : '/img/witw.png' ?>" alt="">
                            <!-- <img src="<?= $this->params['baseurl'] ?>/img/Pugdundee.jpg" alt="" class="w-100" loading="lazy"> -->
                        </div>
                        <div class="slect_safricound2 d-flex justify-content-around mt-4">
                            <div class="parks_text text-center">
                                <p><?= $operator->parkcount ?></p>
                                <p>Parks</p>
                            </div>
                            <div class="parks_text text-center">
                                <p><?= $operator->packagecount ?></p>
                                <p>Packages</p>
                            </div>
                            <div class="parks_text text-center">
                                <p><?= $operator->sharedsafaricount ?></p>
                                <p>Shared Safaris</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 pt-sm-3 pt-md-0 pt-3">
                    <div class="provider_details ps-lg-3">
                        <div class="title_tours d-flex justify-content-between align-items-center gap-md-2 gap-xxl-3">
                            <h3><?= $operator->businessname ?></h3>
                            <!-- <span class="d-sm-block d-none">|</span> -->
                            <div class="follow_massage d-flex gap-3">
                                <div class="follow mb-lg-2 mb-xxl-0 mb-2">
                                    <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id != $operator->user_id) {
                                        $operator_follow = SafariOperatorFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'safari_operator_id' => $operator->id, 'status' => 1])->limit(1)->one();
                                        if ($operator_follow) { ?>
                                            <a class="parkrevieBtn" href="<?= Url::toRoute(['/operator/default/unfollow', 'slug' => $operator->slug]) ?>" data-pjax="0"></i> Unfollow</a>
                                        <?php } else { ?>
                                            <a class="parkrevieBtn" href="<?= Url::toRoute(['/operator/default/follow', 'slug' => $operator->slug]) ?>" data-pjax="0"> Follow</a>
                                        <?php  }
                                    } else if (Yii::$app->user->identity && Yii::$app->user->identity->id == $operator->user_id) { ?>
                                        <a class="parkrevieBtn" href="<?= Url::toRoute(['/manage/default/edit-request']) ?>" data-pjax="0">Update</a>
                                    <?php } else { ?>
                                        <a class="parkrevieBtn" href="<?= Url::toRoute(['/operator/default/follow', 'slug' => $operator->slug]) ?>" data-pjax="0"> Follow</a>
                                    <?php } ?>
                                </div>
                                <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id != $operator->user_id) { ?>
                                    <!--                                    <div class="message">
                                        <a href="" class="parkrevieBtn">Message</a>
                                    </div>-->
                                <?php } ?>
                            </div>

                        </div>
                        <div class="title_tours">
                            <p class="pb-sm-0 pt-2"> <?= $operator->categorytitle ?></p>
                        </div>
                        <div class="providerNamerating tours d-flex flex-wrap gap-4 align-items-center pb-3 pt-1">
                            <div class="d-flex gap-2">
                                <div class="ratings">
                                    <p class="mb-0"><?= round($operator->google_rating, 1) ?> <?= GeneralModel::ratiing_views($operator->google_rating); ?></p>
                                </div>
                                <div class="googlerating">
                                    <p class="mb-0"><a href="<?= Url::toRoute(['/operator/default/reviewlist', 'slug' => $operator->slug]) ?>" data-pjax="0" style="color:inherit;"> <?= isset($operator->google_review_count) ? $operator->google_review_count . ' Reviews' : '0 Reviews' ?></a></p>
                                </div>
                            </div>
                            <div class="googlerating">
                                <p class="mb-0"><a href="<?= Url::toRoute(['/operator/default/follower', 'slug' => $operator->slug]) ?>" data-pjax="0" style="color:inherit;"><?= $operator->getFollowerlist()->where(['status' => 1])->count() ?> Followers</a></p>
                            </div>
                        </div>
                        <div class="detailsText pb-3">
                            <p style="font-size: 14px;"><?= $operator->about_business ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-3 px-lg-4 px-xl-3 px-xxl-5 px-2  pt-lg-0 pt-3 flex-set ">
                    <div class="contact_p">
                        <p>Contact</p>
                    </div>
                    <div class="d-flex gap-md-5 gap-2">
                        <div class="phone">
                            <i class="fa-solid fa-phone me-2"></i>
                            <span>Call</span>
                            <div class="phone-numbers">
                                <a href="tel:<?= $operator->phone_no ?>"><?= $operator->phone_no ?></a>
                                <?php if ($operator->operator_phone_no <> '') { ?>
                                    <a href="tel:<?= $operator->operator_phone_no ?>"><?= $operator->operator_phone_no ?></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="phone email">
                            <i class="fa-solid fa-envelope me-2"></i>
                            <span>Email</span>
                            <div class="email-addresses">
                                <a href="mailto:<?= $operator->email ?>"><?= $operator->email ?></a>
                                <?php if ($operator->operator_email <> '') { ?>
                                    <a href="mailto:<?= $operator->operator_email ?>"><?= $operator->operator_email ?></a>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                    <div class="socil-links d-flex gap-md-4 gap-2 my-3 flex-wrap">
                        <div class="fs <?= $operator->facebook_url ? '' : 'no-link-found' ?>">
                            <a href="<?= $operator->facebook_url ? $operator->facebook_url : '#' ?>"><i class="fa-brands fa-facebook-f"></i></a>
                        </div>
                        <div class="fs <?= $operator->instagram_url ? '' : 'no-link-found' ?>">
                            <a href="<?= $operator->instagram_url ? $operator->instagram_url : '#' ?>"> <i class="fa-brands fa-instagram"></i></a>
                        </div>
                        <div class="fs <?= $operator->youtube_link ? '' : 'no-link-found' ?>">
                            <a href="<?= $operator->youtube_link ? $operator->youtube_link : '#' ?>"> <i class="fa-brands fa-youtube"></i></a>
                        </div>
                    </div>
                    <div class="websitebtn pt-lg-3 <?= $operator->website ? '' : 'no-link-found' ?>">
                        <a href="<?= $operator->website ? $operator->website : '#' ?>">OFFICIAL WEBSITE</a>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>