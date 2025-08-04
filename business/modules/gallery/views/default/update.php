<?php

$this->title = 'Update Gallery';
// $this->params['title'] = $this->title;

?>

<?= $this->render('_form', [
    'model' => $model,
    'safari_operator_model' => $safari_operator_model,
]) ?>
      