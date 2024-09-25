<?php

use common\models\cms\mastercategory\MasterTopic;
use yii\helpers\Url;

$topics = MasterTopic::find()->where(['status' => MasterTopic::STATUS_ACTIVE])->orderBy(['title' => SORT_ASC])->all();
?>
<div class="topics_listing">
    <ul>
        <div class="row gx-lg-0 gx-sm-5">
        <?php if ($topics) {
            foreach ($topics as $topic) {
        ?>
        <div class="col-lg-12 col-sm-6">
        <li><a href="<?= Url::toRoute(['/article/default/topic', 'slug' => $topic->slug]) ?>" class="link"><?= $topic->title ?> <i class="fa-solid fa-chevron-right"></i></a></li>
        </div>
                

        <?php }
        } ?>
        </div>
     
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