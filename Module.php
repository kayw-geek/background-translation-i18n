<?php

namespace weikaiiii\backgroundTranslationI18n;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Class Module
 * @package weikaiiii\backgroundTranslationI18n
 * @name:翻译主模块
 * @author: weikai
 * @date: 20.9.7 13:43
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'weikaiiii\backgroundTranslationI18n\controllers';

    /**
     * @inheritdoc
     */
    public $defaultRoute = 'language-json/index';


    /**
     * @var array the list of IPs that are allowed to access this module.
     */
    public $allowedIPs = ['127.0.0.1', '::1'];

    public $connection = 'db';


    /**
     * @var string The database table storing the languages.
     */
    public $languageTable = '{{%language-key}}';

    public $source_lang = 'en-US';


    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($this->checkAccess()) {
            return parent::beforeAction($action);
        } else {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }
    }

    /**
     * @return bool whether the module can be accessed by the current user
     */
    public function checkAccess()
    {
        Yii::setAlias('@weikaiiii',dirname(__DIR__));
        $ip = Yii::$app->request->getUserIP();
        foreach ($this->allowedIPs as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
                return true;
            }
        }
        Yii::warning('Access to Translate is denied due to IP address restriction. The requested IP is ' . $ip, __METHOD__);

        return false;
    }

}
