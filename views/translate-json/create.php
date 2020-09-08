<?php

use yii\helpers\Html;
use weikaiiii\backgroundTranslationI18n\models\Language;

/* @var $this yii\web\View */
/* @var $model common\models\TranslateJsonKey */
$css = <<<CSS
[hidden] {
  display: none !important;
}
CSS;
$this->registerCss($css);
$this->title = 'Upload Json File';
$this->params['breadcrumbs'][] = ['label' => 'Translate Json Keys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translate-json-key-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

    <?= $form->field($model, 'file')->fileInput(['class'=>'btn btn-default','accept'=>'.json'])->label('Choose to translate the source file') ?>
    <?= $form->field($model, 'lang_code')->dropDownList(Language::getLanguageNames(),['value'=>Yii::$app->getModule('translate')->source_lang])->label('lang_code')->label('Source Lang Code') ?>

    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>

</div>
