<div class="container">
    <?= $this->render('@frontend/modules/profile/views/default/tablist', ['activity' => 'active', 'user' => $user]) ?>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-followers" role="tabpanel" aria-labelledby="pills-followers-tab" tabindex="0">

            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body"></div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card mt-2">
                        <div class="card-body">
                            <h5>Following</h5>
                            <?php if ($followings = $user->userfollowings) {
                                foreach ($followings as $following) { ?>
                                    <img src="<?= $following->user->profile_image <> '' ?  $following->user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="rounded-circle" width="25" height="25">
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>