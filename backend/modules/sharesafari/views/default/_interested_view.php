<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
?>
<div class="users_profile gap-3 align-items-center">

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "\n{items}\n{pager}\n{summary}",
        'id' => 'grid-data',
        'summary' => "Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> intersted users",
        'tableOptions' => ['class' => 'table table-striped'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'width: 5%'],
                'header' => "S.No"
            ],
            [
                'label' => 'User',
                'contentOptions' => ['style' => 'width: 20%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    if ($user = $model->user) {
                        return Html::img($user->avatar != '' ? $user->avatar : '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $user->name;
                    }
                    return $model->user_id;
                }
            ],
            [
                'header' => 'Join At',
                'value' => function ($model) {
                    return date('Y-m-d', $model->intrested_at);
                },
                'contentOptions' => ['style' => 'width: 10%'],
            ]
        ],
    ]);
    ?>

</div>
<?php Pjax::end(); ?>