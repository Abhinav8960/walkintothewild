<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Emoji Assets frontend application asset bundle.
 */
class EmojiAsset extends AssetBundle
{
    public $sourcePath = '@frontend/themes/emoji/';
    public $publishOptions = [
        'forceCopy' => false,
    ];
    public $css = [
        'lib/css/emoji.css',
    ];

    public $js = [
        'lib/js/config.min.js',
        'lib/js/util.min.js',
        'lib/js/jquery.emojiarea.min.js',
        'lib/js/emoji-picker.min.js'


    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
