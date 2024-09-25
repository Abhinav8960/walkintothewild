<?php

use common\models\cms\blog\BlogTag;
use yii\helpers\Url;

$tags = BlogTag::find()->where(['status' => BlogTag::STATUS_ACTIVE, 'blog_id' => $blog->id])->orderBy(['master_blog_tag_id' => SORT_ASC])->all();
?>
<div class="tags d-flex align-items-center flex-wrap gap-3">

    <?php if ($tags) {
        foreach ($tags as $tag) {
    ?>
            <a href="#" class="tags-button"><i class="fa-solid fa-tag pe-1"></i><?= $tag->blogtag->title ?></a>
    <?php }
    } ?>
</div>