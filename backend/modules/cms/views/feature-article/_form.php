<?php


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
                    <th>Article</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $form = ActiveForm::begin(['id' => 'article-sequence-form']);
                $article_ids = '0';
                for ($i = 1; $i <= 10; $i++) {
                    $article = Article::find()->where(['sequence' => $i])->limit(1)->one();
                    $selectedArticleId = isset($article) ? $article->id : null;

                ?>
                    <tr>
                        <td> <?= $i; ?></td>
                        <td> <?php
                                echo Html::dropDownList("ArticleSequence[$i]", $selectedArticleId, GeneralModel::articleoptionfeature($article_ids), [
                                    'class' => 'article-dropdown',
                                    'data-index' => $i,
                                    'prompt' => 'Select',
                                    'onchange' => 'saveArticleSequence(this)',
                                ]);
                                ?></td>
                    </tr>
                <?php if ($selectedArticleId) {
                        $article_ids .= "," . $selectedArticleId;
                    }
                }
                ActiveForm::end();
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$url = Url::to(['/cms/feature-article/save-sequence']);
$js = <<< JS
function saveArticleSequence(select) {    
    $.ajax({
        type: 'POST',
        url: '{$url}',
        data:$("#article-sequence-form").serialize(),
        success:function(data){
            location.reload();
        },
        dataType:'html'
    });
}
JS;
$this->registerJs($js, View::POS_END);
?>