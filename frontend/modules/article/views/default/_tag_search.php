<?php

use common\models\cms\article\MasterArticleTag;
use yii\helpers\Url;

$tags = MasterArticleTag::find()->where(['status' => MasterArticleTag::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all();
?>
<div class="tags d-flex align-items-center flex-wrap gap-sm-3 gap-1">

    <?php if ($tags) {
        foreach ($tags as $tag) {
    ?>
            <a href="<?= Url::toRoute(['/article/default/tag', 'slug' => $tag->slug]) ?>" class="tags-button" style="color:black;"><i class="fa-solid fa-tag pe-1" ></i><?= $tag->title ?></a>
    <?php }
    } ?>
</div>
