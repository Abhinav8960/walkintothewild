<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Notify Assets bundle.
 */
class NotifyAsset extends AssetBundle
{
    public $sourcePath = '@common/themes/notify/';
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $css = [
        'css/notifIt.css',
    ];

    public $js = [
        'js/notifIt.js',
        'https://js.pusher.com/8.2.0/pusher.min.js'
    ];

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
