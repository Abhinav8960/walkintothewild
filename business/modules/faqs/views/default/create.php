<?php
$this->title = 'FAQ';
$this->params['title'] = $this->title;
?>


<?= $this->render('_form', [
    'model' => $model,
    'safari_operator' => $safari_operator,
]) ?>