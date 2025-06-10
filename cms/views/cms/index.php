<?php

/** @var yii\web\View $this */

use common\models\GeneralModel;

$this->title = 'CMS';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>404 Not Found</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
  <div class="text-center px-6">
    <h1 class="text-7xl font-extrabold text-green-600">404</h1>
    <p class="mt-4 text-2xl font-semibold text-gray-800">Page not found</p>
    <p class="mt-2 text-gray-600">Sorry, the page you're looking for doesn't exist or has been moved.</p>
  </div>
</body>
</html>
