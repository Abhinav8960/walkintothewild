<?php

use common\models\cms\article\MasterArticleTopic;

$topics = MasterArticleTopic::find()->where(['status' => MasterArticleTopic::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all();
?>
<div class="topics_listing">
    <ul>
        <?php if ($topics) {
            foreach ($topics as $topic) {
        ?>
                <li><a href="/article?ArticleSearch%5Btopic_id%5D=&ArticleSearch%5Btopic_id%5D%5B%5D=<?= $topic->id ?>"><?= $topic->title ?> <i class="fa-solid fa-chevron-right"></i></a></li>

        <?php }
        } ?>
    </ul>
</div>