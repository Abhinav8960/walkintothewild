<?php

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
    <div class="col-12 mb-3">
        <div class="filterBar">
            <div class="filters">

                <div class="filterItem position-relative">
                    <label>Share Safari:</label>

                    <?= $form->field($model, 'share_safari_id')->dropDownList(
                        ShareSafariCommentSearch::getSafarilist(),
                        [
                            'prompt' => 'Select Share Safari',
                        ]
                    ) ?>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

            </div>

        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
    $('form') . on('change', function() {
        $(this) . closest('form') . submit();
    });  
JS;
$this->registerJs($js);
?>