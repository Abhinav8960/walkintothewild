<?php

namespace business\assets;

use yii\web\AssetBundle;

class PartnerAppAsset extends AssetBundle
{

    public $sourcePath = '@business/partnertheme/nova/assets/';
    public $css = [
        'css/main.css',
        'css/core.css',
        'css/custom.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css',
        'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $js = [
        // 'node_modules/bootstrap/dist/js/bootstrap.js',
        // 'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
        // 'https://code.jquery.com/jquery-3.6.1.js',
        'js/main.js',
        'js/custom.js',
        'https://cdn.jsdelivr.net/npm/sweetalert2@11',
    ];

    public $depends = [
        // 'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
    ];
}
