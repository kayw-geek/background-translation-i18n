<?php

use yii\helpers\Html;
use yii\grid\GridView;
use weikaiiii\backgroundTranslationI18n\bundles\TranslateJsonAsset;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\TranslateJsonKeyModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Translates';
$this->params['breadcrumbs'][] = $this->title;
TranslateJsonAsset::register($this,['position' => \yii\web\View::POS_READY]);

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
<script>
    var helpers = (function () {

        /**
         * @type Boolean
         */
        var _load = false;

        /**
         * Remove alert box.
         */
        function _hideMessages() {
            setTimeout(function () {
                $('.alert-box').remove();
            }, 5000);
        }

        /**
         * Remove alert tooltip.
         */
        function _hideTooltip() {
            setTimeout(function () {
                $('#alert-tooltip').remove();
            }, 500);
        }

        function _createMessage(message, type) {
            return $('<div>')
                .attr({'class': 'alert-box', role: 'alert'})
                .addClass('alert')
                .addClass(typeof (type) === 'undefined' ? 'alert-info' : type)
                .text(message);
        }

        return {
            /**
             * @param {string} url
             * @param {json} $data
             */
            post: function (url, $data) {
                if (_load === false) {
                    _load = true;
                    $.post(url, $data, $.proxy(function (data) {
                        _load = false;
                        this.showTooltip(data);
                        if (data.code == '200'){
                            layer.msg('OK');
                        }
                    }, this), 'json');
                }
            },
            /**
             * Show alert tooltip.
             * @param {json} $data
             */
            showTooltip: function ($data) {

                if ($('#alert-tooltip').length === 0) {
                    var $alert = $('<div>')
                        .attr({id: 'alert-tooltip'})
                        .addClass($data.length === 0 ? 'green' : 'red')
                        .append($('<span>')
                            .addClass('glyphicon')
                            .addClass($data.length === 0 ? ' glyphicon-ok' : 'glyphicon-remove'));

                    $('body').append($alert);
                    _hideTooltip();
                }
            },
            /**
             * Show messages.
             * @param {json} $data
             * @param {string} container
             */
            showMessages: function ($data, container) {

                if ($('.alert-box').length) {
                    $('.alert-box').append($data);
                } else {
                    $(typeof (container) === 'undefined' ? $('body').find('.container').eq(1) : container).prepend(_createMessage($data));
                    _hideMessages();
                }
            },
            /**
             * Show error messages.
             * @param {json} $data
             * @param {string} prefix
             */
            showErrorMessages: function ($data, prefix) {
                for (i in $data) {
                    var k = 0;
                    $messages = new Array();
                    if (typeof ($data[i]) === 'object') {
                        for (j in $data[i]) {
                            $messages[k++] = $data[i][j];
                        }
                    } else {
                        $messages[k++] = $data[i];
                    }

                    this.showErrorMessage($messages.join(' '), prefix + i);
                }
                _hideMessages();
            },
            /**
             * Show error message.
             * @param {string} message
             * @param {string} id
             */
            showErrorMessage: function (message, id) {
                $(id).next().html(_createMessage(message, 'alert-danger'));
            }
        };
    })();


    var translate = (function () {

        /**
         * @type string
         */
        var _originalMessage;

        /**
         * @param {object} $this
         */
        function _translateLanguage($this) {
            var $translation = $this.closest('tr').find('.translation');

            var data = {
                id: $translation.data('id'),
                language_id: <?= $lang_id?>,
                value: $.trim($translation.val())
            };

            helpers.post('/translate-json-key/update?id='+data.id, data);
        }

        /**
         * @param {object} $this
         */
        function _copySourceToTranslation($this) {
            var $translation = $this.closest('tr').find('.translation'),
                isEmptyTranslation = $.trim($translation.val()).length === 0,
                sourceMessage = $.trim($this.val());

            if (!isEmptyTranslation) {
                return;
            }

            $translation.val(sourceMessage);
            _translateLanguage($this);
        }

        return {
            init: function () {
                $('#translates').on('click', '.source', function () {
                    _copySourceToTranslation($(this));
                });
                $('#translates').on('click', 'button', function () {
                    _translateLanguage($(this));
                });
                $('#translates').on('focus', '.translation', function () {
                    _originalMessage = $.trim($(this).val());
                });
                $('#translates').on('blur', '.translation', function () {
                    if ($.trim($(this).val()) !== _originalMessage) {
                        _translateLanguage($(this).closest('tr').find('button'));
                    }
                });
                $('#translates').on('change', "#search-form select", function(){
                    $(this).parents("form").submit();
                });
            }
        };
    })();

    $(document).ready(function () {
        translate.init();
    });
</script>

