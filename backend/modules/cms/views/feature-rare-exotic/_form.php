<?php

use common\interfaces\StatusInterface;
use common\models\GeneralModel;
use common\models\park\SafariPark;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\View;

// Assuming $parks is an array of park data and $sequences is the current sequence data

?>
<div class="row">
    <div class="col-md-12 table-responsive">
        <table class="table table-striped table-bordered table_design">
            <thead>
                <tr>
                    <th style="width: 5%!important;">Sr. No.</th>
                    <th style="width: 20%!important;">Park</th>

                </tr>
            </thead>
            <tbody>
                <?php

                $allSafariParks = SafariPark::findAll(['status' => StatusInterface::STATUS_ACTIVE]);
                $countAllSafariPark = count($allSafariParks);

                $length = '';
                if ($countAllSafariPark < 5) {
                    $length = $countAllSafariPark;
                } else {
                    $length = 5;
                }

                $form = ActiveForm::begin(['id' => 'park-sequence-form']);
                for ($i = 1; $i <= $length; $i++) {
                    $park = SafariPark::find()->where(['animal_type_sequence' => $i])->limit(1)->one();
                    $selectedParkId = isset($park) ? $park->id : null;
                ?>
                    <tr>
                        <td> <?= $i; ?></td>
                        <td> <?php
                                echo Html::dropDownList("ParkSequence[$i]", $selectedParkId, GeneralModel::safariParkRareExoticOption(), [
                                    'class' => 'park-dropdown',
                                    'data-index' => $i,
                                    'prompt' => 'Select',
                                    'onchange' => 'saveParkSequence(this)',
                                ]);
                                ?></td>
                    </tr>
                <?php }
                ActiveForm::end();
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$url = Url::to(['/cms/feature-rare-exotic/save-sequence']);
$csrfToken = Yii::$app->request->csrfToken;
$js = <<< JS
function saveParkSequence(select) {
    var selectedIndex = select.selectedIndex;
    var selectedValue = select.options[selectedIndex].value;
    var index = select.getAttribute('data-index');
    var formData = new FormData();
    formData.append('sequenceIndex', index);
    formData.append('parkId', selectedValue);
    
    fetch('$url', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-Token': '$csrfToken' // Include CSRF token in the request headers
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Sequence saved successfully:', data);
        // You can perform any UI updates or show a success message here
    })
    .catch(error => {
        console.error('There was a problem saving the sequence:', error);
        // Handle errors or show an error message
    });
}
JS;
$this->registerJs($js, View::POS_END); // Ensure script is placed at the end of the page
?>