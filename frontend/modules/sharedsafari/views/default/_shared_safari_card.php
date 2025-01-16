<?php


/* @var $this yii\web\View */

use common\models\operator\SafariOperator;
use common\models\sharesafari\ShareSafari;
use yii\helpers\Url;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\UserWishlist;

//$this->title = 'Share Safari';

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="sharesafri-card">
    <div class="flotingdate">
        <div class="icons text-center">
            <p class="mb-0"><?= date('M', strtotime($share_safari->start_date)) ?></p>
            <p class="mb-0"><?= date('d', strtotime($share_safari->start_date)) ?></p>
        </div>
    </div>
    <!-- <div class="floating-watchlist">
                                                <?php
                                                if (Yii::$app->user->identity) { ?>
                                                    <div class="heart_bx">
                                                        <?php
                                                        $wishlist = UserWishlist::find()->where(['user_id' => Yii::$app->user->identity->id, 'item_id' => $share_safari->id, 'item_type_id' => 2, 'status' => 1])->limit(1)->one();
                                                        if ($wishlist) {
                                                        ?>
                                                            <a href="/sharedsafari/unwishlist/<?= $share_safari->slug ?>" style="color:#FD5634;"><i class="fa-solid fa-heart"></i></a>
                                                        <?php } else { ?>
                                                            <a href="/sharedsafari/wishlist/<?= $share_safari->slug ?>" style="color:black;"><i class="fa-regular fa-heart"></i></a>
                                                        <?php }
                                                        ?>
                                                    </div>
                                                <?php } ?>
                                            </div> -->
    <?php if ($share_safari->type == 2) { ?>
        <div class="fixed-depart">
            <p>Fixed Departure</p>
        </div>
    <?php } ?>
    <?php if ($share_safari->pined_safari == 1) { ?>
        <div class="highlighted-safari">
            <p>Highlighted</p>
        </div>
    <?php } ?>

    <div class="shareimg">
        <a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>" data-pjax="0"><img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt=""></a>
    </div>
    <div class="card_body">
        <?php
        $class = '';
        // if (Yii::$app->user->identity) {
        //     $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
        //     if ($share_safari_intrested) {
        //         $class = 'background-color: #4B4B4B;';
        //     }
        // }
        if ($share_safari->status == ShareSafari::STATUS_FULL_SEAT) {
            $class = 'background-color: gray;';
        }  ?>
        <div class="top_seats" style='<?= $class ?>'>
            <div class="safari d-flex justify-content-between ">
                <div class="safarinum d-flex gap-2 align-items-center ">
                    <p class="text_safari">SAFARI</p>
                    <h6 class="number-safari"><?= $share_safari->no_of_safari ?></h6>
                </div>
                <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                    <p class="text_safari">SEATS</p>
                    <?php if ($share_safari->type == ShareSafari::TYPE_SAFARI) {
                        if ($share_safari->status == ShareSafari::STATUS_FULL_SEAT) { ?>
                            <h6 class="number-safari">0</h6>
                        <?php } else { ?>
                            <h6 class="number-safari"><?= $share_safari->share_seat ?></h6>
                        <?php }
                    } else {

                        if ($share_safari->status == ShareSafari::STATUS_FULL_SEAT) {  ?>
                            <h6 class="number-safari">0</h6>
                        <?php } else { ?>
                            <h6 class="number-safari"><?= $share_safari->share_seat ?></h6>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
        <div class="titleDate">
            <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>" data-pjax="0"><?= $share_safari->share_safari_title ?></a></h6>
            <div class="orgnizer">
                <p>Organized by: <strong><?= $share_safari->organizedbyname ?></strong></p>
            </div>
            <h6><a href="<?= Url::toRoute(['/sharedsafari/default/view', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : '']) ?>" data-pjax="0"><i class="fa-solid fa-location-dot me-1"></i><?= isset($share_safari->park) ? $share_safari->park->title : '' ?></a></h6>
        </div>
        <div class="footer_card row pb-2 px-2 align-items-center">
            <div class="col-6">
                <div class="users">
                    <?php if ($interests = $share_safari->getIntrested()->joinWith('user')->where(['user.status' => 10, 'share_safari_intrested.status' => 1])->limit(3)->all()) {
                        // $count = $share_safari->getIntrested()->where(['status' => 1])->count();
                        // $avatar_count = 3;
                        foreach ($interests as $interest) {
                            if ($user_interested = $interest->user) {
                    ?>
                                <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user_interested->user_handle]) ?>" data-pjax="0"><img src="<?= $user_interested->profileimage <> '' ? $user_interested->profileimage : $this->params['baseurl'] . '/img/Share-Safari/dpinterested.png' ?>" alt="" class="rounded-circle"></a>
                            <?php }
                        };
                        $count = $share_safari->getIntrested()->where(['status' => 1])->count();
                        $avatar_count = 3;
                        $data = $count - $avatar_count;
                        if ($count > 3) { ?>
                            <div class="roundes_countuser">
                                +<?= $data ?>
                            </div>
                        <?php }
                    } else { ?>
                        <a href="<?= $share_safari->organizedbyprofileurl ? $share_safari->organizedbyprofileurl : '' ?>" data-pjax="0"><img src="<?= $share_safari->organizedbyimage  ? $share_safari->organizedbyimage : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle"></a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-6">
                <div class="safari text-center">
                    <div class="joinsafari">
                        <?php

                        if ($share_safari->status == ShareSafari::STATUS_SUSPEND) { // Closed
                            echo '<a href="#">Closed Safari</a>';
                        } else if ($share_safari->status == ShareSafari::STATUS_FULL_SEAT) { // No Seat
                            echo '<a style="background-color:gray;" href="#">Seats Full</a>';
                        } else { // Open Safari
                            if (Yii::$app->user->identity) {
                                $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
                                if ($share_safari_intrested) {
                                    echo \yii\helpers\Html::a('Leave Safari', ['/sharedsafari/default/unjoin', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''], ['style' => "background-color: #F5F5F5; border:1px solid #7070704D; color:#4B4B4B;", 'data-method' => "POST", 'data-pjax' => '0']);
                                } else {
                                    if ($share_safari->type == 2) { // Fixed  Safai
                                        if ($safarioperator = $share_safari->safarioperator) {
                                            if ($safarioperator->user_id <> Yii::$app->user->identity->id) {
                                                echo \yii\helpers\Html::a('Join Safari', ['/sharedsafari/default/join', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''], ['data-method' => "POST", 'data-pjax' => '0', 'class' => (Yii::$app->user->identity && Yii::$app->user->identity->operator ? 'disabled' : '')]);
                                            } else {
                                                echo \yii\helpers\Html::a('<i class="fas fa-edit me-1"></i>Update', ['/manage/sharedsafari/update-fixed-departure', 'slug' => $share_safari->slug], ['style' => "background-color: #F5F5F5; border:1px solid #7070704D; color:#4B4B4B;", 'data-pjax' => '0']);
                                            }
                                        }
                                    } else {
                                        if ($share_safari->host_user_id != Yii::$app->user->identity->id) {
                                            echo \yii\helpers\Html::a('Join Safari', ['/sharedsafari/default/join', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''], ['data-method' => "POST", 'data-pjax' => '0', 'class' => (Yii::$app->user->identity && Yii::$app->user->identity->operator ? 'disabled' : '')]);
                                        } else {
                                            echo '<a class="updateSafariBtn " value="' . Url::toRoute(['/sharedsafari/default/update', 'slug' => $share_safari->slug]) . '" style="background-color: #F5F5F5; border:1px solid #7070704D; color:#4B4B4B;cursor:pointer;" data-pjax="0"><i class="fas fa-edit me-1"></i>Update</a>';
                                            // echo \yii\helpers\Html::a('<i class="fas fa-edit me-1"></i>Update', ['/sharedsafari/default/update', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''], ['class'=>"updateSafariBtn",'style' => "background-color: #F5F5F5; border:1px solid #7070704D; color:#4B4B4B;", 'data-method' => "POST", 'data-pjax' => '0']);
                                        }
                                    }
                                }
                            } else {
                                echo \yii\helpers\Html::a('Join Safari', ['/sharedsafari/default/join', 'slug' => $share_safari->slug, 'organized_slug' => $share_safari->organizedslug ? $share_safari->organizedslug : ''], ['data-method' => "POST", 'data-pjax' => '0', 'class' => (Yii::$app->user->identity && Yii::$app->user->identity->operator ? 'disabled' : '')]);
                            }
                        }

                        ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>