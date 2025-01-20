<?php

use yii\helpers\Url;
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
                'contentOptions' => ['style' => 'width: 10%'],
                'header' => "S.No"
            ],
            [
                'header' => 'Name',
                'value' => function ($model) {
                    $profile_base_image = $this->params['baseurl'] . '/img/Share-Safari/dpinterested.png';
                    $profile_base_image = $model->user && $model->user->profileimage <> "" ? $model->user->profileimage : $profile_base_image;
                    $username = $model->user ? $model->user->name : '';
                    return \yii\helpers\Html::a('
                     <div class="profileavtar">
                                    <img src="' . $profile_base_image . '" alt="" class="rounded-circle" title="' . $username . '">
                                    ' . $username . '
                                </div>
                    
                    ', ['/profile/default/index', 'user_handle' => $model->user ? $model->user->user_handle : ''], ['style' => "color:inherit;", 'data-pjax' => "0"]);
                },
                'format' => 'raw'
            ],
            [
                'header' => 'Join At',
                'value' => function ($model) {
                    return date('Y-m-d', $model->intrested_at);
                },
                'contentOptions' => ['style' => 'width: 20%'],
            ]
        ],
    ]);
    ?>

</div>
<?php Pjax::end(); ?>