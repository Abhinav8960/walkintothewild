<?php

namespace support\assets;

use yii\web\AssetBundle;

/**
 * Main support application asset bundle.
 */
class WhatsappAsset extends AssetBundle
{

    public $sourcePath = '@support/themes/nova/assets/';

    public $publishOptions = [
        'forceCopy' => false,
    ];
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/whatsapp.css',
    ];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
