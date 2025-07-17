<?php

use common\models\operator\SafariOperator;
use common\models\User;
use yii\bootstrap5\LinkPager;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Chat';
$this->params['title'] = $this->title;
?>

<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Chat List</h5>
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
            <div class="card-body p-2" style="height: 700px; overflow-y: auto;">
                <?php foreach ($dataProvider->models as $chat){ ?>
                    <?php
                    $url = Url::to(['/chat/default/view','chat_id'=>$chat->id, 'user_id' => $chat->user_id, 'recipient_id' => $chat->recipient_user_id]);
                    ?>
                    <a href="javascript:void(0);" style="text-decoration:none" class="chat-box-link" data-url="<?= $url ?>">
                        <?php if($chat->chat_type == 2){?>
                        <div class="card mb-2 shadow-sm p-2 hover-shadow" style="cursor: pointer; background-color:rgb(215, 215, 215) !important;">
                            <div class="d-flex align-items-center">
                                <img src="<?= $chat->user && $chat->user->profile_display_image ? $chat->user->profile_display_image : $this->params['baseurl'] . '/img/dpmain.png' ?>"
                                    class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <strong><?= Html::encode($chat->displayLabelUser) ?></strong>
                                </div>
                                <strong class="fs-2 mb-3">↔</strong>
                                <img src="<?= $chat->recipient && $chat->recipient->profile_display_image ? $chat->recipient->profile_display_image : $this->params['baseurl'] . '/img/dpmain.png' ?>"
                                    class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <strong><?= Html::encode($chat->displayLabelRecipient) ?></strong>
                                </div>
                            </div>
                            <div class="recievedTime d-flex justify-content-end">
                                    <span><?= date('Y-m-d h:i A', $chat->last_message_at) ?></span>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="card mb-2 shadow-sm p-2 hover-shadow" style="cursor: pointer;">
                            <div class="d-flex align-items-center">
                                <img src="<?= $chat->user && $chat->user->profile_display_image ? $chat->user->profile_display_image : $this->params['baseurl'] . '/img/dpmain.png' ?>"
                                    class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <strong><?= Html::encode($chat->displayLabelUser) ?></strong>
                                </div>
                                <strong class="fs-2 mb-3">↔</strong>
                                <img src="<?= $chat->recipient && $chat->recipient->profile_display_image ? $chat->recipient->profile_display_image : $this->params['baseurl'] . '/img/dpmain.png' ?>"
                                    class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <strong><?= Html::encode($chat->displayLabelRecipient) ?></strong>
                                </div>
                            </div>
                            <div class="recievedTime d-flex justify-content-end">
                                    <span><?= date('Y-m-d h:i A', $chat->last_message_at) ?></span>
                            </div>
                        </div>
                        <?php } ?>
                    </a>
                <?php } ?>

                <!-- Pagination links -->
                <div class="mt-2">
                    <?= LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                        'options' => ['class' => 'pagination justify-content-center'],
                        'linkOptions' => ['class' => 'page-link'],
                        'maxButtonCount'=>5,
                        'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link']
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm">
            <!-- <div class="card-header">
            </div> -->
            <div class="card-body p-0" style="height: 790px; overflow-y: auto;">
                <?php  Pjax::begin(['id' => 'user-detail-content']); ?>
                <div id="user-detail-content">
                    <div class="text-center p-5 text-muted">Please select a chat to preview</div>
                </div>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<<JS
$(document).on('click', '.chat-box-link', function(e) {
    e.preventDefault();
    var url = $(this).data('url');
    $('#user-detail-content').html('<div class="text-center py-5">Loading...</div>');

    $.pjax({
        url: url,
        container: '#user-detail-content',
        push: false,
        replace: false,
        timeout: 10000
    });
});

$(document).on('mouseenter', '.hover-shadow', function(){
    $(this).css({
        'transform': 'scale(1.03)',
        'box-shadow': '0 8px 20px rgba(0,0,0,0.2)'
    });
});
$(document).on('mouseleave', '.hover-shadow', function(){
    $(this).css({
        'transform': '',
        'box-shadow': ''
    });
});

JS;
$this->registerJs($script);
?>