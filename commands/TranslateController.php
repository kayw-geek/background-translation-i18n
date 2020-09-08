<?php

namespace  weikaiiii\backgroundTranslationI18n\commands;

use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class TranslateController
 * @package weikaiiii\backgroundTranslationI18n\commands
 * @name:console
 * @author: weikai
 * @date: 20.9.8 11:51
 */
class TranslateController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'help';

    /**
     * Display this help.
     */
    public function actionHelp()
    {
        $this->run('/help', [$this->id]);
    }


   
}
