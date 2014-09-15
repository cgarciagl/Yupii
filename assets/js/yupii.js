/*stack data implementation*/

function Stack() {
    this.cards = [];
    this.push = pushdata;
    this.pop = popdata;
    this.count = countdata;
    this.printStack = showStackData;
}

function pushdata(data) {
    this.cards.push(data);
}

function popdata() {
    return this.cards.pop();
}

function showStackData() {
    return this.cards;
}

function countdata() {
    return this.cards.length;
}

var stackwidgets = new Stack();
var stacksearches = new Stack();

/*yupiisearch plugin*/

$.fn.YupiiSearch = function (params) {
    params = $.extend({
        controller: "",
        filter: ""
    }, params);
    this.each(function () {
        var this_control = $(this);
        this_control.data('controller', params.controller);
        this_control.data('filter', params.filter);
        if (!this_control.hasClass('yupiiffied')) {
            var b = $('<span class="input-group-addon">\n\
                    <i class="glyphicon glyphicon-search"></i>\n\
                   </span>');
            b.insertAfter(this_control);
            var e = $('<input type="hidden" class="searchhiddenfield" \n\
                            name="yupii_id_' + this_control.attr('name') + '" \n\
                            id="yupii_id_' + this_control.attr('name') + '">');
            e.insertAfter(b);
            this_control.addClass('yupiiffied');
            this_control.change(function () {
                searchinyupii(this_control.val(), false);
            });
            this_control.keypress(function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault(true);
                    var inputs = $(this).parents("form").eq(0).find(":input:not(:hidden)");
                    var idx = inputs.index(this);
                    if (idx == inputs.length - 1) {
                        inputs[0].focus()
                    } else {
                        inputs[idx + 1].focus();
                    }
                }
            });
            b.click(function (e) {
                e.preventDefault();
                searchinyupii('', true);
            });
        }

        function searchinyupii(searched_text, forced) {
            if ((searched_text !== '') || (forced)) {
                var widget = this_control.parents('.yupii-widget').first();
                var widget_container = widget.parent();
                widget.hide();
                stackwidgets.push(widget);
                stacksearches.push(this_control);
                var obj = {
                    sSearch: searched_text
                };
                if (typeof (yupii_csrf) !== "undefined") {
                    $.extend(obj, yupii_csrf);
                }
                var resultado = get_value(this_control.data('controller') + '/searchByAjax', obj);
                $(resultado).appendTo(widget_container);
            }
            if ((searched_text === '') && (!forced)) {
                this_control.next().next('input[type=hidden]').val('');
            }
        }
    });
    return this;
};

$.fn.dataTableExt.oApi.fnStandingRedraw = function (oSettings) {
    if (oSettings.oFeatures.bServerSide === false) {
        var before = oSettings._iDisplayStart;
        oSettings.oApi._fnReDraw(oSettings);
        oSettings._iDisplayStart = before;
        oSettings.oApi._fnCalculateEnd(oSettings);
    }
    oSettings.oApi._fnDraw(oSettings);
};

function showControllerTableIn(selector, controller) {
    $(selector).html(
        get_value(controller + '/tableByAjax', yupii_csrf)
    );

}

function showControllerReportIn(selector, controller) {
    $(selector).html(
        get_value(controller + '/reportByAjax', yupii_csrf)
    );

}