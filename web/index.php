<?php

// localhost dev
if ($_SERVER['SERVER_ADDR']=='127.0.0.1') {
    error_reporting(E_ALL);
    define('YII_DEBUG', true);
    $yii = dirname(__FILE__).'/../vendor/yiisoft/yii/framework/yii.php';
    $config=dirname(__FILE__).'/protected/config/dev.php';
} else { 
    // production
    define('YII_DEBUG', true);
    $yii = dirname(__FILE__).'/../vendor/yiisoft/yii/framework/yiilite.php';
    $config=dirname(__FILE__).'/protected/config/production.php';
}

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
