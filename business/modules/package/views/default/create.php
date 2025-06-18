<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirport $model */

$this->title = 'Create Package';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Package', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/package'];
$this->params['breadcrumbs'][] = "Create";
$this->params['title'] = $this->title;

?>
 <div class="tabs-formswrapper">
    <?= $this->render('_create_navbar', ['overview_active' => 'active']) ?>
    <div class="card">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
                'safari_operator' => $safari_operator,
            ]) ?>
        </div>
    </div>
</div>