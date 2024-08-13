<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
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
                    <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $article_comment->user && $article_comment->user->user_handle <> '' ? $article_comment->user->user_handle : '']) ?>">
                        <img src="<?= $article_comment->user && $article_comment->user->avatar <> '' ? $article_comment->user->avatar : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
                    </a>
                </div>
                <div class="text_com">
                    <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $article_comment->user && $article_comment->user->user_handle <> '' ? $article_comment->user->user_handle : '']) ?>">
                        <h6 class="nameavatr"><?= isset($article_comment->user) ? $article_comment->user->name : "" ?></h6>
                    </a>
                    <p><?= $article_comment->comment ?></p>
                </div>
                <div class="objec-flgs">
                    <?php if (Yii::$app->user->id) {  ?>
                        <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="" class="flagBtn" value="<?= Url::toRoute(['/article/default/flag', 'slug' => $article->slug, 'article_comment_id' => $article_comment->id]) ?>">
                    <?php } ?>
                </div>
            </div>
        </div>
<?php }
} ?>
<?php if (Yii::$app->user->id) {
    if ($article->comment_allowed == 1) {  ?>
        <?php $form = ActiveForm::begin(['id' => 'reply-form']); ?>
        <div class="comments-persons">
            <div class="postcomment d-flex gap-3">
                <div class="avatar">
                    <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => Yii::$app->user->identity && Yii::$app->user->identity->user_handle <> '' ? Yii::$app->user->identity->user_handle : '']) ?>">
                        <img src="<?= Yii::$app->user->identity && Yii::$app->user->identity->avatar <> '' ? Yii::$app->user->identity->avatar : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
                    </a>
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
<?php } else {
        echo '<p class="text-center">Comment are not allowed!!!</p>';
    }
} else {
    echo '<p class="px-3 pt-2 text-center">Please <a href="/site/login?authclient=google&referrer=/article/' . $article->slug . '" class="sign_intext parkrevieBtn text-center">Sign in</a> to Comment</p>';
} ?>

<?php
$script = <<< JS
    $(document).ready(function(){
        setTimeout(function() {
    $('#info').fadeOut('fast');
}, 3000);
});
JS;
$this->registerJs($script);
?>

<style>
    .alert-success {
        display: none !important;
    }
</style>


<?php
$script = <<< JS

function writeareviewfunction() {
    $('.flagBtn').on('click', function () {
        $('#modalFlag').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
writeareviewfunction();     
JS;
$this->registerJs($script);
?>