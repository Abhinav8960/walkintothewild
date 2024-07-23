<div class="card mt-2">
    <div class="card-body">
        <h5>Following</h5>
        <?php if ($followings = $user->getUserfollowings()->where(['status' => 1])->all()) {
            foreach ($followings as $following) { ?>
                <a href="<?= \yii\helpers\Url::toRoute(['/profile/default/index', 'user_handle' => $following->follower->user_handle]) ?>"> <img src="<?= $following->follower->profileimage <> '' ?  $following->follower->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle" width="25" height="25" title="<?= $following->follower->name ?>"></a>
        <?php }
        } ?>
    </div>
</div>