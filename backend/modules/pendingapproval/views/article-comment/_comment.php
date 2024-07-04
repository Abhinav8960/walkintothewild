<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
?>
<div class="commentCount mb-4">
    <h6> Comments</h6>
</div>
<?php
if ($article_comments = $article->getArticlecomments()->andWhere(['status' => 3])->all()) {
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

                <div class="text_com">
                    <?= Html::a('Approve', ['approved', 'id' => $article_comment->id], ['class' => 'btn btn-success']); ?>
                    <?= Html::a('Reject', ['disapproved', 'id' => $article_comment->id], ['class' => 'btn btn-danger']); ?>
                </div>

            </div>
        </div>
<?php }
} ?>