<?php

$this->title = 'Safari Operator Tour Registrations';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Registration', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/registration/safari-operator-tour'];
$this->params['breadcrumbs'][] = "Update";
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <?= $this->render('form', [
            'model' => $model,
        ]) ?>
    </div>
</div>