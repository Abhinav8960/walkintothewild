<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'Article';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'Article', 'url' => '#'];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/author'];
$this->params['breadcrumbs'][] = "Create";
$this->params['title'] = $this->title;
?>

<div class="test-view">



    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>




    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Name',
                'contentOptions' => ['style' => 'width: 10%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->name;
                }
            ],
            [
                'label' => 'Mobile Number',
                'contentOptions' => ['style' => 'width: 10%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->mobile_no;
                }
            ],
            [
                'label' => 'Profile Image',
                'contentOptions' => ['style' => 'width: 50%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->profile_image) {
                        $imageUrl = Yii::$app->request->baseUrl . '/web/' . $model->profile_image;
                        return '<img src="' . $model->imagepath . '" style="max-width: 200px;" />';
                    } else {
                        return 'No image available';
                    }
                }
            ],

        ],
    ]) ?>

</div>