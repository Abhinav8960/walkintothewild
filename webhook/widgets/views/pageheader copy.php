<?php

use yii\bootstrap5\Breadcrumbs;
?>
<div class="breadcrumb-header justify-content-between">
    <div>
        <?= Breadcrumbs::widget([
            'itemTemplate' => "<li class='breadcrumb-item'>{link} </li>",
            'homeLink' => [
                'label' => '<i class="fa fa-home"></i> Home' . Yii::t('yii', ' '),
                'url' => isset($this->params['breadcrumbs_home_url']) ? $this->params['breadcrumbs_home_url'] : Yii::$app->homeUrl,
                'encode' => false
            ],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <h1 class="page-header mb-0"><?= $title ?> </h1>
    </div>

    <div class="ms-auto">
        <?php
        if ($buttons) {
            foreach ($buttons as $button) {
                print_r($button);
            }
        }
        ?>
    </div>
</div>