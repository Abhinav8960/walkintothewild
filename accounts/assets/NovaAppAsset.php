<?php

namespace accounts\assets;

use yii\web\AssetBundle;

class NovaAppAsset extends AssetBundle
{

    public $sourcePath = '@backend/themes/nova/assets/';
    public $css = [
        'css/icons.css',
        'css/skin-modes.css',
        'css/style-dark.css',
        'css/style-transparent.css',
        'css/style.css',
        'css/chat.css',
        'plugins/bootstrap/css/bootstrap.min.css',
        'plugins/perfect-scrollbar/p-scrollbar.css',
        'plugins/sidebar/sidebar.css',
        'plugins/select2/css/select2.min.css',
        'plugins/datatable/css/dataTables.bootstrap5.css',
        'plugins/datatable/css/buttons.bootstrap5.min.css',
        'plugins/datatable/responsive.bootstrap5.css',
        'https://uicdn.toast.com/editor/latest/toastui-editor.min.css',
        'https://uicdn.toast.com/tui-color-picker/latest/tui-color-picker.min.css',
        'https://uicdn.toast.com/editor-plugin-color-syntax/latest/toastui-editor-plugin-color-syntax.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $js = [
        'js/script.js',
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
        'https://code.highcharts.com/highcharts.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
    ];
}
