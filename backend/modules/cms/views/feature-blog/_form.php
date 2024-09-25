<?php

use common\interfaces\StatusInterface;
use common\models\cms\blog\Blog;
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
                    <th>Blog</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $form = ActiveForm::begin(['id' => 'blog-sequence-form']);
                $blog_ids = '0';
                for ($i = 1; $i <= 10; $i++) {
                    $blog = Blog::find()->where(['sequence' => $i])->limit(1)->one();
                    $selectedBlogId = isset($blog) ? $blog->id : null;

                ?>
                    <tr>
                        <td> <?= $i; ?></td>
                        <td> <?php
                                echo Html::dropDownList("BlogSequence[$i]", $selectedBlogId, GeneralModel::blogoptionfeature($blog_ids), [
                                    'class' => 'blog-dropdown',
                                    'data-index' => $i,
                                    'prompt' => 'Select',
                                    'onchange' => 'saveBlogSequence(this)',
                                ]);
                                ?></td>
                    </tr>
                <?php if ($selectedBlogId) {
                        $blog_ids .= "," . $selectedBlogId;
                    }
                }
                ActiveForm::end();
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$url = Url::to(['/cms/feature-blog/save-sequence']);
$js = <<< JS
function saveBlogSequence(select) {    
    $.ajax({
        type: 'POST',
        url: '{$url}',
        data:$("#blog-sequence-form").serialize(),
        success:function(data){
            location.reload();
        },
        dataType:'html'
    });
}
JS;
$this->registerJs($js, View::POS_END);
?>