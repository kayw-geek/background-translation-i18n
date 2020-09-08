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

    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = window.location.search.substr(1).match(reg);  //匹配目标参数
        if (r != null) return unescape(r[2]); return null; //返回参数值
    };
    /**
     * @param {object} $this
     */
    function _translateLanguage($this) {
        var $translation = $this.closest('tr').find('.translation');

        var data = {
            id: $translation.data('id'),
            language_id: getUrlParam('language_id'),
        value: $.trim($translation.val())
    };

        helpers.post('/translate/translate-json/update?id='+data.id, data);
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