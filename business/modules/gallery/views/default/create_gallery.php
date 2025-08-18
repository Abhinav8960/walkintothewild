<?php

$this->title = 'Create Gallery';
$this->params['title'] = $this->title;

?>

<?= $this->render('_gallery_form', [
    'model' => $model,
]) ?>
       