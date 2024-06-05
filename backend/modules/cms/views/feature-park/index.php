<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Feature Park';
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