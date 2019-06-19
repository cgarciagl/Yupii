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

// Create Base64 Object
var Base64 = {
    _keyStr: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
    encode: function (e) {
        var t = "";
        var n, r, i, s, o, u, a;
        var f = 0;
        e = Base64._utf8_encode(e);
        while (f < e.length) {
            n = e.charCodeAt(f++);
            r = e.charCodeAt(f++);
            i = e.charCodeAt(f++);
            s = n >> 2;
            o = (n & 3) << 4 | r >> 4;
            u = (r & 15) << 2 | i >> 6;
            a = i & 63;
            if (isNaN(r)) {
                u = a = 64
            } else if (isNaN(i)) {
                a = 64
            }
            t = t + this._keyStr.charAt(s) + this._keyStr.charAt(o) + this._keyStr.charAt(u) + this._keyStr.charAt(a)
        }
        return t
    },
    decode: function (e) {
        var t = "";
        var n, r, i;
        var s, o, u, a;
        var f = 0;
        e = e.replace(/[^A-Za-z0-9\+\/\=]/g, "");
        while (f < e.length) {
            s = this._keyStr.indexOf(e.charAt(f++));
            o = this._keyStr.indexOf(e.charAt(f++));
            u = this._keyStr.indexOf(e.charAt(f++));
            a = this._keyStr.indexOf(e.charAt(f++));
            n = s << 2 | o >> 4;
            r = (o & 15) << 4 | u >> 2;
            i = (u & 3) << 6 | a;
            t = t + String.fromCharCode(n);
            if (u != 64) {
                t = t + String.fromCharCode(r)
            }
            if (a != 64) {
                t = t + String.fromCharCode(i)
            }
        }
        t = Base64._utf8_decode(t);
        return t
    },
    _utf8_encode: function (e) {
        e = e.replace(/\r\n/g, "\n");
        var t = "";
        for (var n = 0; n < e.length; n++) {
            var r = e.charCodeAt(n);
            if (r < 128) {
                t += String.fromCharCode(r)
            } else if (r > 127 && r < 2048) {
                t += String.fromCharCode(r >> 6 | 192);
                t += String.fromCharCode(r & 63 | 128)
            } else {
                t += String.fromCharCode(r >> 12 | 224);
                t += String.fromCharCode(r >> 6 & 63 | 128);
                t += String.fromCharCode(r & 63 | 128)
            }
        }
        return t
    },
    _utf8_decode: function (e) {
        var t = "";
        var n = 0;
        var r = c1 = c2 = 0;
        while (n < e.length) {
            r = e.charCodeAt(n);
            if (r < 128) {
                t += String.fromCharCode(r);
                n++
            } else if (r > 191 && r < 224) {
                c2 = e.charCodeAt(n + 1);
                t += String.fromCharCode((r & 31) << 6 | c2 & 63);
                n += 2
            } else {
                c2 = e.charCodeAt(n + 1);
                c3 = e.charCodeAt(n + 2);
                t += String.fromCharCode((r & 15) << 12 | (c2 & 63) << 6 | c3 & 63);
                n += 3
            }
        }
        return t
    }
}

/*yupiisearch plugin*/

$.fn.YupiiSearch = function (params) {
    params = $.extend({
        controller: "",
        filter: ""
    }, params);
    this.each(function () {
        var this_control = $(this);
        this_control.data('controller', params.controller.toLowerCase());
        this_control.data('filter', params.filter);
        if (!this_control.hasClass('yupiiffied')) {
            var b = $('<span class="input-group-addon">\n\
                    <i class="fa fa-search"></i>\n\
                   </span>');
            b.insertAfter(this_control);
            var e = $('<input type="hidden" class="searchhiddenfield" \n\
                            name="yupii_id_' + this_control.attr('name') + '" \n\
                            id="yupii_id_' + this_control.attr('name') + '">');
            e.insertAfter(b);
            this_control.addClass('yupiiffied');
            if (!(this_control.is('[readonly]'))) {
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
        }

        function searchinyupii(searched_text, forced) {
            if ((searched_text !== '') || (forced)) {
                var widget = this_control.parents('.yupii-widget').first();
                var widget_container = widget.parent();
                widget.hide();
                stackwidgets.push(widget);
                stacksearches.push(this_control);

                /* analizamos el filtro para la búsqueda */
                var filtro = trim(Base64.decode(this_control.data('filter')));
                var elem = filtro.substring(filtro.lastIndexOf("[") + 1, filtro.lastIndexOf("]"));
                while (elem != '') {
                    valueofelem = $('#' + elem).val();
                    filtro = filtro.split('[' + elem + ']').join(valueofelem);
                    elem = filtro.substring(filtro.lastIndexOf("[") + 1, filtro.lastIndexOf("]"));
                }
                if (filtro.lastIndexOf('function', 0) === 0) {
                    var f = eval('(' + filtro + ')');
                    filtro = f();
                }
                filtro = Base64.encode(filtro);

                var obj = {
                    sSearch: searched_text,
                    sFilter: filtro
                };
                if (typeof (yupii_csrf) !== "undefined") {
                    $.extend(obj, yupii_csrf);
                }
                var resultado = getValue(this_control.data('controller') + '/searchByAjax', obj);
                widget_container.hide();
                $(resultado).appendTo(widget_container);
                widget_container.fadeIn();
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

$.fn.dataTableExt.oApi.fnProcessingIndicator = function (oSettings, onoff) {
    if (typeof (onoff) == 'undefined') {
        onoff = true;
    }
    this.oApi._fnProcessingDisplay(oSettings, onoff);
};

function showControllerTableIn(selector, controller) {
    $(selector).html(
        getValue(controller + '/tableByAjax', yupii_csrf)
    );
}

function showControllerReportIn(selector, controller) {
    $(selector).html(
        getValue(controller + '/reportByAjax', yupii_csrf)
    );
}