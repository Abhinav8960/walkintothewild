<?php

use yii\helpers\Url;
use common\models\notification\FrontendNotification;

?>

<h6 class="fs-5 fw-semibold px-3 pt-3 pb-3 border-bottom mb-3">Notifications</h6>
<?php

$notification_list = FrontendNotification::find()->where(['status' => 1, 'user_id' => Yii::$app->user->identity->id])->orderby(['id' => SORT_DESC])->limit(6)->all();
?>
<ul>
    <?php if ($notification_list) {
        foreach ($notification_list as $notification) { ?>
            <li class="<?= $notification->noticeclass ?>">

                <a href="<?= Url::toRoute(['/account/notification/view', 'id' => $notification->id]) ?>">
                    <?= $notification->notification_text ?>
                    <span class=" fss-3"><?= Yii::$app->formatter->format($notification->created_at, 'relativeTime') ?></span>
                </a>
            </li>
    <?php }
    } else {
        echo '<li class="px-3">No New Notification!</li>';
    } ?>
</ul>
<div class="viewallNotification float-end pe-3 pt-2">
    <a href="/account/notification" class="follow_massge ms-3">View all notifications</a>
</div>