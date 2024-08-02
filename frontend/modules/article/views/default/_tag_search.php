<?php

use common\models\cms\article\ArticleTag;
use yii\helpers\Url;

$tags = ArticleTag::find()->where(['status' => ArticleTag::STATUS_ACTIVE, 'article_id' => $article->id])->orderBy(['master_article_tag_id' => SORT_ASC])->all();

?>
<div class="tags d-flex align-items-center flex-wrap gap-sm-2 gap-1">

    <?php if ($tags) {
        foreach ($tags as $tag) {
    ?>
            <a href="<?= Url::toRoute(['/article/default/tag', 'slug' => isset($tag->articletag) ? $tag->articletag->slug : ""]) ?>" class="tags-button"><i class="fa-solid fa-tag pe-1"></i><?= $tag->articletag->title ?></a>
    <?php }
    } ?>
</div>