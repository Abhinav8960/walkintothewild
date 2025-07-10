<?php

use yii\helpers\Html;

$this->title = 'FAQ';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = "Update";
$this->params['title'] = $this->title;
?>


        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
