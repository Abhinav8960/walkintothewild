<div class="request_quote ">
    <button class="intested_btn interestBtn d-flex justify-content-between" value="#" style="background-color: var(--background-primary) !important;">
        Following</button>
    <div class="interst_wrapper py-4 px-md-5 bg-white">
        <?php if ($followings = $user->getUserfollowings()->where(['status' => 1])->all()) {
            foreach ($followings as $following) { ?>
                <a href="<?= \yii\helpers\Url::toRoute(['/profile/default/index', 'user_handle' => $following->follower->user_handle]) ?>"> <img src="<?= $following->follower->profileimage <> '' ?  $following->follower->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle" width="25" height="25" title="<?= $following->follower->name ?>"></a>
        <?php }
        } ?>
    </div>
</div>