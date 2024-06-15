<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
?>
<div class="commentCount mb-4">
    <h6> Comments</h6>
</div>
<?php
if ($article_comments = $article->getArticlecomments()->andWhere(['status' => 1])->all()) {
    foreach ($article_comments as $article_comment) {
?>
        <div class="comments-persons">
            <div class="postcomment d-flex gap-3">
                <div class="avatar">
                    <img src="<?= $this->params['baseurl'] ?>/img/dpmain.png" alt="">
                </div>
                <div class="text_com">
                    <h6 class="nameavatr"><?= $article_comment->user->name ?></h6>
                    <p><?= $article_comment->comment ?></p>
                </div>
            </div>
        </div>
<?php }
} ?>
<?php if (Yii::$app->user->id) {  ?>
    <?php $form = ActiveForm::begin(['id' => 'reply-form']); ?>
    <div class="comments-persons">
        <div class="postcomment d-flex gap-3">
            <div class="avatar">
                <img src="<?= $this->params['baseurl'] ?>/img/dpmain.png" alt="">
            </div>
            <div class="text-area">
                <?= $form->field($model, 'comment')->textarea(['rows' => '5', 'placeholder' => 'Write a comment...', 'class' => 'form-control w-100'])->label(false) ?>
            </div>
        </div>
    </div>

    <div class="row justify-content-end comments-persons">
        <div class="col-12 col-sm-8 col-md-6">
            <div class="comment_button float-end ">
                <?= Html::submitButton('Post Comment', ['class' => 'post-comment']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
<?php } ?>