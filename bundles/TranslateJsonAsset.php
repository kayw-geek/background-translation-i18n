<?php
/**
 * Created by PhpStorm.
 * @name:
 * @author: weikai
 * @date: dt
 */

namespace weikaiiii\backgroundTranslationI18n\bundles;
use yii\web\AssetBundle;


class TranslateJsonAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@weikaiiii/background-translation-i18n/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'stylesheets/translate-manager.css',
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
        'stylesheets/layer.css'
    ];

    public $js = [
        'javascripts/layer.js',
        'javascripts/helpers.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

