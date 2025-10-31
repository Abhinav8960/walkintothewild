<?php

namespace developer\assets;

use yii\web\AssetBundle;

class NovaAppAsset extends AssetBundle
{

    public $sourcePath = '@developer/themes/nova/assets/';
    public $css = [
        'css/icons.css',
        'css/skin-modes.css',
        'css/style.css',
        
    ];
    public $publishOptions = [
        'forceCopy' => false,
    ];
    public $js = [
        'js/script.js',
        'plugins/accordion/accordion.min.js',
        'plugins/bootstrap/js/popper.min.js',
        'plugins/chart.js/Chart.bundle.min.js',
        'plugins/ionicons/ionicons.js',
        'plugins/moment/moment.js',
        'js/apexcharts.js',
        'plugins/jquery-sparkline/jquery.sparkline.min.js',
        'plugins/raphael/raphael.min.js',
        'plugins/perfect-scrollbar/perfect-scrollbar.min.js',
        'js/eva-icons.min.js',
        'plugins/sidebar/sidebar.js',
        'plugins/sidebar/sidebar-custom.js',
        'plugins/side-menu/sidemenu.js',
        'js/sticky.js',
        'plugins/notify/js/notifIt.js',
        'js/circle-progress.min.js',
        'js/chart-circle.js',
        'js/apexcharts.js',
        'plugins/chart.js/Chart.bundle.min.js',
        'js/custom.js',
        'plugins/datatable/js/jquery.dataTables.min.js',
        'plugins/datatable/js/dataTables.bootstrap5.js',
        'plugins/datatable/dataTables.responsive.min.js',
        'plugins/datatable/responsive.bootstrap5.min.js',
        'js/themecolor.js',
        'https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js',
        'https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js',
        'https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js',
        'https://uicdn.toast.com/tui-color-picker/latest/tui-color-picker.min.js',
        'https://uicdn.toast.com/editor-plugin-color-syntax/latest/toastui-editor-plugin-color-syntax.min.js',
        'https://uicdn.toast.com/editor-plugin-code-syntax-highlight/latest/toastui-editor-plugin-code-syntax-highlight.min.js',
        'https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js',
        'https://code.highcharts.com/highcharts.js',
        
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
    ];
}
