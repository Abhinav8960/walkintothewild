<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin(['id' => 'comment-form']); ?>
<div class="comments-persons pe-0 pt-4">
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
<div class="row justify-content-end pt-3">
    <div class="col-lg-9 col-xl-8">
        <div class="post_text">
            <p>Commenting on this thread will notify all event attendees and will also be visible to
                everyone viewing the event.</p>
        </div>
    </div>
    <div class="col-lg-4 col-xl-3 ">
        <div class="comment_button float-end mb-lg-0 mb-3">
            <?= Html::submitButton('Post Comment', ['class' => 'post-comment']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>