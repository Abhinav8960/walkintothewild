<?php

use yii\bootstrap5\Breadcrumbs;
?>
<div class="breadcrumb-header justify-content-between align-items-center">
    <div>
        <h3 class="page-header mb-0"><?= $title ?> </h3>
    </div>

    <div class="d">
        <?= Breadcrumbs::widget([
            'itemTemplate' => "<li class='breadcrumb-item'>{link} </li>",
            'homeLink' => [
                'label' => '<i class="fa fa-home"></i> Home' . Yii::t('yii', ' '),
                'url' => isset($this->params['breadcrumbs_home_url']) ? $this->params['breadcrumbs_home_url'] : Yii::$app->homeUrl,
                'encode' => false
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    </div>
</div>
<div class="ms-auto mb-3 btn_create">
    <?php
    if ($buttons) {
        foreach ($buttons as $button) {
            print_r($button);
        }
    }
    ?>
</div>

<style>
    .btn_create .btn-orange.btn-sm{

        padding: 9px 25px !important;
        font-size: 19px !important;
    }
</style>