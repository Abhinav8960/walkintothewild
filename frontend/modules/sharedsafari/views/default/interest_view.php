<?php

use yii\helpers\Url;


$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="users_profile d-flex gap-3 align-items-center flex-wrap">

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">S.No</th>
                <th scope="col">Name</th>
                <th scope="col">Join At</th>
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
                            <a style="color:inherit;" href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $model->user ? $model->user->user_handle : '']); ?>">
                                <div class="profileavtar">
                                    <img src="<?= $model->user && $model->user->profileimage <> '' ? $model->user->profileimage : $this->params['baseurl'] . '/img/Share-Safari/dpinterested.png' ?>" alt="" class="rounded-circle" title="<?= $model->user ? $model->user->name : '' ?>">
                                    <?= isset($model->user) ? $model->user->name : '' ?>
                                </div>
                            </a>
                        </td>
                        <td><?= date('Y-m-d', $model->intrested_at) ?></td>
                </tbody>
        <?php $srn++;
            }
        } ?>
    </table>


</div>