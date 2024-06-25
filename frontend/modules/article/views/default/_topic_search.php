<?php

use common\models\cms\article\MasterArticleTopic;
use yii\helpers\Url;

$topics = MasterArticleTopic::find()->where(['status' => MasterArticleTopic::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all();
?>
<div class="topics_listing">
    <ul>
        <?php if ($topics) {
            foreach ($topics as $topic) {
        ?>
                <li><a href="<?= Url::toRoute(['/article/default/topic', 'slug' => $topic->slug]) ?>"><?= $topic->title ?> <i class="fa-solid fa-chevron-right"></i></a></li>

        <?php }
        } ?>
    </ul>
</div>