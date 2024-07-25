<?php

use common\models\cms\article\ArticleCommentSearch;
use common\models\GeneralModel;
use common\models\park\SafariPark;
use common\models\sharesafari\ShareSafari;
use common\models\sharesafari\ShareSafariCommentSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'action' => ['index'],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'article_id')->dropDownList(
            ArticleCommentSearch::getArticlelist(),
            [
                'prompt' => 'Select Article',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'flaged')->dropDownList(
            ['0' => 'Not Flaged', '1' => 'Flaged'],
            [
                'prompt' => 'Select Status of Flaged',
            ]
        ) ?>
    </div>
    <div class="col-md-2">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>