<?php


/* @var $this yii\web\View */

use common\models\operator\SafariOperator;
use yii\helpers\Url;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\UserWishlist;

$this->title = 'Share Safari';

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
    <?php if ($share_safari->type == 2) { ?>
        <div class="fixed-depart">
            <p>Fixed Departure</p>
        </div>
    <?php } ?>

    <div class="shareimg">
        <img src="<?= $share_safari->sharedimagepath ? $share_safari->sharedimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="">
    </div>
    <div class="card_body">
        <?php
        $class = '';
        if (Yii::$app->user->identity) {
            $share_safari_intrested = ShareSafariIntrested::find()->where(['user_id' => Yii::$app->user->identity->id, 'share_safari_id' => $share_safari->id, 'status' => 1])->limit(1)->one();
            if ($share_safari_intrested) {
                $class = 'background-color: #4B4B4B;';
            }
        } ?>
        <div class="top_seats" style='<?= $class ?>'>
            <div class="safari d-flex justify-content-between ">
                <div class="safarinum d-flex gap-2 align-items-center ">
                    <p class="text_safari">SAFARI</p>
                    <h6 class="number-safari"><?= $share_safari->no_of_safari ?></h6>
                </div>
                <div class="safarinum d-flex gap-2 align-items-center justify-content-center">
                    <p class="text_safari">SEATS</p>
                    <h6 class="number-safari"><?= $share_safari->share_seat ?></h6>
                </div>
            </div>
        </div>
        <div class="titleDate">
            <h6><?= isset($share_safari->park) ? $share_safari->park->title : '' ?></h6>
            <div class="orgnizer">
                <p>Organized by: <strong><?= $share_safari->organizedbyname ?></strong></p>
            </div>
        </div>
        <div class="footer_card row pb-2 px-2 align-items-center">
            <div class="col-6">
                <div class="users">
                    <?php if ($interests = $share_safari->getIntrested()->where(['status' => 1])->limit(3)->all()) {
                        $count = $share_safari->getIntrested()->count();
                        $avatar_count = 3;
                        foreach ($interests as $interest) {
                            if ($user_interested = $interest->user) {
                    ?>
                                <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user_interested->user_handle]) ?>" data-pjax="0"><img src="<?= $user_interested->profileimage <> '' ? $user_interested->profileimage : $this->params['baseurl'] . '/img/Share-Safari/dpinterested.png' ?>" alt="" class="rounded-circle"></a>
                            <?php }
                        };
                        $count = $share_safari->getIntrested()->count();
                        $avatar_count = 3;
                        $data = $count - $avatar_count;
                        if ($data > 3) {  ?>
                            <div class="roundes_countuser">
                                <?= $data ?>+
                            </div>
                        <?php }
                    } else { ?>
                        <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $share_safari->user ? $share_safari->user->user_handle : '']) ?>" data-pjax="0"><img src="<?= $share_safari->user && $share_safari->user->avatar <> '' ? $share_safari->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' ?>" alt="" class="rounded-circle"></a>
                    <?php } ?>
                </div>
            </div>
            <div class="col-6">
                <div class="safari text-center">
                    <div class="joinsafari">
                        <?= \yii\helpers\Html::a('<i class="fas fa-edit me-1"></i>Update', ['/manage/sharedsafari/update-fixed-departure', 'slug' => $share_safari->slug], ['style' => "background-color: #F5F5F5; border:1px solid #7070704D; color:#4B4B4B;", 'data-pjax' => '0']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>