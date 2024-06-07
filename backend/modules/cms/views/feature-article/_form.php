<?php

use common\interfaces\StatusInterface;
use common\models\cms\article\Article;
use common\models\GeneralModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\View;


?>
<div class="row">
    <div class="col-md-12 table-responsive">
        <table class="table table-striped table-bordered table_design">
            <thead>
                <tr>
                    <th style="width: 5%!important;">Sr. No.</th>
                    <th style="width: 20%!important;">Article</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $allArticles = Article::findAll(['status' => StatusInterface::STATUS_ACTIVE]);
                $countAllArticle = count($allArticles);

                $length = '';
                if ($countAllArticle < 8) {
                    $length = $countAllArticle;
                } else {
                    $length = 8;
                }

                $form = ActiveForm::begin(['id' => 'article-sequence-form']);
                for ($i = 1; $i <= $length; $i++) {
                    $article = Article::find()->where(['sequence' => $i])->limit(1)->one();
                    $selectedArticleId = isset($article) ? $article->id : null;
                ?>
                    <tr>
                        <td> <?= $i; ?></td>
                        <td> <?php
                                echo Html::dropDownList("ArticleSequence[$i]", $selectedArticleId, GeneralModel::articleoption(), [
                                    'class' => 'article-dropdown',
                                    'data-index' => $i,
                                    'prompt' => 'Select',
                                    'onchange' => 'saveArticleSequence(this)',
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
$url = Url::to(['/cms/feature-article/save-sequence']);
$csrfToken = Yii::$app->request->csrfToken;
$js = <<< JS
function saveArticleSequence(select) {
    var selectedIndex = select.selectedIndex;
    var selectedValue = select.options[selectedIndex].value;
    var index = select.getAttribute('data-index');
    var formData = new FormData();
    formData.append('sequenceIndex', index);
    formData.append('articleId', selectedValue);
    
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