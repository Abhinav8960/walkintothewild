<?php

use yii\helpers\Url;

$this->title = 'Account Settings';

?>

<div class="container-lg mt-5 pt-5">
    <div class="row margin_bottomfooter">
        <div class="col-12 d-flex align-items-center justify-content-between mb-4">
            <h6 class="fs-3 fw-bold ">Account Settings</h6>
            <a class="btn btn-info bg-blues py-2 rounded-5" href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => Yii::$app->user->identity->user_handle]) ?>">View Profile</a>
        </div>
        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/account/views/default/_sidebar', ['active' => 'blocked']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8 itenary_tabs">
            <div class="card">
                <div class="card-body">
                    <h6 class="fs-5 fw-bold mb-3"> Blocked User</h6>
                    <div class="table-responsive table_design_manage">
                        <table class="table">
                            <thead>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Action</th>
                            </thead>
                            <?php if ($model) {
                                foreach ($model as $blocked_user) { ?>

                                    <tbody>
                                        <td><?= isset($blocked_user->user) ? $blocked_user->user->name : "" ?></td>
                                        <td><?= date('Y-m-d', $blocked_user->created_at) ?></td>
                                        <td><a class="btn_newsafari btn-sm" href="<?= Url::toRoute(['/profile/search/unblocked', 'id' => $blocked_user->blocked_user_id]) ?>">Unblock</a></td>
                                    </tbody>


                            <?php }
                            } ?>
                        </table>
                    </div>

                </div>
            </div>


        </div>
    </div>
</div>

<style>
    .btn_newsafari {

        padding: 5px 20px !important;
    }
</style>