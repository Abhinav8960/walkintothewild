<?php
$this->title = 'Account Settings';

use yii\helpers\Url;
?>

<div class="container mt-5">
    <div class="row margin_bottomfooter">
        <div class="col-12 d-flex align-items-center justify-content-between mb-4">
            <h6 class="fs-3 fw-bold ">Account Settings</h6>
            <a class="btn btn-info bg-blues py-2 rounded-5" href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => Yii::$app->user->identity->user_handle]) ?>">View Profile</a>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/account/views/default/_sidebar', ['active' => 'notification']); ?>
        </div>
        <div class="col-md-9">
            <div class="card account-settingside" style="min-height:500px">
                <div class="card-body p-4">
                    <h6 class="fs-5 fw-bold mb-3"> Choose which notifications to recive across all your devices</h6>


                    <div class="row p-3 shadow-sm  bg-white rounded mb-3">
                        <div class="col-md-8">
                            Enable Notification
                        </div>
                        <div class="col-md-4 d-flex justify-content-between">
                            <span>Email</span> <span>Web</span>
                        </div>
                    </div>

                    <div class="row p-3 shadow-sm  bg-white rounded mb-3">
                        <div class="col-md-12">
                            <h6>Mentions</h6>
                        </div>
                        <div class="col-md-8">
                            A member mentions you using <?= Yii::$app->user->identity->userhandle ?>
                        </div>
                        <div class="col-md-4 d-flex justify-content-between">
                            <span>Email</span> <span>Web</span>
                        </div>
                    </div>

                    <div class="row p-3 shadow-sm  bg-white rounded mb-3">
                        <div class="col-md-12">
                            <h6>Account Settings</h6>
                        </div>
                        <div class="col-md-8">
                            Your password is changed
                        </div>
                        <div class="col-md-4 d-flex justify-content-between">
                            <span>Email</span> <span>Web</span>
                        </div>
                    </div>

                    <div class="row p-3 shadow-sm  bg-white rounded mb-3">
                        <div class="col-md-12">
                            <h6>Activity</h6>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    A member replies to your comment
                                </div>
                                <div class="col-md-4 d-flex justify-content-between">
                                    <span>Email</span> <span>Web</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-8">
                                    A member commented in your shared safari
                                </div>
                                <div class="col-md-4 d-flex justify-content-between">
                                    <span>Email</span> <span>Web</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-8">
                                    A member starts following you
                                </div>
                                <div class="col-md-4 d-flex justify-content-between">
                                    <span>Email</span> <span>Web</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-8">
                                    New shared safari by a member you are following
                                </div>
                                <div class="col-md-4 d-flex justify-content-between">
                                    <span>Email</span> <span>Web</span>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-8">
                                    The details of a shared safari you have joined have been updated
                                </div>
                                <div class="col-md-4 d-flex justify-content-between">
                                    <span>Email</span> <span>Web</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <div class="col-md-8">
                                    New post in a shared safari you have joined
                                </div>
                                <div class="col-md-4 d-flex justify-content-between">
                                    <span>Email</span> <span>Web</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row p-3 shadow-sm  bg-white rounded mb-3">
                        <div class="col-md-12">
                            <h6>Private Message</h6>
                        </div>
                        <div class="col-md-8">
                            You recive a new private message
                        </div>
                        <div class="col-md-4 d-flex justify-content-between">
                            <span>Email</span> <span>Web</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>