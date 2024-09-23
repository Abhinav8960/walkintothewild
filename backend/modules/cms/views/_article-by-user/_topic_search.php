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
                <li><a href="#" class="link"><?= $topic->title ?> <i class="fa-solid fa-chevron-right"></i></a></li>

        <?php }
        } ?>
    </ul>
</div>



<?php
$script = <<<JS
   var checkvalue= window.location.pathname;
   $(".link").each(function(){
    if($(this).attr('href')== checkvalue){ 
    $(this).addClass("active");
    }
});
JS;
$this->registerJs($script);
?>

<style>
    .link.active {
        background-color: #09422D !important;
        color: white !important;
        border-radius: 5px !important;
        margin: auto !important;
        padding: 7px 8px;

    }
    .link.active i{

        color: #fff;
    }
    
</style>