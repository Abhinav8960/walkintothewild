<?php

use common\models\cms\article\MasterArticleTag;

$tags = MasterArticleTag::find()->where(['status' => MasterArticleTag::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all();
?>
<div class="tags d-flex align-items-center flex-wrap gap-3">

    <?php if ($tags) {
        foreach ($tags as $tag) {
    ?>
            <a href="/article?ArticleSearch%5article_tag_idd%5D=&ArticleSearch%5Barticle_tag_id%5D%5B%5D=<?= $tag->id ?>" class="tags-button" style="color:black;"><?= $tag->title ?></a>
    <?php }
    } ?>
</div>