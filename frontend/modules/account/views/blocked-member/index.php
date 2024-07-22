<?php
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
                    <?php if ($model) {
                        foreach ($model as $blocked_user) { ?>
                            <table>
                                <td><?= $blocked_user->user->name ?></td>
                                <td><?= date('Y-m-d', $blocked_user->created_at) ?></td>
                                <td></td>
                            </table>
                    <?php }
                    } ?>
                </div>
            </div>


        </div>
    </div>
</div>