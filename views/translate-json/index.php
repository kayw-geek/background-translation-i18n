<?php

use yii\helpers\Html;
use yii\grid\GridView;
use weikaiiii\backgroundTranslationI18n\bundles\TranslateJsonAsset;
use weikaiiii\backgroundTranslationI18n\bundles\UpdateAsset;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\TranslateJsonKeyModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Translates';
$this->params['breadcrumbs'][] = $this->title;
TranslateJsonAsset::register($this);
UpdateAsset::register($this);
?>

<div class="translate-json-key-index" id="translates">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>

        <?= Html::a('Upload Json File', ['create'], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Export json File', [ 'export' ], [ 'class' => 'btn btn-success' ]); ?>
    </p>

    <?php
    \yii\widgets\Pjax::begin([
        'id' => 'translates',
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'attribute' => 'category_name',
                'filterInputOptions' => ['class' => 'form-control', 'id' => 'category'],
            ],
            [
                'format' => 'raw',
                'attribute' => 'value',
                'filterInputOptions' => ['class' => 'form-control', 'id' => 'message'],
                'label' => 'Source ('.Yii::$app->getModule('translate')->source_lang.')',
                'content' => function ($data) {
                    $datas =  weikaiiii\backgroundTranslationI18n\models\TranslateJsonValue::find()
                        ->where(['key_id'=>$data->id,'lang_code'=>Yii::$app->getModule('translate')->source_lang])
                        ->asArray()
                        ->one();
                    return Html::textarea('LanguageSource[' . $datas['id'] . ']', $datas['value'], ['class' => 'form-control source', 'readonly' => 'readonly']);
                },
            ],
            [
                'format' => 'raw',
                'attribute' => 'value_i18n',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'id' => 'translation_i18n',
                    'placeholder' =>'Enter "{command}" to search for empty translations.',
                ],
                'label' => 'Translation ('.$lang_id.')',
                'content' => function ($data) use($lang_id) {
                    $datas =  weikaiiii\backgroundTranslationI18n\models\TranslateJsonValue::find()
                        ->where(['key_id'=>$data->id,'lang_code'=>$lang_id])
                        ->asArray()
                        ->one();
                    return Html::textarea('LanguageTranslate[' . $datas['id'] . ']', $datas['value'], ['class' => 'form-control translation', 'data-id' => $data->id, 'tabindex' => $data->id]);
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Action',
                'content' => function ($data) {
                    return Html::button('Save', ['type' => 'button', 'id'=>'ja-save', 'data-id' => $data->id, 'class' => 'btn btn-lg btn-success']);
                },
            ],

        ],
        'options' => ['style'=>'max-width: 1600px;overflow: auto;']

    ]);
    \yii\widgets\Pjax::end();
    ?>
</div>

