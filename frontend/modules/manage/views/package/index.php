<?php

use yii\helpers\Url;

$this->title = $safari_operator->business_name . ' | Manage Operator Business';

?>

<div class="container mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12 d-flex justify-content-between">
            <h5><?= $this->title ?></h5>
            <div class="right_button float-md-end">
                <a href="#<?= Url::toRoute(['/manage/package/create']) ?>" class="btn_newsafari packageBtn"><i class="fa fa-plus"></i> Create New Package</a>
            </div>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>