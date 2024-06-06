<?php

use yii\widgets\Pjax;

$this->title = 'Feature Rare Exotic';
$this->params['breadcrumbs_home_url'] = '/cms/feature';
$this->params['breadcrumbs'][] =  ['label' => 'CMS', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<?php Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
]); ?>
<div class="card">
    <div class="card-body">
        <?= $this->render('_form', [
            'sequences' => $sequences,
        ]) ?>
    </div>
</div>
<?php Pjax::end(); ?>