/*
    @author: Igor Mirochnik
    @copyright:  Igor Mirochnik
    Site: http://ida-freewares.ru
    Site: http://im-cloud.ru
    Email: dev.imirochnik@gmail.com
    Type: commercial
*/

window.imrep = window.imst || {
    setTextStatus: function (container, _option) {
        var option = $.extend(true, {
                selector: '',
                text: '',
                status: '',
                inTable: false,
                onAnimate: null
            }, _option),
            item = container.find(option.selector),
            css = {
                'transition':'background-color 1s',
                'color': 'white'
            }
        ;
        
        item
        .css({
            'display': 'inline-block',
            'position': (!option.inTable ? 'absolute' : 'inherit'),
            'padding':'9px 10px',
            'border': '1px solid #eee',
            'margin-top': '-1px',
            //'margin-left': '10px',
            'background-color':'white',
            'color': '#666'
        })
        .html(option.text);

        if (option.status === 'fail') {
            item.stop(true,true).animate({ opacity: 0 }, 500, 'linear', function() {
                item
                .css({'color': 'white'})
                .css($.extend(css, {'background-color':'red'}))
                .animate({ opacity: 1 }, 1000, 'linear', function () {
                    if (typeof (option.onAnimate) === 'function') {
                        option.onAnimate(item);
                    }
                });
            });
        } else if (option.status === 'success') {
            item.stop(true,true).animate({ opacity: 0 }, 500, 'linear', function() {
                item
                .css({'color': 'white'})
                .css($.extend(css, {'background-color':'green'}))
                .animate({ opacity: 1 }, 1000, 'linear', function () {
                    if (typeof (option.onAnimate) === 'function') {
                        option.onAnimate(item);
                    }
                });
            });
        }
    },
    
    setTextFail: function (container, _option) {
        var option = $.extend(true, _option, { status: 'fail' })
        ;
        this.setTextStatus(container, option);
    },

    setTextSuccess: function (container, _option) {
        var option = $.extend(true, _option, { status: 'success' })
        ;
        this.setTextStatus(container, option);
    }
};
