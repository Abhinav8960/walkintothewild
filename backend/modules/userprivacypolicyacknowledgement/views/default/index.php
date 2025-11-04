<?php

use common\models\GeneralModel;
use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'User Privacy Policy Acknowledgemnt';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<?= $this->render('_search', ['model' => $searchModel]) ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'attribute' => 'user',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $name = $model->user->name ?? '';
                            if (!empty($model->currentpolicy)) {
                                return "<span style='color: green;'>{$name}</span>";
                            } else {
                                return "<span style='color: black;'>{$name}</span>";
                            }
                        },
                    ],
                    [
                        'label' => 'email',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user->email;
                        }
                    ],
                    [
                        'label' => 'Document',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->document->type) {
                                return isset(GeneralModel::complianceDocumentsTitleoption()[$model->document->type]) ? GeneralModel::complianceDocumentsTitleoption()[$model->document->type] : '';
                            }
                        }
                    ],
                    [
                        'label' => 'Document Version',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->document_version;
                        }
                    ],
                    [
                        'label' => 'Acknowledge DateTime',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return \Yii::$app->formatter->asDatetime($model->created_at);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>