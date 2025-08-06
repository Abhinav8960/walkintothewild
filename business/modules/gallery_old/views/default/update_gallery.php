<?php

$this->title = 'Update Gallery';
$this->params['title'] = $this->title;

?>

<?= $this->render('_gallery_form', [
    'model' => $model,
]) ?>
  
