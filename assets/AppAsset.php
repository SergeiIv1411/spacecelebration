<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0å
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    'https://fonts.googleapis.com/css?family=Hind:400,700',
//'css/bootstrap.min.css',
    'css/slick.css',
    'css/slick-theme.css',
    'css/nouislider.min.css',
    'css/font-awesome.min.css',
    'css/style.css',
    ];
    public $js = [
 //       'js/jquery.min.js',
 //       'js/bootstrap.min.js',
        'js/slick.min.js',
        'js/nouislider.min.js',
        'js/jquery.zoom.min.js',
        'js/jquery.cookie.js',
        'js/jquery.accordion.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
