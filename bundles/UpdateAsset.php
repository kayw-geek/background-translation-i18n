<?php
/**
 * Created by PhpStorm.
 * @name:
 * @author: weikai
 * @date: dt
 */

namespace weikaiiii\backgroundTranslationI18n\bundles;
use yii\web\AssetBundle;


class UpdateAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@weikaiiii/background-translation-i18n/assets';

    /**
     * @inheritdoc
     */


    public $js = [
        'javascripts/update.js',
        'javascripts/scan.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}

