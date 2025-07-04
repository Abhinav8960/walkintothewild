<?php

use yii\helpers\Html;



$this->title = 'Create Fixed Departure';

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