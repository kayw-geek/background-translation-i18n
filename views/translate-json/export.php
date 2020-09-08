<?php
use weikaiiii\backgroundTranslationI18n\models\Language;
?>

<div class="translate-json-key-form">
    <?php $form = \yii\widgets\ActiveForm::begin(); ?>
    <h1> Please select the language to export</h1>
    <?= $form->field($model, 'lang_code')->dropDownList(Language::getLanguageNames(),['value'=>Yii::$app->request->get('language_id')])->label('lang_code')->label('Lang Code List') ?>

    <div class="form-group">
        <?= \yii\helpers\Html::submitButton('Export', ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>

</div>
