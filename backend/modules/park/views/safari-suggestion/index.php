<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Safari Suggestion';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="card">

    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Safari Park',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset(GeneralModel::safariparkoption()[$model->park_id]) ? GeneralModel::safariparkoption()[$model->park_id] : '';
                        }
                    ],
                    [
                        'label' => 'Category',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset(GeneralModel::suggestioncategory()[$model->master_suggestion_id]) ? GeneralModel::suggestioncategory()[$model->master_suggestion_id] : '';
                        }
                    ],

                    [
                        'label' => 'Who Suggested',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            // return isset(GeneralModel::operatorcategory()[$model->you_are_id]) ? GeneralModel::operatorcategory()[$model->you_are_id] : '';
                            return $model->name;
                        }
                    ],
                    [
                        'label' => 'Details',
                        'contentOptions' => ['style' => 'width: 40%;'],  // Adjust width here
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->details;
                        }
                    ],
                    'created_at:dateTime:Created at',
                  
                ],
            ]); ?>
        </div>
    </div>
</div>