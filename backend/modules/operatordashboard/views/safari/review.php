<?php

$this->title = 'Safari Tour - User Review';
$this->params['breadcrumbs_home_url'] = '/operatordashboard';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<div class="panel panel-primary tabs-style-2">
    <?= $this->render('_navbar', ['safari_operator' => $safari_operator, 'active_navbar' => 'review']) ?>
    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                User Review
            </div>
        </div>
    </div>
</div>