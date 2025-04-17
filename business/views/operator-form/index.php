<?php

use common\models\OperatorForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\OperatorFormSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Operator Forms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-form-index">
    <br>
    <br>
    <br>
    <br>
 


    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User Form', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    


</div>
