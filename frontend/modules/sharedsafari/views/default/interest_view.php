<div class="users_profile d-flex gap-3 align-items-center flex-wrap">

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">S.No</th>
                <th scope="col">Avatar</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
            </tr>
        </thead>
        <?php if ($interest_model) {
            $srn = 1;
            foreach ($interest_model as $model) {
        ?>
                <tbody>
                    <tr>
                        <th scope="row"><?= $srn; ?></th>
                        <td>
                            <div class="profileavtar">
                                <img src="<?= $model->user && $model->user->avatar <> '' ? $model->user->avatar : $this->params['baseurl'] . '/img/Share-Safari/dpinterested.png' ?>" alt="" class="rounded-circle" title="<?= $model->user ? $model->user->name : '' ?>">
                            </div>
                        </td>
                        <td><?= $model->user->name ?></td>
                        <td><?= $model->user->username ?></td>
                </tbody>
        <?php $srn++;
            }
        } ?>
    </table>


</div>