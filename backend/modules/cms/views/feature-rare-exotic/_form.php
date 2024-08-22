<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\GeneralModel;
use common\models\master\animal\MasterAnimal;
?>
<div id="repository-container-header"></div>
<div class="row">
    <div class="col-md-12 table-responsive">
        <table class="table table-striped table-bordered table_design">
            <thead>
                <tr>
                    <th style="width: 5%!important;">Sr. No.</th>
                    <th>Park</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $form = ActiveForm::begin(['id' => 'park-sequence-form']);
                $rare_ids = '0';
                for ($i = 1; $i <= 10; $i++) {
                    $rare_animal = MasterAnimal::find()->where(['is_feature_sequence' => $i, 'animal_type' => MasterAnimal::RARE_ANIMAL_TYPE])->limit(1)->one();
                    $selectedParkId = isset($rare_animal) ? $rare_animal->id : null;

                ?>
                    <tr>
                        <td> <?= $i; ?></td>
                        <td> <?php
                                echo Html::dropDownList("AnimalSequence[$i]", $selectedParkId, GeneralModel::safariAnimalRareExoticOption($rare_ids), [
                                    'class' => 'park-dropdown',
                                    'data-index' => $i,
                                    'prompt' => 'Select Animal',
                                    'onchange' => 'saveParkSequence(this)',
                                ]);
                                ?></td>
                    </tr>
                <?php if ($selectedParkId) {
                        $rare_ids .= "," . $selectedParkId;
                    }
                }
                ActiveForm::end();
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$url = Url::to(['/cms/feature-rare-exotic/save-sequence']);
$js = <<< JS
function saveParkSequence(select) {    
    $.ajax({
        type: 'POST',
        url: '{$url}',
        data:$("#park-sequence-form").serialize(),
        success:function(data){
            location.reload();
        },
        dataType:'html'
    });
}
JS;
$this->registerJs($js, View::POS_END);
?>