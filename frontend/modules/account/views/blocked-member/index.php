<?php

use yii\helpers\Url;

$this->title = 'Account Settings';

?>

<div class="container mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/account/views/default/_sidebar', ['active' => 'blocked']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h6>Blocked User</h6>
                    <table class="table">
                        <thead>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </thead>
                        <?php if ($model) {
                            foreach ($model as $blocked_user) { ?>

                                <tbody>
                                    <td><?= $blocked_user->user->name ?></td>
                                    <td><?= date('Y-m-d', $blocked_user->created_at) ?></td>
                                    <td><a class="btn_newsafari btn-sm" href="<?= Url::toRoute(['/profile/search/unblocked', 'id' => $blocked_user->blocked_user_id]) ?>">Unblocked</a></td>
                                </tbody>


                        <?php }
                        } ?>
                    </table>
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