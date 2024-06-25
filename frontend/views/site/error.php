<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */
/** @var Exception$exception */

use yii\helpers\Html;

$this->title = $name;
?>
<?php
if ($exception->statusCode == 404) {
    echo $this->render('_error_404', ['message' => $message, 'exception' => $exception, 'name' => $name]);
} else { ?>
    <div class="site-error">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p>
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please contact us if you think this is a server error. Thank you.
        </p>

    </div>
<?php  } ?>