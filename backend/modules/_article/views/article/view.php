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
                'label' => 'Article Title',
                'contentOptions' => ['style' => 'width: 5%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('div', $model->article_title, [
                        'style' => 'display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;',
                    ]);
                }
            ],
            [
                'label' => 'Writer',
                'contentOptions' => ['style' => 'width: 5%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::tag('div', $model->writer, [
                        'style' => 'display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;',
                    ]);
                }
            ],
            [
                'label' => 'Article Source',
                'contentOptions' => ['style' => 'width: 5%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return isset($model->source) ? GeneralModel::sourceoption()[$model->source] : '';
                }
            ],

            [
                'label' => 'Post Date',
                'contentOptions' => ['style' => 'width: 5%;'],
                'format' => ['date', 'php:Y-m-d'],
                'value' => function ($model) {
                    return $model->post_date;
                }
            ],
            [
                'label' => 'Abstract',
                'contentOptions' => ['style' => 'width: 50%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->key_point;
                }
            ],
            [
                'label' => 'Tags',
                'contentOptions' => ['style' => 'width: 15%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    // Decode the tag_id if it's a JSON string, otherwise use it directly
                    $tagIds = is_string($model->tag_id) ? json_decode($model->tag_id, true) : $model->tag_id;

                    if (!empty($tagIds) && is_array($tagIds)) {
                        // Initialize an array to store tag names
                        $tagNames = [];

                        // Loop through each tag ID and fetch its name
                        foreach ($tagIds as $tagId) {
                            // Get the tag name from the options list, default to 'Unknown' if not found
                            $tagNames[] = GeneralModel::articletagoption()[$tagId] ?? 'Unknown';
                        }

                        // Convert the array of tag names into a comma-separated string
                        return implode(', ', $tagNames);
                    } else {
                        return ''; // Return empty string if tagIds is empty or not an array
                    }
                }
            ],
            [
                'label' => 'Link',
                'contentOptions' => ['style' => 'width: 5%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->link, $model->link, [
                        'target' => '_blank',
                        'style' => 'color: blue !important; display: inline-block; max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;',
                    ]);
                }
            ],
            
            




            [
                'label' => 'Image',
                'contentOptions' => ['style' => 'width: 50%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->image) {
                        $imageUrl = Yii::$app->request->baseUrl . '/web/' . $model->image;
                        return '<img src="' . $model->imagepath . '" style="max-width: 200px;" />';
                    } else {
                        return 'No image available';
                    }
                }
            ],


            [
                'label' => 'Video',
                'contentOptions' => ['style' => 'width: 50%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->video) {
                        $videoUrl = Yii::$app->request->baseUrl . '/web/' . $model->video;
                        // print_r($videoUrl); // Debugging line
                        // die; // Terminate script execution
                        return '<video width="200" controls>
                                    <source src="' . $model->videopath . '" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>';
                    } else {
                        return 'No video available';
                    }
                }
            ],
            



            [
                'label' => 'Status',
                'contentOptions' => ['style' => 'width: 5%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status == 1) {
                        return 'Active';
                    } elseif ($model->status == 2) {
                        return 'Suspended';
                    }
                    return '';
                }
            ],
        ],
    ]) ?>

</div>