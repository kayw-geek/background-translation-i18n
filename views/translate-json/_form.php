<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TranslateJsonKey */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="translate-json-key-form">
    <?php
    $lang = [
    'zh-CN' => '中文',
    'ja-JP' => '日文',
    ];
    ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lang_code')->dropDownList($lang)->label('目标语言') ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true])->label('译文') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
