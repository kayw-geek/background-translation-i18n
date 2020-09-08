<?php
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use weikaiiii\backgroundTranslationI18n\bundles\TranslateJsonAsset;


/* @var $this \yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel lajax\translatemanager\models\searches\LanguageSearch */

$this->title = 'List of languages';
$this->params['breadcrumbs'][] = $this->title;
TranslateJsonAsset::register($this);
?>
<div id="languages">

    <?php
    Pjax::begin([
        'id' => 'languages',
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'language_id',
            'name_ascii',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {translate} {export} {delete}',
                'buttons' => [
                    'translate' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['translate-json/index', 'language_id' => $model->language_id], [
                            'title' =>'Translate',
                            'data-pjax' => '0',
                        ]);
                    },
                    'export' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', ['translate-json/export', 'language_id' => $model->language_id], [
                            'title' =>'Export',
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
        ],
    ]);
    Pjax::end();
    ?>
</div>