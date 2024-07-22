<div class="card mt-2">
    <div class="card-body">
        <h5>Following</h5>
        <?php if ($followings = $user->userfollowings) {
            foreach ($followings as $following) { ?>
                <a href="<?= \yii\helpers\Url::toRoute(['/profile/default/index', 'user_handle' => $following->user->user_handle]) ?>"> <img src="<?= $following->user->profileimage <> '' ?  $following->user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle" width="25" height="25" title="<?= $following->user->name ?>"></a>
        <?php }
        } ?>
    </div>
</div>