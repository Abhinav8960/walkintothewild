<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */
/** @var Exception$exception */

use yii\helpers\Html;
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = $name;
?>
<div class="site-error errorPage" style="min-height: 700px;" >
<div class="imgsbox pt-3">
<a href="/"><img src="<?= $this->params['baseurl'] ?>/img/404 error with people holding the numbers-pana.svg" alt="" class="w-100"></a>

</div>
 <!-- <h1 class="title">404</h1>
 <h3>We can't found the page you are looking for</h3> -->
</div>